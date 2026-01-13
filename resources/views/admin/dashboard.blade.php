@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-gray-100 min-h-screen px-4 py-6 mt-12 mb-26">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📊 Dashboard Restoran</h1>
            <div class="w-24 h-1 bg-yellow-400 rounded mt-2"></div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">120</p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">18</p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Menu Minuman</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">25</p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <p class="text-sm text-gray-500">Menu Snack</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">15</p>
            </div>

        </div>

        {{-- GRAFIK + TABEL --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- GRAFIK PENDAPATAN --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Pendapatan Per Hari
                </h2>

                <div class="w-full max-w-xl mx-auto">
                    <canvas id="incomeChart" height="200"></canvas>
                </div>
            </div>


            {{-- PESANAN TERBARU --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">
                    🧾 Pesanan Terbaru
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-semibold">Meja 1</p>
                            <p class="text-gray-500">Es Teh Manis (x2)</p>
                        </div>
                        <span class="text-green-600 font-semibold">Rp 10.000</span>
                    </div>

                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-semibold">Meja 3</p>
                            <p class="text-gray-500">Kentang Snack</p>
                        </div>
                        <span class="text-yellow-600 font-semibold">Rp 8.000</span>
                    </div>

                </div>
            </div>

        </div>

        {{-- TABEL DETAIL --}}
        <div class="bg-white rounded-lg shadow p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4">
                📋 Detail Pesanan
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
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-2">Meja 1</td>
                            <td class="py-3 px-2">Es Teh Manis</td>
                            <td class="py-3 px-2">2</td>
                            <td class="py-3 px-2">Rp 10.000</td>
                            <td class="py-3 px-2">
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-2">Meja 3</td>
                            <td class="py-3 px-2">Kentang</td>
                            <td class="py-3 px-2">1</td>
                            <td class="py-3 px-2">Rp 8.000</td>
                            <td class="py-3 px-2">
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">
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
    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('incomeChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($data),
                    backgroundColor: '#facc15',
                    borderRadius: 6,
                    barPercentage: 0.4,
                    categoryPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>

@endsection
