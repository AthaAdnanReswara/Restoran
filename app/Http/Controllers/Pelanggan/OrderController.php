<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Generate Snap Token Midtrans
     */
    /**
     * Generate Snap Token Midtrans
     *
     * Cashless:
     * draft -> ordered -> Midtrans
     *
     * Stok BELUM dikurangi di sini.
     * Stok hanya dikurangi setelah pembayaran berhasil.
     */
    public function generateSnapToken(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        // Pastikan session tersedia
        if (!$customerName || !$tableId || !$guestToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Session pelanggan tidak ditemukan.'
            ], 422);
        }

        try {

            $result = DB::transaction(function () use (
                $customerName,
                $tableId,
                $guestToken
            ) {

                /*
            |--------------------------------------------------------------------------
            | Ambil transaksi draft
            |--------------------------------------------------------------------------
            */

                $transactions = Transaction::with('menu')
                    ->where('guest_token', $guestToken)
                    ->where('table_id', $tableId)
                    ->where('status', 'draft')
                    ->lockForUpdate()
                    ->get();

                if ($transactions->isEmpty()) {
                    throw new \Exception(
                        'Tidak ada pesanan yang menunggu pembayaran.'
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | Buat Order ID Midtrans
            |--------------------------------------------------------------------------
            */

                $orderId = 'RESTO-' .
                    time() .
                    '-' .
                    strtoupper(Str::random(6));

                $totalHarga = 0;

                /*
            |--------------------------------------------------------------------------
            | Cek stok + hitung total
            |--------------------------------------------------------------------------
            */

                foreach ($transactions as $transaction) {

                    $menu = Menu::lockForUpdate()
                        ->find($transaction->menu_id);

                    if (!$menu) {
                        throw new \Exception(
                            "Menu dengan ID {$transaction->menu_id} tidak ditemukan."
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | Cegah quantity tidak valid
                |--------------------------------------------------------------------------
                */

                    if ($transaction->quantity <= 0) {
                        throw new \Exception(
                            "Quantity {$menu->name} tidak valid."
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | Cek stok
                |--------------------------------------------------------------------------
                */

                    if ($menu->stok < $transaction->quantity) {
                        throw new \Exception(
                            "Stok {$menu->name} tidak mencukupi. " .
                                "Stok tersedia: {$menu->stok}, " .
                                "jumlah dipesan: {$transaction->quantity}."
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | Hitung harga dari database
                |--------------------------------------------------------------------------
                */

                    $transactionTotal =
                        $menu->price * $transaction->quantity;

                    $transaction->update([
                        'price' => $menu->price,
                        'total_price' => $transactionTotal,
                    ]);

                    $totalHarga += $transactionTotal;
                }

                /*
            |--------------------------------------------------------------------------
            | Ubah draft -> ordered
            |--------------------------------------------------------------------------
            |
            | PENTING:
            | Di sinilah transaksi Cashless didaftarkan sebelum Midtrans.
            |
            */

                foreach ($transactions as $transaction) {

                    $transaction->update([
                        'status' => 'ordered',
                        'payment_method' => 'cashless',
                        'receipt' => json_encode([
                            'midtrans_order_id' => $orderId,
                            'payment_status' => 'pending',
                        ], JSON_UNESCAPED_UNICODE |
                            JSON_UNESCAPED_SLASHES),
                    ]);
                }

                /*
            |--------------------------------------------------------------------------
            | Parameter Midtrans
            |--------------------------------------------------------------------------
            */

                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $totalHarga,
                    ],

                    'customer_details' => [
                        'first_name' => $customerName,
                        'email' => 'pelanggan@example.com',
                    ],
                ];

                /*
            |--------------------------------------------------------------------------
            | Generate Snap Token
            |--------------------------------------------------------------------------
            */

                $snapToken = Snap::getSnapToken($params);

                return [
                    'snap_token' => $snapToken,
                    'order_id' => $orderId,
                ];
            });

            return response()->json([
                'status' => 'success',
                'snap_token' => $result['snap_token'],
                'order_id' => $result['order_id'],
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Callback pembayaran Midtrans
     *
     * capture / settlement
     *     -> stok dikurangi
     *     -> ordered menjadi accepted
     *
     * deny / cancel / expire / failure
     *     -> stok TIDAK dikurangi
     *     -> ordered menjadi cancelled
     */
    public function midtransCallback(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'transaction_status' => 'required|string',
            'payment_type' => 'nullable|string',
            'gross_amount' => 'nullable|numeric',
        ]);

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN BERHASIL
    |--------------------------------------------------------------------------
    */

        if (in_array($transactionStatus, [
            'capture',
            'settlement'
        ])) {

            try {

                DB::transaction(function () use (
                    $orderId,
                    $request
                ) {

                    /*
                |--------------------------------------------------------------------------
                | Cari transaksi berdasarkan order_id Midtrans
                |--------------------------------------------------------------------------
                */

                    $transactions = Transaction::where(
                        'status',
                        'ordered'
                    )
                        ->where(
                            'payment_method',
                            'cashless'
                        )
                        ->where(
                            'receipt',
                            'like',
                            '%"midtrans_order_id":"' .
                                $orderId .
                                '"%'
                        )
                        ->lockForUpdate()
                        ->get();

                    /*
                |--------------------------------------------------------------------------
                | Callback kedua / duplicate callback
                |--------------------------------------------------------------------------
                |
                | Kalau transaksi sudah accepted, query di atas tidak akan
                | menemukannya.
                |
                | Jadi stok tidak akan dikurangi dua kali.
                |
                */

                    if ($transactions->isEmpty()) {
                        throw new \Exception(
                            'Transaksi tidak ditemukan atau pembayaran sudah diproses.'
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | Proses setiap transaksi
                |--------------------------------------------------------------------------
                */

                    foreach ($transactions as $transaction) {

                        $menu = Menu::lockForUpdate()
                            ->find($transaction->menu_id);

                        if (!$menu) {
                            throw new \Exception(
                                "Menu dengan ID {$transaction->menu_id} tidak ditemukan."
                            );
                        }

                        /*
                    |--------------------------------------------------------------------------
                    | Cegah stok minus
                    |--------------------------------------------------------------------------
                    */

                        if ($menu->stok < $transaction->quantity) {
                            throw new \Exception(
                                "Stok {$menu->name} tidak mencukupi. " .
                                    "Stok tersedia: {$menu->stok}, " .
                                    "jumlah dipesan: {$transaction->quantity}."
                            );
                        }

                        /*
                    |--------------------------------------------------------------------------
                    | KURANGI STOK
                    |--------------------------------------------------------------------------
                    */

                        // $menu->decrement(
                        //     'stok',
                        //     $transaction->quantity
                        // );

                        /*
                    |--------------------------------------------------------------------------
                    | Simpan status pembayaran
                    |--------------------------------------------------------------------------
                    */

                        $transaction->update([
                            'status' => 'accepted',
                            'payment_method' => 'cashless',
                            'receipt' => json_encode([
                                'midtrans_order_id' => $orderId,
                                'transaction_status' => $transactionStatus,
                                'payment_type' => $request->input('payment_type'),
                                'gross_amount' => $request->input('gross_amount'),
                                'paid_at' => now()->toDateTimeString(),
                            ], JSON_UNESCAPED_UNICODE |
                                JSON_UNESCAPED_SLASHES),
                        ]);
                    }
                });

                return response()->json([
                    'status' => 'success',
                    'message' =>
                    'Pembayaran berhasil dan stok telah dikurangi.'
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 422);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN GAGAL
    |--------------------------------------------------------------------------
    */

        if (in_array($transactionStatus, [
            'deny',
            'cancel',
            'expire',
            'failure'
        ])) {

            Transaction::where(
                'status',
                'ordered'
            )
                ->where(
                    'payment_method',
                    'cashless'
                )
                ->where(
                    'receipt',
                    'like',
                    '%"midtrans_order_id":"' .
                        $orderId .
                        '"%'
                )
                ->update([
                    'status' => 'cancelled',
                    'receipt' => json_encode([
                        'midtrans_order_id' => $orderId,
                        'transaction_status' => $transactionStatus,
                        'payment_type' => $request->input('payment_type'),
                        'gross_amount' => $request->input('gross_amount'),
                        'cancelled_at' => now()->toDateTimeString(),
                    ], JSON_UNESCAPED_UNICODE |
                        JSON_UNESCAPED_SLASHES),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran gagal/dibatalkan. Stok tidak dikurangi.'
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | STATUS LAIN
    |--------------------------------------------------------------------------
    |
    | pending tidak boleh mengurangi stok.
    |
    */

        return response()->json([
            'status' => 'success',
            'message' =>
            'Status pembayaran belum berhasil. Stok belum dikurangi.'
        ]);
    }

    /**
     * Halaman utama pelanggan
     */
    public function index()
    {
        $tables = Table::orderBy('table_number')
            ->get()
            ->map(function ($t) {

                $t->status = trim(
                    strtolower($t->status ?? '')
                );

                return $t;
            });

        return view('pelanggan.index', [
            'tables' => $tables,
            'availableTablesCount' => Table::whereRaw(
                "LOWER(TRIM(status)) = 'available'"
            )->count(),
            'customerName' => session('customer_name'),
            'tableId' => session('table_id'),
        ]);
    }

    /**
     * Pilih pelanggan dan meja
     */
    public function setCustomer(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_id' => 'required|exists:tables,id',
        ]);

        // Pastikan meja masih tersedia
        $table = Table::where('id', $request->table_id)
            ->where('status', 'available')
            ->first();

        if (!$table) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Meja sudah dipilih oleh pelanggan lain. Silakan pilih meja lain.'
                );
        }

        // Tandai meja sebagai occupied
        $table->update([
            'status' => 'occupied'
        ]);

        // Token unik pelanggan
        $guestToken = Str::random(40);

        session([
            'customer_name' => $request->customer_name,
            'table_id' => $request->table_id,
            'guest_token' => $guestToken,
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Meja berhasil dipilih. Selamat menikmati!'
            );
    }

    /**
     * Konfirmasi pesanan
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,cashless',
        ]);

        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        /*
        |--------------------------------------------------------------------------
        | Cooldown 5 menit
        |--------------------------------------------------------------------------
        */
        $lastOrder = session('last_order_at');

        if ($lastOrder) {

            $expiresAt = Carbon::parse($lastOrder)
                ->addMinutes(5);

            if (Carbon::now()->lessThan($expiresAt)) {

                $remaining = Carbon::now()
                    ->diffInSeconds($expiresAt);

                return redirect()
                    ->route('pelanggan.order')
                    ->with(
                        'error',
                        "Tunggu beberapa saat sebelum memesan lagi (sisa " .
                            gmdate('i:s', $remaining) .
                            ")"
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan cart tidak kosong
        |--------------------------------------------------------------------------
        */
        $draftCount = Transaction::where(
            'customer_name',
            $customerName
        )
            ->where('table_id', $tableId)
            ->where('status', 'draft')
            ->count();

        if ($draftCount === 0) {

            return redirect()
                ->route('pelanggan.order')
                ->with(
                    'error',
                    'Keranjang kosong, tambahkan item terlebih dahulu'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Ubah draft -> ordered
        |--------------------------------------------------------------------------
        */
        Transaction::where(
            'guest_token',
            $guestToken
        )
            ->where('table_id', $tableId)
            ->where('status', 'draft')
            ->update([
                'status' => 'ordered',
                'payment_method' => $request->payment_method,
            ]);

        /*
        |--------------------------------------------------------------------------
        | CASHLESS
        |--------------------------------------------------------------------------
        */
        if ($request->payment_method === 'cashless') {

            session([
                'last_order_at' => Carbon::now()
                    ->toDateTimeString()
            ]);

            return redirect()
                ->route('pelanggan.payment.qris', [
                    'customer' => $customerName,
                    'table' => $tableId,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CASH
        |--------------------------------------------------------------------------
        |
        | Untuk cash, stok belum dikurangi di sini.
        | Stok dikurangi ketika pembayaran benar-benar dikonfirmasi.
        |
        */
        session([
            'last_order_at' => Carbon::now()
                ->toDateTimeString()
        ]);

        return redirect()
            ->route('pelanggan.order')
            ->with(
                'success',
                'Pesanan berhasil dikirim'
            );
    }

    /**
     * Update quantity cart
     */
    public function updateQty(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $trx = Transaction::with('menu')
            ->findOrFail($request->transaction_id);

        /*
        |--------------------------------------------------------------------------
        | Hanya draft yang boleh diubah
        |--------------------------------------------------------------------------
        */
        if ($trx->status !== 'draft') {

            return response()->json([
                'success' => false,
                'message' => 'Pesanan sudah dikirim dan tidak dapat diubah.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek stok ketika quantity diubah
        |--------------------------------------------------------------------------
        */
        if ($request->quantity > $trx->menu->stok) {

            return response()->json([
                'success' => false,
                'message' => 'Jumlah pesanan melebihi stok yang tersedia.'
            ], 422);
        }

        if ($request->quantity == 0) {

            $trx->delete();
        } else {

            $trx->update([
                'quantity' => $request->quantity,
                'total_price' =>
                $request->quantity * $trx->menu->price,
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Update catatan transaksi
     */
    public function updateNotes(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $trx = Transaction::findOrFail(
            $request->transaction_id
        );

        if ($trx->status !== 'draft') {

            return response()->json([
                'success' => false,
                'message' =>
                'Tidak dapat mengubah catatan setelah pesanan dikirim.'
            ], 422);
        }

        $trx->update([
            'notes' => $request->notes ?? null,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Tambah menu ke cart
     */
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
                'message' =>
                'Session pelanggan tidak ditemukan'
            ], 422);
        }

        $menu = Menu::findOrFail(
            $request->menu_id
        );

        /*
        |--------------------------------------------------------------------------
        | Cek stok
        |--------------------------------------------------------------------------
        */
        if ($menu->stok <= 0) {

            return response()->json([
                'success' => false,
                'message' =>
                "Stok {$menu->name} sedang habis."
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Cari transaksi draft yang sama
        |--------------------------------------------------------------------------
        */
        $trxQuery = Transaction::where(
            'menu_id',
            $menu->id
        )
            ->where(
                'guest_token',
                $guestToken
            )
            ->where(
                'table_id',
                $tableId
            )
            ->where(
                'status',
                'draft'
            );

        if ($request->filled('notes')) {

            $trxQuery->where(
                'notes',
                $request->notes
            );
        } else {

            $trxQuery->whereNull(
                'notes'
            );
        }

        $trx = $trxQuery->first();

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada di cart
        |--------------------------------------------------------------------------
        */
        if ($trx) {

            /*
            | Jangan sampai quantity melebihi stok
            */
            if ($trx->quantity >= $menu->stok) {

                return response()->json([
                    'success' => false,
                    'message' =>
                    "Jumlah {$menu->name} sudah mencapai stok yang tersedia."
                ], 422);
            }

            $trx->increment(
                'quantity'
            );

            $trx->update([
                'total_price' =>
                $trx->quantity * $menu->price
            ]);
        } else {

            /*
            |--------------------------------------------------------------------------
            | Buat transaksi baru
            |--------------------------------------------------------------------------
            */
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

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan ke keranjang.'
        ]);
    }

    /**
     * Hapus item dari cart
     */
    public function remove($id)
    {
        Transaction::where(
            'id',
            $id
        )
            ->where(
                'status',
                'draft'
            )
            ->delete();

        return back();
    }

    /**
     * Menampilkan cart
     */
    public function cart()
    {
        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        $items = Transaction::with('menu')
            ->where(
                'guest_token',
                $guestToken
            )
            ->where(
                'table_id',
                $tableId
            )
            ->where(
                'status',
                'draft'
            )
            ->get();

        $html = view(
            'pelanggan.partials.cart',
            compact('items')
        )->render();

        $modalHtml = view(
            'pelanggan.partials.order_summary',
            compact('items')
        )->render();

        $subtotal = $items->sum(
            'total_price'
        );

        if (
            request()->ajax() ||
            request()->wantsJson()
        ) {

            return response()->json([
                'html' => $html,
                'modalHtml' => $modalHtml,
                'subtotal' => $subtotal,
                'count' => $items->count(),
            ]);
        }

        return view(
            'pelanggan.partials.cart',
            compact('items')
        );
    }

    /**
     * Halaman QRIS
     */
    public function qris(Request $request)
    {
        $customer = $request->query(
            'customer'
        );

        $table = $request->query(
            'table'
        );

        $guestToken = session(
            'guest_token'
        );

        $items = Transaction::with('menu')
            ->where(
                'guest_token',
                $guestToken
            )
            ->where(
                'table_id',
                $table
            )
            ->where(
                'status',
                'ordered'
            )
            ->get();

        return view(
            'pelanggan.qris',
            compact(
                'items',
                'customer',
                'table'
            )
        );
    }

    /**
     * Konfirmasi pembayaran CASH oleh kasir
     *
     * ordered -> accepted
     * stok dikurangi setelah pembayaran dikonfirmasi.
     */
    public function markPaid(Request $request)
    {
        $request->validate([
            'customer' => 'required|string',
            'table' => 'required|integer',
        ]);

        $guestToken = session('guest_token');

        try {

            DB::transaction(function () use (
                $request,
                $guestToken
            ) {

                $query = Transaction::where('table_id', $request->table)
                    ->where('status', 'ordered')
                    ->where('payment_method', 'cash')
                    ->lockForUpdate();

                if ($guestToken) {
                    $query->where('guest_token', $guestToken);
                } else {
                    $query->where('customer_name', $request->customer);
                }

                $transactions = $query->get();

                if ($transactions->isEmpty()) {
                    throw new \Exception(
                        'Tidak ada pesanan Cash yang menunggu pembayaran.'
                    );
                }

                foreach ($transactions as $transaction) {

                    $menu = Menu::lockForUpdate()
                        ->find($transaction->menu_id);

                    if (!$menu) {
                        throw new \Exception(
                            'Menu tidak ditemukan.'
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | CEK STOK
                |--------------------------------------------------------------------------
                */

                    if ($menu->stok < $transaction->quantity) {
                        throw new \Exception(
                            "Stok {$menu->name} tidak mencukupi. " .
                                "Stok tersedia: {$menu->stok}, " .
                                "jumlah dipesan: {$transaction->quantity}."
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | BARU KURANGI STOK
                |--------------------------------------------------------------------------
                */

                    // $menu->decrement(
                    //     'stok',
                    //     $transaction->quantity
                    // );

                    /*
                |--------------------------------------------------------------------------
                | Tandai sudah dibayar
                |--------------------------------------------------------------------------
                */

                    $transaction->update([
                        'status' => 'accepted',
                        'payment_method' => 'cash',
                        'receipt' => json_encode([
                            'payment_method' => 'cash',
                            'paid_at' => now()->toDateTimeString(),
                        ], JSON_UNESCAPED_UNICODE |
                            JSON_UNESCAPED_SLASHES),
                    ]);
                }
            });
        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }

        return back()->with(
            'success',
            'Pembayaran Cash berhasil dikonfirmasi. Stok telah dikurangi.'
        );
    }

    /**
     * Sign out pelanggan
     */
    public function signOut(Request $request)
    {
        $tableId = session(
            'table_id'
        );

        $guestToken = session(
            'guest_token'
        );

        /*
        |--------------------------------------------------------------------------
        | Bebaskan meja
        |--------------------------------------------------------------------------
        */
        if ($tableId) {

            $table = Table::find(
                $tableId
            );

            if ($table) {

                $table->update([
                    'status' => 'available'
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus cart draft
        |--------------------------------------------------------------------------
        */
        if ($guestToken) {

            Transaction::where(
                'guest_token',
                $guestToken
            )
                ->where(
                    'status',
                    'draft'
                )
                ->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus session
        |--------------------------------------------------------------------------
        */
        $request->session()->forget([
            'customer_name',
            'table_id',
            'last_order_at',
            'guest_token'
        ]);

        return redirect()
            ->route('pelanggan.home')
            ->with(
                'success',
                'Berhasil sign out. Meja tersedia untuk pelanggan lain.'
            );
    }
}
