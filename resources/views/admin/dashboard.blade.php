@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Restoran
        </h1>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                <i class="bx bx-power-off"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">120</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">18</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Menu Minuman</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">25</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Menu Snack</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">15</p>
        </div>
    </div>

    <!-- Tabel Pesanan -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Pesanan Terbaru
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 px-2 text-left">No Meja</th>
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
                        <td class="py-3 px-2">Snack Kentang</td>
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
@endsection
