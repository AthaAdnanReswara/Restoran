@extends('layouts.app')

@section('content')
    <section id="header">
        <div class="info mt-2 flex justify-between shadow-lg p-8 rounded-2xl bg-white">
            <h3>Name: {{ session('customer_name') }}</h3>
            <h3>No Meja: {{ session('table_id') }}</h3>
        </div>
    </section>


    <section id="menu" class="mt-12 mb-24">
        <div class="flex justify-between items-center text-center mb-8 mx-2">
            <div>
                <h2 class="text-3xl font-bold">Menu</h2>
                <div class="underline h-1 w-24 bg-yellow-500 mx-auto mt-2 rounded"></div>
            </div>

            <div class="search md:w-auto relative">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#999"
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                    <path
                        d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                </svg>
                <input
                    class="w-full md:w-auto px-4 pl-10 py-2 rounded-lg shadow-md border-2 border-gray-200 focus:border-yellow-500 focus:outline-none transition"
                    type="text" id="search-input" placeholder="Search menu...">
            </div>
        </div>

        <div class="button-group flex justify-center items-center gap-4 mb-8 mx-2">
            <div class="filter gap-2 flex flex-wrap">
                <button class="active bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md text-sm md:text-base"
                    data-filter="all">All</button>
                <button class="bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition text-sm md:text-base"
                    data-filter="food">Makanan</button>
                <button class="bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition text-sm md:text-base"
                    data-filter="drink">Minuman</button>
                <button class="bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition text-sm md:text-base"
                    data-filter="snack">Makanan Ringan</button>
            </div>
        </div>

        @php
            $categoryLabels = [
                'food' => '🍽️ Makanan',
                'drink' => '🥤 Minuman',
                'snack' => '🍟 Makanan Ringan',
            ];
        @endphp

        @forelse ($menus as $category => $items)
            <div class="wrapper-menu mx-2 mb-10">

                <!-- TITLE CATEGORY -->
                <div class="category-title mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $categoryLabels[$category] ?? ucfirst($category) }}
                    </h3>
                    <div class="h-1 w-16 bg-yellow-500 rounded mt-1"></div>
                </div>

                <!-- MENU GRID -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                    @foreach ($items as $menu)
                        <div class="item-menu bg-white rounded-2xl shadow hover:shadow-lg transition p-3"
                            data-category="{{ $category }}" data-name="{{ strtolower($menu->name) }}">

                            <img class="rounded-xl w-full h-36 object-cover" src="{{ asset('storage/' . $menu->image) }}"
                                alt="{{ $menu->name }}">

                            <div class="info-menu mt-3 flex justify-between items-center">
                                <h3 class="font-semibold text-gray-800">
                                    {{ $menu->name }}
                                </h3>
                                <span class="font-bold text-yellow-500">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- ADD TO CART -->
                            <button data-menu="{{ $menu->id }}"
                                class="add-to-cart-btn w-full bg-yellow-500 text-white py-2 rounded-xl mt-2">
                                Masukan Pesanan
                            </button>
                        </div>
                    @endforeach

                </div>
            </div>

        @empty
            <p class="text-gray-500 italic text-center mt-10">
                No menu available.
            </p>
        @endforelse
    </section>
@endsection

@if (!session()->has('customer_name'))
    <div class="fixed inset-0 z-50 bg-gradient-to-br from-purple-900/90 via-purple-700/90 to-fuchsia-600/90 flex items-center justify-center">

    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl">

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-full bg-gradient-to-r from-purple-600 to-fuchsia-500 flex items-center justify-center shadow-md">
                <span class="text-2xl">🍽️</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mt-3">
                Selamat Datang
            </h2>

            <p class="text-purple-600 text-sm font-medium">
                Purple Cafe & Resto
            </p>
        </div>

        <form method="POST" action="{{ route('pelanggan.set.customer') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Masukkan Nama
                </label>

                <input
                    type="text"
                    name="customer_name"
                    placeholder="Nama pelanggan"
                    required
                    class="w-full rounded-lg border border-purple-200 px-4 py-2.5
                           focus:outline-none
                           focus:ring-2
                           focus:ring-purple-400
                           focus:border-purple-500">
            </div>

            <!-- Meja -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilih Meja
                </label>

                @if (isset($availableTablesCount) && $availableTablesCount > 0)

                <select
                    name="table_id"
                    required
                    class="w-full rounded-lg border border-purple-200 px-4 py-2.5
                           focus:outline-none
                           focus:ring-2
                           focus:ring-purple-400
                           focus:border-purple-500">

                    <option value="">-- Pilih Meja --</option>

                    @foreach ($tables as $table)
                        @php
                            $status = isset($table->status) ? trim(strtolower($table->status)) : '';
                            $disabled = $status !== 'available';
                        @endphp

                        <option value="{{ $table->id }}" {{ $disabled ? 'disabled' : '' }}>
                            Meja {{ $table->table_number }}
                            {{ $disabled ? ' • Terisi' : '' }}
                        </option>
                    @endforeach

                </select>

                @else

                <div class="px-4 py-3 rounded-lg bg-red-50 text-red-600 text-sm text-center">
                    Semua meja sedang terisi.
                </div>

                @endif
            </div>

            <!-- Button -->
            <button
                class="w-full bg-gradient-to-r from-purple-600 to-fuchsia-500
                       text-white py-2.5 rounded-lg font-semibold
                       hover:from-purple-700 hover:to-fuchsia-600
                       transition duration-300"
                {{ isset($availableTablesCount) && $availableTablesCount > 0 ? '' : 'disabled' }}>

                Masuk

            </button>

        </form>

    </div>

</div>
@endif

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const filterButtons = document.querySelectorAll('[data-filter]');
            const items = document.querySelectorAll('.item-menu');

            let activeFilter = 'all';

            function setActive(btn) {
                filterButtons.forEach(b => b.classList.remove('active', 'bg-yellow-500', 'text-white'));
                btn.classList.add('active', 'bg-yellow-500', 'text-white');
            }

            filterButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    activeFilter = this.getAttribute('data-filter');
                    setActive(this);
                    applyFilter();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', applyFilter);
            }

            function applyFilter() {
                const q = (searchInput && searchInput.value || '').trim().toLowerCase();

                items.forEach(item => {
                    const name = (item.getAttribute('data-name') || '').toLowerCase();
                    const cat = (item.getAttribute('data-category') || '').toLowerCase();

                    const matchesSearch = q === '' || name.includes(q);
                    const matchesCategory = activeFilter === 'all' || activeFilter === cat;

                    if (matchesSearch && matchesCategory) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
