<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Return pending orders HTML (grouped)
    public function pending()
    {
        // Include both newly ordered and accepted orders so accepted items remain visible
        $orders = Transaction::with('menu')
            ->whereIn('status', ['ordered', 'accepted'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(fn($item) => $item->guest_token ?: $item->created_at->format('Y-m-d H:i'));

        $html = view('pegawai.partials.orders', compact('orders'))->render();

        return response()->json(['html' => $html]);
    }

    // Accept all items for a given order time (group key) OR accept single transaction by id
    public function accept(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        if ($transactionId) {
            Transaction::where('id', $transactionId)->where('status', 'ordered')->update(['status' => 'accepted']);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function reject(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        if ($transactionId) {
            Transaction::where('id', $transactionId)->where('status', 'ordered')->update(['status' => 'cancelled']);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    // Mark transactions as completed (called when staff finishes preparing/delivering order)
    public function complete(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        if ($transactionId) {
            Transaction::where('id', $transactionId)
                ->whereIn('status', ['accepted'])
                ->update(['status' => 'completed']);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
