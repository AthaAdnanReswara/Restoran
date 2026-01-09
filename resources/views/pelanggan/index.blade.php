@extends('layouts.app')

@section('content')
    <section id="header">
        <div class="image">
            <img src="{{ asset('images/header.avif') }}" alt="" srcset="">
        </div>

        <div class="info mt-2 flex justify-between shadow-lg p-8 rounded-2xl bg-white">
            <h3>Name: Hikmal Raditya</h3>
            <h3>No Table: 16</h3>
        </div>
    </section>

    <section id="menu" class="mt-12 mb-24">
        <div class="title text-center mb-8">
            <h2 class="text-3xl font-bold">Menu</h2>
            <div class="underline h-1 w-24 bg-yellow-500 mx-auto mt-2 rounded"></div>
        </div>

        <div class="button-group flex justify-between mb-8 mx-2">
            <div class="filter">
                <button class="active" data-filter="all">All</button>
                <button data-filter="food">Food</button>
                <button data-filter="drink">Drink</button>
                <button data-filter="snack">Snack</button>
            </div>

            <div class="search grid place-items-end">
                <input class=" w-[70%]" type="text" id="search-input" placeholder="Search menu...">
            </div>
        </div>

        <div class="wrapper-menu grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
            <div class="item-menu rounded-2xl">
                <img class="rounded-2xl" src="{{ asset('images/burger.jpg') }}" alt="" srcset="">
                <div class="info-menu mt-2 flex justify-between items-center">
                    <h3 class="font-semibold">Burger</h3>
                    <span class="font-bold text-yellow-500">$5.00</span>
                </div>

                <div class="button-menu mt-2 flex justify-between items-center">
                    <button class="">+</button>
                    <p>0</p>
                    <button>-</button>
                </div>

                <div>
                    <button class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl">Add to Cart</button>
                </div>
            </div>
            <div class="item-menu rounded-2xl">
                <img class="rounded-2xl" src="{{ asset('images/burger.jpg') }}" alt="" srcset="">
                <div class="info-menu mt-2 flex justify-between items-center">
                    <h3 class="font-semibold">Burger</h3>
                    <span class="font-bold text-yellow-500">$5.00</span>
                </div>

                <div class="button-menu mt-2 flex justify-between items-center">
                    <button class="">+</button>
                    <p>0</p>
                    <button>-</button>
                </div>

                <div>
                    <button class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl">Add to Cart</button>
                </div>
            </div>
            <div class="item-menu rounded-2xl">
                <img class="rounded-2xl" src="{{ asset('images/burger.jpg') }}" alt="" srcset="">
                <div class="info-menu mt-2 flex justify-between items-center">
                    <h3 class="font-semibold">Burger</h3>
                    <span class="font-bold text-yellow-500">$5.00</span>
                </div>

                <div class="button-menu mt-2 flex justify-between items-center">
                    <button class="">+</button>
                    <p>0</p>
                    <button>-</button>
                </div>

                <div>
                    <button class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl">Add to Cart</button>
                </div>
            </div>
            <div class="item-menu rounded-2xl">
                <img class="rounded-2xl" src="{{ asset('images/burger.jpg') }}" alt="" srcset="">
                <div class="info-menu mt-2 flex justify-between items-center">
                    <h3 class="font-semibold">Burger</h3>
                    <span class="font-bold text-yellow-500">$5.00</span>
                </div>

                <div class="button-menu mt-2 flex justify-between items-center">
                    <button class="">+</button>
                    <p>0</p>
                    <button>-</button>
                </div>

                <div>
                    <button class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl">Add to Cart</button>
                </div>
            </div>
        </div>
    </section>
@endsection
