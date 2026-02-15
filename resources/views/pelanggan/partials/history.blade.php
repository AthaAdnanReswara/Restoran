@if ($transactions->count())
    @foreach ($transactions as $orderTime => $items)
        <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm mb-4">
            <div class="flex justify-between mb-3">
                <div>
                    <h3 class="font-bold text-lg">Order {{ $items->first()->created_at->format('d M Y H:i') }}</h3>
                    <p class="text-sm text-gray-500">Status: {{ ucfirst($items->first()->status) }}</p>
                </div>

                <span class="font-bold text-yellow-500 text-lg">Rp
                    {{ number_format($items->sum('total_price'), 0, ',', '.') }}</span>
            </div>

            <div class="border-t pt-3 text-sm text-gray-700 space-y-2">
                <div class="font-semibold">Items:</div>
                <ul class="list-disc list-inside">
                    @foreach ($items as $it)
                        <li>
                            {{ $it->menu->name }} &middot; x{{ $it->quantity }}
                            @if ($it->notes)
                                <div class="text-xs text-gray-500">Catatan: {{ $it->notes }}</div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
@else
    <div class="mt-10 mx-4 text-center text-gray-500 italic">Belum ada riwayat pesanan</div>
@endif
