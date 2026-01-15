<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::orderBy('category')->get()->groupBy('category');

        $tables = Table::orderBy('table_number')->get()->map(function ($t) {
            $t->status = trim(strtolower($t->status ?? ''));
            return $t;
        });

        return view('pelanggan.index', [
            'menus' => $menus,
            // pass all tables + available count for the modal logic
            'tables' => $tables,
            'availableTablesCount' => Table::whereRaw("LOWER(TRIM(status)) = 'available'")->count(),
            'customerName' => session('customer_name'),
            'tableId' => session('table_id'),
        ]);
    }

    public function order()
    {
        $customerName = session('customer_name');
        $tableId = session('table_id');
        $guestToken = session('guest_token');

        if (!$customerName || !$tableId) {
            return redirect()->route('pelanggan.home')
                ->with('error', 'Silakan isi nama dan pilih meja terlebih dahulu');
        }

        // CART (DRAFT)
        $cartItems = Transaction::with('menu')
            ->when($guestToken, fn($q) => $q->where('guest_token', $guestToken), fn($q) => $q->where('customer_name', $customerName))
            ->where('table_id', $tableId)
            ->where('status', 'draft')
            ->get();

        // RIWAYAT ORDER
        // show history for this customer only (not mixed with other customers at same table)
        $transactions = Transaction::with('menu')
            ->when($guestToken, fn($q) => $q->where('guest_token', $guestToken), fn($q) => $q->where('customer_name', $customerName))
            ->whereIn('status', ['ordered', 'accepted', 'completed'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m-d H:i'));

        return view('pelanggan.order', compact('cartItems', 'transactions'));
    }

    // return customer's history partial for polling
    public function status()
    {
        $customerName = session('customer_name');
        $guestToken = session('guest_token');

        $transactions = Transaction::with('menu')
            ->when($guestToken, fn($q) => $q->where('guest_token', $guestToken), fn($q) => $q->where('customer_name', $customerName))
            ->whereIn('status', ['ordered', 'accepted', 'completed'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m-d H:i'));

        $html = view('pelanggan.partials.history', compact('transactions'))->render();

        return response()->json(['html' => $html]);
    }


    public function transaction()
    {
        $customerName = session('customer_name');
        $guestToken = session('guest_token');
        $tableId = session('table_id');

        if (!$tableId || (!$customerName && !$guestToken)) {
            return redirect()->route('pelanggan.home')->with('error', 'Tidak ada transaksi untuk ditampilkan');
        }

        $transactions = Transaction::with('menu')
            ->when($guestToken, fn($q) => $q->where('guest_token', $guestToken), fn($q) => $q->where('customer_name', $customerName))
            ->where('table_id', $tableId)
            ->whereIn('status', ['ordered', 'accepted', 'completed'])
            ->orderBy('created_at', 'asc')
            ->get();

        if ($transactions->isEmpty()) {
            return view('pelanggan.transaction', [
                'items' => collect(),
                'total' => 0,
                'orderRef' => null,
                'placedAt' => null,
                'status' => null,
            ]);
        }

        // aggregate by menu_id so separate orders combine into one summary
        $grouped = $transactions->groupBy('menu_id')->map(function ($rows) {
            $menu = $rows->first()->menu;
            return (object) [
                'menu' => $menu,
                'quantity' => $rows->sum('quantity'),
                'total_price' => $rows->sum('total_price'),
            ];
        })->values();

        $total = $grouped->sum(fn($i) => $i->total_price);

        // pick a representative order reference and placedAt (earliest)
        $orderRef = 'TRX-' . $transactions->first()->id;
        $placedAt = $transactions->first()->created_at;

        // determine aggregate status: completed > accepted > ordered
        $status = 'ordered';
        if ($transactions->contains('status', 'accepted')) $status = 'accepted';
        if ($transactions->every(fn($t) => $t->status === 'completed')) $status = 'completed';

        return view('pelanggan.transaction', [
            'items' => $grouped,
            'total' => $total,
            'orderRef' => $orderRef,
            'placedAt' => $placedAt,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
