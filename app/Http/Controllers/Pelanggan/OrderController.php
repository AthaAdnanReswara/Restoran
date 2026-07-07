<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    public function generateSnapToken(Request $request)
    {
        // 1. Inisialisasi konfigurasi Midtrans SDK
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Siapkan data unik pesanan
        $orderId = 'RESTO-' . time() . '-' . rand(100, 999);
        $totalHarga = $request->input('total_harga');

        // 3. Susun payload parameters untuk dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalHarga,
            ],
            'customer_details' => [
                'first_name' => 'Pelanggan',
                'email' => 'pelanggan@example.com', // Opsional, sesuaikan jika ada auth()->user()->email
            ],
            // Membatasi opsi pembayaran di pop-up agar fokus ke QRIS, Gopay, atau ShopeePay
            'enabled_payments' => ['qris', 'gopay', 'shopeepay']
        ];

        try {
            $guestToken = session('guest_token');

            // 1. Update semua item di keranjang dan berikan Order ID yang sama
            Transaction::where('guest_token', $guestToken)
                ->where('status', 'draft')
                ->update([
                    'status' => 'ordered',
                    'payment_method' => 'cashless',
                    'notes' => $orderId // SEMENTARA: Jika belum ada kolom 'order_id' atau 'invoice' di tabel transactions, Anda bisa manfaatkan kolom 'notes' atau buat kolom baru lewat migration bernama 'order_id'
                ]);

            // 2. Request token ke Midtrans
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $tables = Table::orderBy('table_number')->get()->map(function ($t) {
            // normalize status to avoid casing/whitespace issues from DB
            $t->status = trim(strtolower($t->status ?? ''));
            return $t;
        });

        return view('pelanggan.index', [
            // pass all tables so view can show which are occupied
            'tables' => $tables,
            'availableTablesCount' => Table::whereRaw("LOWER(TRIM(status)) = 'available'")->count(),
            'customerName' => session('customer_name'),
            'tableId' => session('table_id'),
        ]);
    }

    public function setCustomer(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_id' => 'required|exists:tables,id',
        ]);

        // ensure the table is still available and reserve it atomically
        $table = Table::where('id', $request->table_id)->where('status', 'available')->first();
        if (!$table) {
            return redirect()->back()->with('error', 'Meja sudah dipilih oleh pelanggan lain. Silakan pilih meja lain.');
        }

        // mark table as occupied
        $table->update(['status' => 'occupied']);

        // generate guest token to uniquely identify this guest session
        $guestToken = Str::random(40);

        session([
            'customer_name' => $request->customer_name,
            'table_id' => $request->table_id,
            'guest_token' => $guestToken,
        ]);

        return redirect()->back()->with('success', 'Meja berhasil dipilih. Selamat menikmati!');
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,cashless',
        ]);

        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        // cooldown: prevent re-order within 5 minutes
        $lastOrder = session('last_order_at');
        if ($lastOrder) {
            $expiresAt = Carbon::parse($lastOrder)->addMinutes(5);
            if (Carbon::now()->lessThan($expiresAt)) {
                $remaining = Carbon::now()->diffInSeconds($expiresAt);
                return redirect()->route('pelanggan.order')
                    ->with('error', "Tunggu beberapa saat sebelum memesan lagi (sisa " . gmdate('i:s', $remaining) . ")");
            }
        }

        // ensure cart not empty
        $draftCount = Transaction::where('customer_name', $customerName)
            ->where('table_id', $tableId)
            ->where('status', 'draft')
            ->count();

        if ($draftCount === 0) {
            return redirect()->route('pelanggan.order')
                ->with('error', 'Keranjang kosong, tambahkan item terlebih dahulu');
        }

        // update draft transactions for this guest
        Transaction::where('guest_token', $guestToken)
            ->where('table_id', $tableId)
            ->where('status', 'draft')
            ->update([
                'status' => 'ordered',
                'payment_method' => $request->payment_method,
            ]);

        // If cashless, redirect user to a QRIS payment page
        if ($request->payment_method === 'cashless') {
            // set last order time
            session(['last_order_at' => Carbon::now()->toDateTimeString()]);
            return redirect()->route('pelanggan.payment.qris', [
                'customer' => $customerName,
                'table' => $tableId,
            ]);
        }

        // set last order time
        session(['last_order_at' => Carbon::now()->toDateTimeString()]);

        return redirect()->route('pelanggan.order')
            ->with('success', 'Pesanan berhasil dikirim');
    }

    public function updateQty(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $trx = Transaction::with('menu')->findOrFail($request->transaction_id);

        if ($request->quantity == 0) {
            $trx->delete();
        } else {
            $trx->update([
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $trx->menu->price,
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Update per-transaction notes (from cart textarea)
     */
    public function updateNotes(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $trx = Transaction::findOrFail($request->transaction_id);

        // only allow editing notes for draft items (before order submitted)
        if ($trx->status !== 'draft') {
            return response()->json(['success' => false, 'message' => 'Cannot edit notes after order submitted'], 422);
        }

        $trx->update([
            'notes' => $request->notes ?? null,
        ]);

        return response()->json(['success' => true]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        if (!$customerName || !$tableId) {
            return response()->json([
                'message' => 'Session pelanggan tidak ditemukan'
            ], 422);
        }

        $menu = Menu::findOrFail($request->menu_id);

        // try to find existing draft item with same menu and same notes (or both null)
        $trxQuery = Transaction::where('menu_id', $menu->id)
            ->where('guest_token', $guestToken)
            ->where('table_id', $tableId)
            ->where('status', 'draft');

        if ($request->filled('notes')) {
            $trxQuery->where('notes', $request->notes);
        } else {
            $trxQuery->whereNull('notes');
        }

        $trx = $trxQuery->first();

        if ($trx) {
            $trx->increment('quantity');
            $trx->update([
                'total_price' => $trx->quantity * $menu->price
            ]);
        } else {
            Transaction::create([
                'table_id' => $tableId,
                'menu_id' => $menu->id,
                'guest_token' => $guestToken,
                'customer_name' => $customerName,
                'quantity' => 1,
                'price' => $menu->price,
                'total_price' => $menu->price,
                'status' => 'draft',
                'notes' => $request->notes ?? null,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        Transaction::where('id', $id)
            ->where('status', 'draft')
            ->delete();

        return back();
    }

    public function cart()
    {
        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        $items = Transaction::with('menu')
            ->where('guest_token', $guestToken)
            ->where('table_id', $tableId)
            ->where('status', 'draft')
            ->get();

        // jika request AJAX, kembalikan HTML partial + subtotal + modal partial sebagai JSON
        $html = view('pelanggan.partials.cart', compact('items'))->render();
        $modalHtml = view('pelanggan.partials.order_summary', compact('items'))->render();
        $subtotal = $items->sum('total_price');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'html' => $html,
                'modalHtml' => $modalHtml,
                'subtotal' => $subtotal,
                'count' => $items->count(),
            ]);
        }

        return view('pelanggan.partials.cart', compact('items'));
    }

    // Show a simple QRIS page for cashless payment (placeholder)
    public function qris(Request $request)
    {
        $customer = $request->query('customer');
        $table = $request->query('table');
        $guestToken = session('guest_token');

        $items = Transaction::with('menu')
            ->where('guest_token', $guestToken)
            ->where('table_id', $table)
            ->where('status', 'ordered')
            ->get();

        return view('pelanggan.qris', compact('items', 'customer', 'table'));
    }

    // Mark pending cashless transactions as paid/completed
    public function markPaid(Request $request)
    {
        $request->validate([
            'customer' => 'required|string',
            'table' => 'required|integer',
        ]);

        // prefer guest_token when available
        $guestToken = session('guest_token');
        $q = Transaction::where('table_id', $request->table)
            ->where('status', 'ordered');

        if ($guestToken) {
            $q->where('guest_token', $guestToken);
        } else {
            $q->where('customer_name', $request->customer);
        }

        $q->update(['status' => 'accepted']);

        return redirect()->route('pelanggan.order')
            ->with('success', 'Pembayaran berhasil, pesanan terkirim');
    }

    // Sign out customer: free table and clear session
    public function signOut(Request $request)
    {
        $customer = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        if ($tableId) {
            $table = Table::find($tableId);
            if ($table) {
                $table->update(['status' => 'available']);
            }
        }

        // Optionally clear draft transactions for this guest
        if ($guestToken) {
            Transaction::where('guest_token', $guestToken)->where('status', 'draft')->delete();
        }

        // clear session keys
        $request->session()->forget(['customer_name', 'table_id', 'last_order_at', 'guest_token']);

        return redirect()->route('pelanggan.home')->with('success', 'Berhasil sign out. Meja tersedia untuk pelanggan lain.');
    }
}
