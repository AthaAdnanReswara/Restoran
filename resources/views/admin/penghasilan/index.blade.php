@extends('layouts.app')

@section('title', 'Laporan Penghasilan')

@section('content')
    <section class="mt-6 px-4 pb-20 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    💰 Laporan Penghasilan
                </h2>
                <div class="h-1 w-64 bg-yellow-500 rounded mt-2"></div>
            </div>
        </div>

        <!-- Total Penghasilan -->
        <div class="bg-white rounded-2xl shadow border p-6 mb-6">
            <p class="text-gray-500 text-sm">
                Total Penghasilan
            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-2">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </h2>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow border p-6 mb-6">

            <form method="GET">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>
                        <label class="text-sm font-medium">
                            Dari
                        </label>

                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-full mt-2 rounded-xl border-gray-300">
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Sampai
                        </label>

                        <input type="date" name="to" value="{{ request('to') }}"
                            class="w-full mt-2 rounded-xl border-gray-300">
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Pembayaran
                        </label>

                        <select name="payment_method" class="w-full mt-2 rounded-xl border-gray-300">

                            <option value="">Semua</option>

                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="cashless" {{ request('payment_method') == 'cashless' ? 'selected' : '' }}>
                                Cashless
                            </option>

                        </select>
                    </div>

                    <div class="flex items-end gap-2">

                        <button type="submit"
                            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl py-2 font-semibold transition">
                            Filter
                        </button>

                        <a href="{{ route('admin.penghasilan.print', request()->query()) }}" target="_blank"
                            class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white rounded-xl py-2 font-semibold transition">
                            🖨 Print
                        </a>

                    </div>

                </div>

            </form>

        </div>

        <!-- Desktop -->
        <div class="hidden sm:block bg-white rounded-2xl shadow border overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Meja</th>
                            <th class="px-4 py-3">Menu</th>
                            <th class="px-4 py-3 text-center">Qty</th>
                            <th class="px-4 py-3 text-center">Pembayaran</th>
                            <th class="px-4 py-3 text-right">Total</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y">

                        @forelse($transactions as $transaction)
                            <tr>

                                <td class="px-4 py-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $transaction->created_at->format('d M Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $transaction->customer_name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $transaction->table->table_number }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $transaction->menu->name }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $transaction->quantity }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ ucfirst($transaction->payment_method) }}
                                </td>

                                <td class="px-4 py-3 text-right font-bold text-green-600">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="py-8 text-center text-gray-500">

                                    Tidak ada data.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Mobile -->
        <div class="grid grid-cols-1 gap-4 sm:hidden mt-4">

            @forelse($transactions as $transaction)
                <div class="bg-white rounded-2xl shadow border p-4">

                    <div class="flex justify-between">

                        <h3 class="font-bold">
                            {{ $transaction->customer_name }}
                        </h3>

                        <span class="font-bold text-green-600">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </span>

                    </div>

                    <div class="mt-2 text-sm text-gray-600">

                        <p>Tanggal : {{ $transaction->created_at->format('d M Y') }}</p>

                        <p>Menu : {{ $transaction->menu->name }}</p>

                        <p>Meja : {{ $transaction->table->table_number }}</p>

                        <p>Qty : {{ $transaction->quantity }}</p>

                        <p>Pembayaran : {{ ucfirst($transaction->payment_method) }}</p>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-2xl shadow border p-6 text-center text-gray-500">

                    Tidak ada data.

                </div>
            @endforelse

        </div>

        <div class="mt-6">
            {{ $transactions->withQueryString()->links() }}
        </div>

    </section>
@endsection
