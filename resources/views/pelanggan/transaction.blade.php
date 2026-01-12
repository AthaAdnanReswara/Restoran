@extends('layouts.app')

@section('content')
    <section id="transaction" class="mt-4 mx-2 pb-20">
        <!-- Header -->
        <div class="flex flex-col justify-start items-start mb-6">
            <h2 class="text-3xl font-bold">Hey, Hikmal!</h2>
            <div class="underline h-1 w-46 bg-yellow-500 mt-2 rounded"></div>
            <p class="text-gray-600 mt-2">Thank you for your order! Hope you enjoy the food and come back again soon.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
            <h4 class="font-bold text-lg mb-3">Order Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order ID:</span>
                    <span class="font-semibold">#12345</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Placed:</span>
                    <span class="font-semibold">2024-06-15</span>
                </div>
                <div class="flex justify-between border-t pt-2 mt-2">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-yellow-500">$15.00</span>
                </div>
            </div>
        </div>

        <!-- Items List Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <h4 class="font-bold text-lg mb-4">Order Items</h4>
            <ul class="space-y-4">
                <li class="flex items-center gap-3 pb-4 border-b">
                    <img src="{{ asset('images/burger.jpg') }}" alt="Burger" class="w-16 h-16 rounded object-cover">
                    <div class="flex-1">
                        <p class="font-semibold">Burger</p>
                        <p class="text-sm text-gray-600">x2</p>
                    </div>
                    <p class="font-bold">$10.00</p>
                </li>
                <li class="flex items-center gap-3">
                    <img src="{{ asset('images/juice.jpg') }}" alt="Juice" class="w-16 h-16 rounded object-cover">
                    <div class="flex-1">
                        <p class="font-semibold">Juice</p>
                        <p class="text-sm text-gray-600">x1</p>
                    </div>
                    <p class="font-bold">$5.00</p>
                </li>
            </ul>

            {{-- Subtotal --}}
            <div class="border-t mt-4 pt-4 flex flex-col justify-start items-start">
                <div>
                    <span class="">Subtotal:</span>
                    <span class="">$15.00</span>
                </div>

                <div>
                    <span class="">Discount:</span>
                    <span class="">$15.00</span>
                </div>


            </div>

            <!-- Total -->
            <div class="border-t mt-4 pt-4 flex justify-between items-center">
                <span class="font-bold">Total:</span>
                <span class="font-bold text-xl text-yellow-500">$15.00</span>
            </div>
        </div>
    </section>
@endsection
