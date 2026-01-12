@extends('layouts.app')

@section('content')
    <section id="menu" class="mt-12 mb-24">
        <div class="flex justify-between items-center text-center mb-8 mx-2">
            <div>
                <h2 class="text-3xl font-bold">Menu</h2>
                <div class="underline h-1 w-24 bg-yellow-500 mx-auto mt-2 rounded"></div>
            </div>

            <div class="search md:w-auto relative">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#999" class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
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

        <div class="wrapper-menu mx-2">
            <div class="category-title mb-4">
                <h3 class="text-2xl font-bold">Food</h3>
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
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
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
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
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
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
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
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
            </div>

            <div class="category-title mb-4 mt-4">
                <h3 class="text-2xl font-bold">Drink</h3>
            </div>
            <div class="wrapper-menu grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/juice.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">Juice</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/juice.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">Juice</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/juice.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">Juice</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/juice.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">Juice</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
            </div>

            <div class="category-title mb-4 mt-4">
                <h3 class="text-2xl font-bold">Snack</h3>
            </div>
            <div class="wrapper-menu grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/snack.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">snack</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/snack.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">snack</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/snack.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">snack</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
                <div class="item-menu rounded-2xl">
                    <img class="rounded-2xl" src="{{ asset('images/snack.jpg') }}" alt="" srcset="">
                    <div class="info-menu mt-2 flex justify-between items-center">
                        <h3 class="font-semibold">snack</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu mt-2 flex justify-between items-center">
                        <button class="">+</button>
                        <p>0</p>
                        <button>-</button>
                    </div>

                    <div>
                        <button
                            class="w-full bg-yellow-500 text-white py-2 mt-2 rounded-2xl flex items-center justify-center gap-2 hover:bg-yellow-600 transition"><svg
                                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="white">
                                <path
                                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg> Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
