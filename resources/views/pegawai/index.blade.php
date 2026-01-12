@extends('layouts.app')

@section('content')
    <section id="menu" class="mt-10 mb-24">
        <div class="flex justify-center items-center text-center mb-8 mx-2">
            <div>
                <h1 class="text-3xl font-bold">List Orders</h1>
                <div class="underline h-1 w-36 bg-yellow-500 mx-auto mt-2 rounded"></div>
            </div>
        </div>

        <div class="wrapper-menu mx-2">
            <!-- Category -->
            <div class="category-title mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Food Orders</h3>
                <p class="text-sm text-gray-500">Incoming customer orders</p>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                <div
                    class="item-menu bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                    <!-- Image -->
                    <img class="w-full h-40 object-cover" src="{{ asset('images/burger.jpg') }}" alt="Burger">

                    <!-- Content -->
                    <div class="p-4">
                        <!-- Customer Info -->
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Customer</span>
                                <span class="font-semibold text-gray-800">Hikmal</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Table</span>
                                <span class="font-semibold text-yellow-500">#16</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button
                                class="w-1/2 bg-red-500 text-white py-2 rounded-xl flex items-center justify-center gap-2 hover:bg-red-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#e3e3e3">
                                    <path
                                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                                </svg>
                                Reject
                            </button>

                            <button
                                class="w-1/2 bg-green-500 text-white py-2 rounded-xl flex items-center justify-center gap-2 hover:bg-green-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                                Accept
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
