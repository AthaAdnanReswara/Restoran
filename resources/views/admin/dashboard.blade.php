@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-gray-100 min-h-screen px-4 sm:px-6 lg:px-8 py-6 mt-12 mb-24">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
            📊 Dashboard Restoran
        </h1>
        <div class="w-20 sm:w-24 h-1 bg-yellow-400 rounded mt-2"></div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">

        <div class="bg-white p-4 sm:p-5 rounded-xl shadow">
            <p class="text-xs sm:text-sm text-gray-500">Total Pesanan</p>
            <p class="text-2xl sm:text-3xl font-bold mt-2">120</p>
        </div>
        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOrders ?? 0 }}</p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ordersToday ?? 0 }}</p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Menu Minuman</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $drinksCount ?? 0 }}</p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Menu Snack</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $snackCount ?? 0 }}</p>
            </div>

        </div>

        {{-- GRAFIK + TABEL --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- GRAFIK PENDAPATAN --}}
            <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Pendapatan Per Hari
                </h2>

                <div class="w-full mx-auto">
                    <canvas id="incomeChart" height="320"></canvas>
                </div>
            </div>


            {{-- PESANAN TERBARU --}}
            <div class="bg-white p-6 rounded-lg shadow lg:col-span-1">
                <h2 class="text-lg font-semibold mb-4">
                    🧾 Pesanan Terbaru
                </h2>

                    <div class="space-y-4 text-sm">
                        @forelse($recentOrders as $r)
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-semibold">Meja {{ $r->table_id }}</p>
                                    <p class="text-gray-500">{{ $r->menu->name ?? '-' }} (x{{ $r->quantity }})</p>
                                </div>
                                <span class="text-green-600 font-semibold">Rp {{ number_format($r->total_price, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <div class="text-gray-500">Belum ada pesanan</div>
                        @endforelse
                    </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl shadow">
            <p class="text-xs sm:text-sm text-gray-500">Menu Snack</p>
            <p class="text-2xl sm:text-3xl font-bold mt-2">15</p>
        </div>

    </div>

    {{-- GRAFIK + PESANAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- GRAFIK --}}
        <div class="bg-white rounded-xl shadow p-4 sm:p-6 lg:col-span-2">
            <h2 class="text-base sm:text-lg font-semibold mb-4">
                📈 Pendapatan Per Hari
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b text-gray-600">
                            <th class="py-3 px-2 text-left">Meja</th>
                            <th class="py-3 px-2 text-left">Menu</th>
                            <th class="py-3 px-2 text-left">Jumlah</th>
                            <th class="py-3 px-2 text-left">Total</th>
                            <th class="py-3 px-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactionsList as $t)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-2">Meja {{ $t->table_id }}</td>
                                <td class="py-3 px-2">{{ $t->menu->name ?? '-' }}</td>
                                <td class="py-3 px-2">{{ $t->quantity }}</td>
                                <td class="py-3 px-2">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-2">
                                    @php
                                        $status = $t->status;
                                        $badge = 'bg-gray-100 text-gray-700';
                                        if ($status === 'completed') { $badge = 'bg-green-100 text-green-600'; }
                                        if ($status === 'accepted') { $badge = 'bg-yellow-100 text-yellow-600'; }
                                        if ($status === 'cancelled') { $badge = 'bg-red-100 text-red-600'; }
                                    @endphp
                                    <span class="px-3 py-1 text-xs rounded-full {{ $badge }}">{{ ucfirst($status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-center text-gray-500">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-xl shadow p-4 sm:p-6 mt-8">
        <h2 class="text-base sm:text-lg font-semibold mb-4">
            📋 Detail Pesanan
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs sm:text-sm">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 px-3 text-left">Meja</th>
                        <th class="py-3 px-3 text-left">Menu</th>
                        <th class="py-3 px-3 text-left">Qty</th>
                        <th class="py-3 px-3 text-left">Total</th>
                        <th class="py-3 px-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-3">Meja 1</td>
                        <td class="py-3 px-3">Es Teh</td>
                        <td class="py-3 px-3">2</td>
                        <td class="py-3 px-3">Rp 10.000</td>
                        <td class="py-3 px-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                Selesai
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-3">Meja 3</td>
                        <td class="py-3 px-3">Kentang</td>
                        <td class="py-3 px-3">1</td>
                        <td class="py-3 px-3">Rp 8.000</td>
                        <td class="py-3 px-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">
                                Diproses
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('incomeChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($data),
                backgroundColor: '#facc15',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
