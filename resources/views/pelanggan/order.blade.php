@extends('layouts.app')

@section('content')
    <section id="orderList" class="pb-40 md:pt-24">
        <div class="mt-6 mx-4">
            <h2 class="text-4xl font-bold text-gray-900">List All Order</h2>
            <div class="h-1 w-16 bg-yellow-500 mt-3 rounded-full"></div>
        </div>

        <div class="wrapper-menu mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4">
            <div class="item-menu rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                <img class="rounded-2xl w-full object-cover h-48" src="{{ asset('images/burger.jpg') }}" alt="Burger">
                <div class="p-4">
                    <div class="info-menu flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Burger</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu flex justify-between items-center bg-gray-100 rounded-lg p-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">+</button>
                        <p class="font-semibold">10</p>
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">-</button>
                    </div>
                </div>
            </div>

            <div class="item-menu rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                <img class="rounded-2xl w-full object-cover h-48" src="{{ asset('images/juice.jpg') }}" alt="Juice">
                <div class="p-4">
                    <div class="info-menu flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Juice</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu flex justify-between items-center bg-gray-100 rounded-lg p-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">+</button>
                        <p class="font-semibold">0</p>
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">-</button>
                    </div>
                </div>
            </div>

            <div class="item-menu rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                <img class="rounded-2xl w-full object-cover h-48" src="{{ asset('images/snack.jpg') }}" alt="Snack">
                <div class="p-4">
                    <div class="info-menu flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Snack</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu flex justify-between items-center bg-gray-100 rounded-lg p-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">+</button>
                        <p class="font-semibold">0</p>
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">-</button>
                    </div>
                </div>
            </div>

            <div class="item-menu rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                <img class="rounded-2xl w-full object-cover h-48" src="{{ asset('images/snack.jpg') }}" alt="Snack">
                <div class="p-4">
                    <div class="info-menu flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Snack</h3>
                        <span class="font-bold text-yellow-500">$5.00</span>
                    </div>

                    <div class="button-menu flex justify-between items-center bg-gray-100 rounded-lg p-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">+</button>
                        <p class="font-semibold">0</p>
                        <button
                            class="w-8 h-8 flex items-center justify-center text-lg font-semibold hover:bg-yellow-500 hover:text-white rounded transition">-</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 mx-4">
            <h2 class="text-4xl font-bold text-gray-900">Order History</h2>
            <div class="h-1 w-16 bg-yellow-500 mt-3 rounded-full"></div>
        </div>

        <div class="transaction-list mt-6 px-4 space-y-4">
            <div
                class="transaction-item border border-gray-200 rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-900">Order #12345</h3>
                        <p class="text-sm text-gray-500 mt-1">Date: 2024-06-15</p>
                    </div>
                    <span class="font-bold text-yellow-500 text-lg">$25.00</span>
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <p class="text-gray-700 text-sm">Items: Burger, Juice, Snack</p>
                </div>
            </div>

            <div
                class="transaction-item border border-gray-200 rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-900">Order #12344</h3>
                        <p class="text-sm text-gray-500 mt-1">Date: 2024-06-14</p>
                    </div>
                    <span class="font-bold text-yellow-500 text-lg">$15.00</span>
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <p class="text-gray-700 text-sm">Items: Juice, Snack</p>
                </div>
            </div>
        </div>

        <div class="mt-8 mx-4 bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-gray-600 text-sm">Total Amount</p>
                    <p class="text-3xl font-bold text-gray-900">Rp54.000</p>
                </div>
                <button id="promoBtn"
                    class="px-5 py-2 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-100 transition font-medium text-sm cursor-pointer">
                    Add Promo Code
                </button>
            </div>

            <div class="grid place-items-center">
                <button id="orderNowBtn"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-3 rounded-lg mt-2 flex items-center gap-2 font-semibold transition shadow-md cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="currentColor">
                        <path
                            d="M269-120q-30 0-52-20t-27-49l-70-491h120v-80q0-33 23.5-56.5T320-840h320q33 0 56.5 23.5T720-760v80h120l-70 491q-5 29-27.5 49T690-120H269Zm-57-480 57 400h422l57-400H212Zm226 320 198-198-57-56-141 141-57-57-57 57 114 113ZM320-680h320v-80H320v80Zm160 280Z" />
                    </svg>
                    Order Now
                </button>
            </div>
        </div>

        <!-- Modal Promo Code -->
        <div id="promoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl p-8 w-96 max-w-[90%]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Apply Promo Code</h3>
                    <button id="closePromoBtn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>

                <form id="promoForm" class="space-y-4">
                    <div>
                        <label for="promoCode" class="block text-sm font-semibold text-gray-700 mb-2">Promo Code</label>
                        <input type="text" id="promoCode" name="promo_code" placeholder="Enter promo code"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" id="cancelPromoBtn"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-semibold">
                            Apply Code
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Order Confirmation -->
        <div id="orderModal"
            class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg m-4 my-8">
                <!-- Header -->
                <div class="border-b border-gray-200 p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-gray-900">Order Confirmation</h3>
                        <button id="closeOrderBtn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-6">
                    <!-- Order Items Summary -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h4>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3 max-h-48 overflow-y-auto">
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div>
                                    <p class="font-semibold text-gray-900">Burger</p>
                                    <p class="text-sm text-gray-600">Qty: 10</p>
                                </div>
                                <p class="font-semibold text-gray-900">$50.00</p>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div>
                                    <p class="font-semibold text-gray-900">Juice</p>
                                    <p class="text-sm text-gray-600">Qty: 0</p>
                                </div>
                                <p class="font-semibold text-gray-900">$0.00</p>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <div>
                                    <p class="font-semibold text-gray-900">Snack</p>
                                    <p class="text-sm text-gray-600">Qty: 0</p>
                                </div>
                                <p class="font-semibold text-gray-900">$0.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-b border-gray-200 py-4">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-gray-600">Subtotal</p>
                            <p class="font-semibold text-gray-900">Rp54.000</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold text-gray-900">Total</p>
                            <p class="text-2xl font-bold text-yellow-500">Rp54.000</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <form id="orderForm" class="space-y-4">
                        <div>
                            <label class="block text-lg font-semibold text-gray-900 mb-4">Payment Method</label>
                            <div class="space-y-3">
                                <!-- Cash Option -->
                                <label
                                    class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="cash" checked
                                        class="w-5 h-5 text-yellow-500 cursor-pointer">
                                    <div class="ml-4 flex-1">
                                        <p class="font-semibold text-gray-900">Cash</p>
                                        <p class="text-sm text-gray-600">Pay when order arrives</p>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm0 2c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4z">
                                        </path>
                                    </svg>
                                </label>

                                <!-- Cashless Option -->
                                <label
                                    class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="cashless"
                                        class="w-5 h-5 text-yellow-500 cursor-pointer">
                                    <div class="ml-4 flex-1">
                                        <p class="font-semibold text-gray-900">Cashless</p>
                                        <p class="text-sm text-gray-600">Bank transfer, e-wallet, or card</p>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h10m4 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="button" id="cancelOrderBtn"
                                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-semibold">
                                Confirm Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // ===== PROMO MODAL =====
        const promoBtn = document.getElementById('promoBtn');
        const promoModal = document.getElementById('promoModal');
        const closePromoBtn = document.getElementById('closePromoBtn');
        const cancelPromoBtn = document.getElementById('cancelPromoBtn');
        const promoForm = document.getElementById('promoForm');
        const promoCode = document.getElementById('promoCode');

        // Open promo modal
        promoBtn.addEventListener('click', () => {
            promoModal.classList.remove('hidden');
            promoCode.focus();
        });

        // Close promo modal function
        function closePromoModal() {
            promoModal.classList.add('hidden');
            promoCode.value = '';
        }

        // Close promo modal button
        closePromoBtn.addEventListener('click', closePromoModal);
        cancelPromoBtn.addEventListener('click', closePromoModal);

        // Close promo modal when clicking outside
        promoModal.addEventListener('click', (e) => {
            if (e.target === promoModal) {
                closePromoModal();
            }
        });

        // Handle promo form submission
        promoForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const code = promoCode.value.trim();

            if (code) {
                alert(`Promo code "${code}" applied successfully!`);
                closePromoModal();
                // Tambahkan logika untuk send ke backend di sini
            } else {
                alert('Please enter a promo code');
            }
        });

        // ===== ORDER MODAL =====
        const orderNowBtn = document.getElementById('orderNowBtn');
        const orderModal = document.getElementById('orderModal');
        const closeOrderBtn = document.getElementById('closeOrderBtn');
        const cancelOrderBtn = document.getElementById('cancelOrderBtn');
        const orderForm = document.getElementById('orderForm');

        // Open order modal
        orderNowBtn.addEventListener('click', () => {
            orderModal.classList.remove('hidden');
        });

        // Close order modal function
        function closeOrderModal() {
            orderModal.classList.add('hidden');
        }

        // Close order modal button
        closeOrderBtn.addEventListener('click', closeOrderModal);
        cancelOrderBtn.addEventListener('click', closeOrderModal);

        // Close order modal when clicking outside
        orderModal.addEventListener('click', (e) => {
            if (e.target === orderModal) {
                closeOrderModal();
            }
        });

        // Handle order form submission
        orderForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            alert(`Order confirmed!\nPayment Method: ${paymentMethod === 'cash' ? 'Cash' : 'Cashless'}`);
            closeOrderModal();
            // Tambahkan logika untuk send ke backend di sini
        });

        // Close modals with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (!promoModal.classList.contains('hidden')) {
                    closePromoModal();
                }
                if (!orderModal.classList.contains('hidden')) {
                    closeOrderModal();
                }
            }
        });
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
@endsection
