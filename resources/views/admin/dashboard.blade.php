@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-gray-100 min-h-screen px-4 sm:px-6 lg:px-8 py-6 mt-12 mb-24">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">📊 Dashboard Restoran</h1>
            <div class="w-20 sm:w-24 h-1 bg-yellow-400 rounded mt-2"></div>
        </div>

        {{-- Statistik ringkas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold mt-2">{{ $totalOrders ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Pesanan Hari Ini</p>
                <p class="text-2xl font-bold mt-2">{{ $ordersToday ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Menu Minuman</p>
                <p class="text-2xl font-bold mt-2">{{ $drinksCount ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Menu Snack</p>
                <p class="text-2xl font-bold mt-2">{{ $snackCount ?? 0 }}</p>
            </div>
        </div>

        {{-- Grafik + Pesanan Terbaru --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-4 lg:col-span-2 h-80">
                <h2 class="text-lg font-semibold mb-4">📈 Pendapatan Per Hari</h2>
                <div class="h-full">
                    <canvas id="incomeChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">🧾 Pesanan Terbaru</h2>
                <div class="space-y-3 text-sm">
                    @forelse($recentOrders as $r)
                        <div class="flex justify-between items-start border-b pb-2">
                            <div>
                                <p class="font-semibold">Meja {{ $r->table_id }}</p>
                                <p class="text-gray-500">{{ $r->menu->name ?? '-' }} &middot; x{{ $r->quantity }}</p>
                                <p class="text-xs text-gray-400">{{ $r->created_at->diffForHumans() ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp {{ number_format($r->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada pesanan</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Tabel transaksi (ringkas dan rapi) --}}
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-base font-semibold mb-4">📋 Daftar Transaksi</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b text-gray-600">
                            <th class="py-3 px-2 text-left">#</th>
                            <th class="py-3 px-2 text-left">Meja</th>
                            <th class="py-3 px-2 text-left">Menu</th>
                            <th class="py-3 px-2 text-left">Qty</th>
                            <th class="py-3 px-2 text-left">Total</th>
                            <th class="py-3 px-2 text-left">Status</th>
                            <th class="py-3 px-2 text-left">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactionsList as $i => $t)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-2">{{ $i + 1 }}</td>
                                <td class="py-3 px-2">Meja {{ $t->table_id }}</td>
                                <td class="py-3 px-2">{{ $t->menu->name ?? '-' }}</td>
                                <td class="py-3 px-2">{{ $t->quantity }}</td>
                                <td class="py-3 px-2">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-2">
                                    @php
                                        $status = $t->status ?? '';
                                        $badge = 'bg-gray-100 text-gray-700';
                                        if ($status === 'completed') {
                                            $badge = 'bg-green-100 text-green-600';
                                        }
                                        if ($status === 'accepted') {
                                            $badge = 'bg-yellow-100 text-yellow-600';
                                        }
                                        if ($status === 'cancelled') {
                                            $badge = 'bg-red-100 text-red-600';
                                        }
                                    @endphp
                                    <span
                                        class="px-3 py-1 text-xs rounded-full {{ $badge }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td class="py-3 px-2 text-xs text-gray-500">
                                    {{ optional($t->created_at)->format('d M H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('incomeChart');
        if (ctx) {
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
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
@endsection
