@php
    $items = $items ?? collect();
@endphp

@if ($items->isEmpty())
    <div class="col-span-full text-center py-12">
        <div class="inline-flex flex-col items-center gap-3">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h18v4H3V3zM3 11h18v10H3V11z" />
                </svg>
            </div>
            <p class="text-gray-500 italic">Belum ada pesanan</p>
        </div>
    </div>
@endif

@foreach ($items as $item)
    <div class="bg-white rounded-2xl shadow-sm p-4 flex gap-4 items-center">
        <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
            @if ($item->menu->image)
                <img src="{{ asset('storage/' . $item->menu->image) }}" alt="{{ $item->menu->name }}"
                    class="w-full h-full object-cover">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            @endif
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-4">
                <div class="truncate">
                    <h3 class="font-semibold text-gray-800 truncate">{{ $item->menu->name }}</h3>
                    @if ($item->notes)
                        <p class="text-sm text-gray-600 mt-1">Catatan: {{ $item->notes }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($item->menu->price, 0, ',', '.') }} / pcs
                    </p>
                </div>

                <div class="text-right">
                    <div class="text-sm font-semibold text-yellow-500">Rp
                        {{ number_format($item->total_price, 0, ',', '.') }}</div>
                    <button onclick="removeFromCart({{ $item->id }})"
                        class="text-xs text-red-500 hover:text-red-600 mt-1">Hapus</button>
                </div>
            </div>

            <div class="mt-3 flex items-center gap-2">
                <button onclick="updateQty({{ $item->id }}, {{ max(0, $item->quantity - 1) }})"
                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">−</button>
                <div class="w-10 text-center font-medium">{{ $item->quantity }}</div>
                <button onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})"
                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">+</button>
            </div>
        </div>
    </div>
@endforeach
