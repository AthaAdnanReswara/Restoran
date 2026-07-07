<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class laporan extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('status', 'completed');

        // Jika filter tidak digunakan, tampilkan data hari ini
        if (
            !$request->filled('from') &&
            !$request->filled('to') &&
            !$request->filled('payment_method')
        ) {
            $query->whereDate('created_at', today());
        } else {

            // Filter tanggal
            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->to);
            }

            // Filter metode pembayaran
            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }
        }

        $transactions = $query->latest()->paginate(10);

        $totalIncome = (clone $query)->sum('total_price');

        return view('admin.penghasilan.index', compact(
            'transactions',
            'totalIncome'
        ));
    }

    public function print(Request $request)
    {
        $query = Transaction::where('status', 'completed');

        // Jika tidak ada filter, tampilkan hari ini
        if (
            !$request->filled('from') &&
            !$request->filled('to') &&
            !$request->filled('payment_method')
        ) {
            $query->whereDate('created_at', today());
        } else {

            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->to);
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }
        }

        $transactions = $query->latest()->get();

        $totalIncome = $query->sum('total_price');

        return view('admin.penghasilan.print', compact(
            'transactions',
            'totalIncome'
        ));
    }
}
