<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // === DATA GRAFIK PENDAPATAN PER HARI ===
        $incomePerDay = DB::table('transactions')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('status', 'completed')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC')
            ->get();

        // Format untuk Chart.js
        $labels = $incomePerDay->map(
            fn($item) =>
            Carbon::parse($item->date)->format('d M')
        );

        $data = $incomePerDay->map(
            fn($item) =>
            (int) $item->total
        );

        // Additional metrics for admin dashboard
        $totalOrders = Transaction::count();
        $ordersToday = Transaction::whereDate('created_at', Carbon::today())->count();
        $drinksCount = Menu::where('category', 'drink')->count();
        $snackCount = Menu::where('category', 'snack')->count();

        // Recent orders (latest 5 transactions)
        $recentOrders = Transaction::with('menu')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Transactions list for table (latest 10)
        $transactionsList = Transaction::with('menu')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Group transactions by guest_token when available (so items from same customer/session
        // are combined), otherwise fallback to created_at minute to group near-simultaneous items.
        $groupedOrders = Transaction::with('menu')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->guest_token ?: $item->created_at->format('Y-m-d H:i'));

        // Recent grouped orders (max 5 groups)
        $recentGroups = $groupedOrders->take(5);

        // if route belongs to pegawai area, show pegawai index (now accessible to admin)
        if (request()->routeIs('pegawai.*')) {
            return view('pegawai.index', compact('user'));
        }

        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('labels', 'data', 'totalOrders', 'ordersToday', 'drinksCount', 'snackCount', 'recentGroups', 'transactionsList', 'groupedOrders'));
        }

        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk membuka halaman ini .');
    }
}
