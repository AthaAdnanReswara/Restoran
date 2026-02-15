@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-gray-100 min-h-screen px-4 sm:px-6 lg:px-8 py-6 mt-12 mb-24">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">📊 Dashboard Restoran</h1>
            <div class="w-20 sm:w-24 h-1 bg-yellow-400 rounded mt-2"></div>
        </div>

        {{-- Statistik ringkas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold mt-2">{{ $totalOrders ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Pesanan Hari Ini</p>
                <p class="text-2xl font-bold mt-2">{{ $ordersToday ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Menu Minuman</p>
                <p class="text-2xl font-bold mt-2">{{ $drinksCount ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-xs text-gray-500">Menu Snack</p>
                <p class="text-2xl font-bold mt-2">{{ $snackCount ?? 0 }}</p>
            </div>
        </div>

        {{-- Grafik + Pesanan Terbaru --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-4 lg:col-span-2 h-80">
                <h2 class="text-lg font-semibold mb-4">📈 Pendapatan Per Hari</h2>
                <div class="h-full">
                    <canvas id="incomeChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">🧾 Pesanan Terbaru</h2>
                <div class="space-y-3 text-sm">
                    @forelse($recentGroups as $groupKey => $items)
                        @php $first = $items->first(); @endphp
                        <div class="flex justify-between items-start border-b pb-2">
                            <div>
                                <p class="font-semibold">Meja {{ $first->table_id }}</p>
                                <p class="text-gray-500">{{ $items->pluck('menu.name')->unique()->join(', ') ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $first->created_at->diffForHumans() ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp
                                    {{ number_format($items->sum('total_price'), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada pesanan</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent grouped orders (latest 5) --}}
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-base font-semibold mb-4">📋 Pesanan Terbaru (5 terakhir)</h2>

            @if ($recentGroups->isEmpty())
                <div class="py-6 text-center text-gray-500">Belum ada pesanan</div>
            @else
                <div class="space-y-4">
                    @foreach ($recentGroups as $orderTime => $items)
                        @php
                            $first = $items->first();
                            $orderStatus = $items->contains('status', 'accepted')
                                ? 'accepted'
                                : ($items->contains('status', 'ordered')
                                    ? 'ordered'
                                    : $items->pluck('status')->first());
                        @endphp

                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <div class="text-sm text-gray-500">Customer</div>
                                    <div class="font-semibold">{{ $first->customer_name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">Meja: {{ $first->table_id }}</div>
                                </div>

                                <div class="text-right">
                                    <div class="text-xs text-gray-500">Dipesan</div>
                                    <div class="font-medium">{{ $items->first()->created_at->format('d M Y H:i') }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">Payment: {{ $first->payment_method ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-3">
                                <ul class="space-y-2 text-sm">
                                    @foreach ($items as $it)
                                        <li class="flex justify-between">
                                            <div>
                                                <div class="font-medium">{{ $it->menu->name ?? '-' }} <span
                                                        class="text-xs text-gray-500">x{{ $it->quantity }}</span></div>
                                                @if ($it->notes)
                                                    <div class="text-xs text-gray-500">Catatan: {{ $it->notes }}</div>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <div class="font-semibold">Rp
                                                    {{ number_format($it->total_price, 0, ',', '.') }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="text-sm text-gray-600">Total: <span class="font-semibold text-yellow-500">Rp
                                            {{ number_format($items->sum('total_price'), 0, ',', '.') }}</span></div>

                                    <div class="flex items-center gap-3">
                                        @php
                                            $badgeClass = 'bg-gray-100 text-gray-700';
                                            if ($orderStatus === 'completed') {
                                                $badgeClass = 'bg-green-100 text-green-600';
                                            }
                                            if ($orderStatus === 'accepted') {
                                                $badgeClass = 'bg-yellow-100 text-yellow-600';
                                            }
                                            if ($orderStatus === 'cancelled') {
                                                $badgeClass = 'bg-red-100 text-red-600';
                                            }
                                        @endphp
                                        <span
                                            class="px-3 py-1 text-xs rounded-full {{ $badgeClass }}">{{ ucfirst($orderStatus) }}</span>

                                        {{-- print button removed from admin dashboard; printing handled in Pegawai orders page --}}
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden printable content for this order --}}
                            <div class="print-content hidden">
                                <h2>Struk Pesanan</h2>
                                <div>Order: {{ $items->first()->created_at->format('d M Y H:i') }}</div>
                                <div>Meja: {{ $first->table_id }}</div>
                                <div>Customer: {{ $first->customer_name }}</div>
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
                </div>
            @endif
        </div>

    </div>

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('incomeChart');
        if (ctx) {
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
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
    <script>
        // print order handler: open a new window with printable content
        (function() {
            document.querySelectorAll('.print-order-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const orderCard = btn.closest('div.border.rounded-lg');
                    if (!orderCard) return;
                    const printable = orderCard.querySelector('.print-content');
                    if (!printable) return;

                    const w = window.open('', '_blank');
                    const html = `
                        <html>
                        <head>
                        <title>Struk Pesanan</title>
                        <style>body{font-family: Arial, Helvetica, sans-serif; padding:20px}</style>
                        </head>
                        <body>${printable.innerHTML}</body>
                        </html>
                    `;
                    w.document.open();
                    w.document.write(html);
                    w.document.close();
                    w.focus();
                    // small delay to allow resources to render
                    setTimeout(() => {
                        w.print();
                    }, 300);
                });
            });
        })();
    </script>
@endsection
