@extends('layouts.app')

@section('content')
    <section class="py-12">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Pembayaran Cashless (QRIS)</h2>

            <p class="text-sm text-gray-600 mb-4">Scan QR di bawah untuk melakukan pembayaran.</p>

            <div class="flex justify-center mb-6">
                <div class="w-56 h-56 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                    @if (file_exists(public_path('images/qris.jpeg')))
                        <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS"
                            class="w-full h-full object-contain rounded-lg">
                    @else
                        <span class="text-center">
                            QRIS<br>Placeholder
                        </span>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <h3 class="font-semibold">Ringkasan Pesanan</h3>
                <ul class="mt-2 space-y-2 text-sm text-gray-700">
                    @forelse ($items as $item)
                        <li class="flex justify-between">
                            <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500">Tidak ada pesanan untuk pembayaran.</li>
                    @endforelse
                </ul>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-xl font-bold">Rp {{ number_format($items->sum('total_price'), 0, ',', '.') }}</p>
                </div>

                <form method="POST" action="{{ route('pelanggan.payment.qris.paid') }}">
                    @csrf
                    <input type="hidden" name="customer" value="{{ $customer }}">
                    <input type="hidden" name="table" value="{{ $table }}">
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Saya sudah bayar</button>
                </form>
            </div>
        </div>
    </section>
@endsection
