@foreach ($orders as $orderTime => $items)
    <div class="item-menu bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-4 md:p-6">
            <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Customer</span>
                        <span class="font-semibold text-gray-800">{{ $items->first()->customer_name }}</span>
                    </div>

                    <div class="ml-3 flex flex-col">
                        <span class="text-xs text-gray-500">Table</span>
                        <span
                            class="inline-block px-3 py-1 rounded-full bg-yellow-50 text-yellow-600 font-semibold">#{{ $items->first()->table_id }}</span>
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-xs text-gray-500">Ordered at</div>
                    <div class="text-sm text-gray-700">{{ $items->first()->created_at->format('d M Y H:i') }}
                    </div>
                    <div class="mt-1 text-xs text-gray-500">Payment: <span
                            class="font-medium text-gray-700">{{ $items->first()->payment_method ?? '-' }}</span></div>
                </div>
            </header>

            <div class="border-t pt-4 text-sm text-gray-700">
                <ul class="space-y-3">
                    @foreach ($items as $item)
                        <li class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center text-gray-400">
                                    <!-- optional: thumbnail placeholder -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $item->menu->name }}</div>
                                    <div class="text-xs text-gray-500">Rp
                                        {{ number_format($item->menu->price, 0, ',', '.') }} each</div>
                                    @if ($item->notes)
                                        <div class="text-xs text-gray-500 mt-1">Catatan: {{ $item->notes }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-800">x{{ $item->quantity }}</div>
                                <div class="text-xs text-gray-500">Rp
                                    {{ number_format($item->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4 pt-3 border-t space-y-3">
                    <div class="text-sm text-gray-600">
                        <div>Total items: <span class="font-medium text-gray-800">{{ $items->sum('quantity') }}</span>
                        </div>
                        <div class="mt-1">Total: <span class="font-semibold text-yellow-500">Rp
                                {{ number_format($items->sum('total_price'), 0, ',', '.') }}</span></div>
                    </div>

                    <div class="flex gap-3 w-full sm:w-auto items-center justify-center">
                        @foreach ($items as $item)
                            <input type="hidden" class="trx-id" value="{{ $item->id }}">
                        @endforeach

                        @php
                            $hasOrdered = $items->contains('status', 'ordered');
                            $hasAccepted = $items->contains('status', 'accepted');
                        @endphp

                        @if ($hasOrdered)
                            <button data-order="{{ $orderTime }}"
                                class="reject-btn px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition">Reject</button>
                            <button data-order="{{ $orderTime }}"
                                class="accept-btn px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl transition">Accept</button>
                        @elseif($hasAccepted)
                            <button data-order="{{ $orderTime }}"
                                class="complete-btn px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">Completed</button>
                            <!-- Print button shown only when order has been accepted -->
                            <button type="button"
                                class="print-order-btn px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-xl text-sm">Print</button>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden printable content for this order --}}
        <div class="print-content hidden">
            <h2 class="text-lg font-bold">Struk Pesanan</h2>
            <div>Order: {{ $items->first()->created_at->format('d M Y H:i') }}</div>
            <div>Meja: {{ $items->first()->table_id }}</div>
            <div>Customer: {{ $items->first()->customer_name }}</div>
            <hr />
            @foreach ($items as $it)
                <div>{{ $it->menu->name }} x{{ $it->quantity }} - Rp
                    {{ number_format($it->total_price, 0, ',', '.') }}</div>
                @if ($it->notes)
                    <div>Catatan: {{ $it->notes }}</div>
                @endif
            @endforeach
            <hr />
            <div>Total: Rp {{ number_format($items->sum('total_price'), 0, ',', '.') }}</div>
        </div>
    </div>
@endforeach
