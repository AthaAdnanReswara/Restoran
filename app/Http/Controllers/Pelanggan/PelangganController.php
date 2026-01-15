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
        return view('pelanggan.transaction');
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
