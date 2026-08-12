<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

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

        if (!$transactionId) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID tidak ditemukan.'
            ], 400);
        }

        try {
            DB::transaction(function () use ($transactionId) {

                // Kunci transaksi agar tidak diproses dua kali
                $transaction = Transaction::lockForUpdate()
                    ->where('id', $transactionId)
                    ->where('status', 'ordered')
                    ->first();

                if (!$transaction) {
                    throw new \Exception(
                        'Pesanan tidak ditemukan atau sudah diproses.'
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | KURANGI STOK SAAT ACCEPT
            |--------------------------------------------------------------------------
            */

                $menu = Menu::lockForUpdate()
                    ->find($transaction->menu_id);

                if (!$menu) {
                    throw new \Exception(
                        'Menu tidak ditemukan.'
                    );
                }

                if ($transaction->quantity <= 0) {
                    throw new \Exception(
                        "Quantity {$menu->name} tidak valid."
                    );
                }

                if ($menu->stok < $transaction->quantity) {
                    throw new \Exception(
                        "Stok {$menu->name} tidak mencukupi. " .
                            "Stok tersedia: {$menu->stok}, " .
                            "jumlah dipesan: {$transaction->quantity}."
                    );
                }

                // Kurangi stok
                $menu->decrement(
                    'stok',
                    $transaction->quantity
                );

                /*
            |--------------------------------------------------------------------------
            | UBAH STATUS MENJADI ACCEPTED
            |--------------------------------------------------------------------------
            */

                $transaction->update([
                    'status' => 'accepted'
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Pesanan diterima dan stok berhasil dikurangi.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
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
    /**
     * Menyelesaikan pesanan.
     *
     * accepted -> completed
     *
     * Stok baru dikurangi di sini.
     */
    public function complete(Request $request)
    {
        $transactionId = $request->input('transaction_id');

        if (!$transactionId) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID tidak ditemukan.'
            ], 400);
        }

        try {

            $transaction = Transaction::where('id', $transactionId)
                ->where('status', 'accepted')
                ->first();

            if (!$transaction) {

                $existing = Transaction::find($transactionId);

                if ($existing && $existing->status === 'completed') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pesanan ini sudah diselesaikan.'
                    ], 422);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan atau belum berstatus accepted.'
                ], 422);
            }

            // Hanya mengubah status
            $transaction->update([
                'status' => 'completed'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diselesaikan.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
