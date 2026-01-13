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

        <div class="bg-white p-4 sm:p-5 rounded-xl shadow">
            <p class="text-xs sm:text-sm text-gray-500">Hari Ini</p>
            <p class="text-2xl sm:text-3xl font-bold mt-2">18</p>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl shadow">
            <p class="text-xs sm:text-sm text-gray-500">Menu Minuman</p>
            <p class="text-2xl sm:text-3xl font-bold mt-2">25</p>
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

            <div class="relative w-full h-64 sm:h-72">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>

        {{-- PESANAN TERBARU --}}
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow">
            <h2 class="text-base sm:text-lg font-semibold mb-4">
                🧾 Pesanan Terbaru
            </h2>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <p class="font-semibold">Meja 1</p>
                        <p class="text-gray-500 text-xs">Es Teh Manis (x2)</p>
                    </div>
                    <span class="text-green-600 font-semibold">
                        Rp 10.000
                    </span>
                </div>

                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <p class="font-semibold">Meja 3</p>
                        <p class="text-gray-500 text-xs">Kentang Snack</p>
                    </div>
                    <span class="text-yellow-600 font-semibold">
                        Rp 8.000
                    </span>
                </div>
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
