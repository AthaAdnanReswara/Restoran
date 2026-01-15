@extends('layouts.app')

@section('content')
    <section id="transaction" class="mt-4 mx-2 pb-20">
        <!-- Header -->
        <div class="flex flex-col justify-start items-start mb-6">
            <h2 class="text-3xl font-bold">Order Summary</h2>
            <div class="underline h-1 w-46 bg-yellow-500 mt-2 rounded"></div>
            <p class="text-gray-600 mt-2">Ringkasan pesanan Anda. Jika memesan terpisah, semuanya terakumulasi di sini.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
            <h4 class="font-bold text-lg mb-3">Order Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Ref:</span>
                    <span class="font-semibold">{{ $orderRef ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Placed At:</span>
                    <span class="font-semibold">{{ $placedAt ? $placedAt->format('d M Y H:i') : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span
                        class="font-semibold text-sm {{ $status === 'completed' ? 'text-green-600' : ($status === 'accepted' ? 'text-blue-600' : 'text-yellow-600') }}">{{ ucfirst($status ?? '-') }}</span>
                </div>
                <div class="flex justify-between border-t pt-2 mt-2">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-yellow-500">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Items List Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <h4 class="font-bold text-lg mb-4">Order Items</h4>
            @if (($items ?? collect())->isEmpty())
                <p class="text-center text-gray-500">Tidak ada item untuk ditampilkan.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($items as $it)
                        <li class="flex items-center gap-3 pb-4 border-b">
                            <div class="w-16 h-16 rounded overflow-hidden bg-gray-100 flex items-center justify-center">
                                @if (isset($it->menu->image) && $it->menu->image)
                                    <img src="{{ asset('storage/' . $it->menu->image) }}" alt="{{ $it->menu->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $it->menu->name }}</p>
                                <p class="text-sm text-gray-600">x{{ $it->quantity }}</p>
                            </div>
                            <p class="font-bold">Rp {{ number_format($it->total_price, 0, ',', '.') }}</p>
                        </li>
                    @endforeach
                </ul>

                {{-- Subtotal --}}
                <div class="border-t mt-4 pt-4 flex flex-col justify-start items-start">
                    <div class="flex justify-between w-full">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t mt-4 pt-4 flex justify-between items-center">
                    <span class="font-bold">Total:</span>
                    <span class="font-bold text-xl text-yellow-500">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>
    </section>
@endsection
