@extends('layouts.app')

@section('content')
    <section id="header">
        <div class="info mt-2 flex justify-between shadow-lg p-8 rounded-2xl bg-white">
            <h3>Name: {{ session('customer_name') }}</h3>
            <h3>No Table: {{ session('table_id') }}</h3>
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
                    data-filter="food">Food</button>
                <button class="bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition text-sm md:text-base"
                    data-filter="drink">Drink</button>
                <button class="bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition text-sm md:text-base"
                    data-filter="snack">Snack</button>
            </div>
        </div>

        @php
            $categoryLabels = [
                'food' => '🍽️ Food',
                'drink' => '🥤 Drink',
                'snack' => '🍟 Snack',
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
                        <div class="item-menu bg-white rounded-2xl shadow hover:shadow-lg transition p-3">

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

                            <!-- QTY -->
                            <div class="flex items-center justify-between mt-2">
                                <button onclick="decreaseMenuQty({{ $menu->id }})"
                                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200">−</button>

                                <span id="menu-qty-{{ $menu->id }}" class="font-semibold">0</span>

                                <button onclick="increaseMenuQty({{ $menu->id }})"
                                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200">+</button>
                            </div>

                            <!-- ADD TO CART -->
                            <button
                                onclick="addToCart({
                                    menu_id: {{ $menu->id }},
                                    name: '{{ $menu->name }}',
                                    price: {{ $menu->price }},
                                    image: '{{ $menu->image }}'
                                })"
                                class="w-full bg-yellow-500 text-white py-2 rounded-xl mt-2">
                                Add to Cart
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
    <div class="fixed inset-0 z-999 bg-black/70 flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl">

            <h2 class="text-2xl font-bold text-center mb-6">
                🍽️ Welcome
            </h2>

            <form method="POST" action="{{ route('pelanggan.set.customer') }}">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">
                        Your Name
                    </label>
                    <input type="text" name="customer_name"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-yellow-300" required>
                </div>

                <!-- Meja -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1">
                        Select Table
                    </label>
                    <select name="table_id" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-yellow-300"
                        required>
                        <option value="">-- Choose Table --</option>
                        @foreach ($tables as $table)
                            <option value="{{ $table->id }}">
                                Table {{ $table->table_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button
                    class="w-full bg-yellow-500 text-white py-3 rounded-xl font-semibold
                       hover:bg-yellow-600 transition">
                    Start Order
                </button>
            </form>

        </div>
    </div>
@endif
