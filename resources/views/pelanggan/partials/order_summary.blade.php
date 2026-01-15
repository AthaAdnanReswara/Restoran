<div>
    <h4 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h4>

    <div id="orderModalItems" class="bg-gray-50 rounded-lg p-4 space-y-3 max-h-48 overflow-y-auto">
        @php $subtotal = 0; @endphp

        @forelse ($items as $item)
            @php $subtotal += $item->total_price; @endphp

            <div class="flex justify-between items-center py-2 border-b">
                <div>
                    <p class="font-semibold">{{ $item->menu->name }}</p>
                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                </div>
                <p class="font-semibold">
                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                </p>
            </div>
        @empty
            <p class="text-center text-gray-500 text-sm">
                Tidak ada pesanan
            </p>
        @endforelse
    </div>

    <!-- Total -->
    <div class="border-t border-b border-gray-200 py-4 mt-4">
        <div class="flex justify-between items-center mb-2">
            <p class="text-gray-600">Subtotal</p>
            <p id="orderModalSubtotal" class="font-semibold text-gray-900">
                Rp{{ number_format($items->sum('total_price') ?: $subtotal, 0, ',', '.') }}
            </p>
        </div>

        <div class="flex justify-between items-center">
            <p class="text-lg font-bold text-gray-900">Total</p>
            <p id="orderModalTotal" class="text-2xl font-bold text-yellow-500">
                Rp{{ number_format($subtotal, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>
