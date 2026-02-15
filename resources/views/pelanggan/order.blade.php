@extends('layouts.app')

@section('content')
    <section id="orderList" class="pb-40 md:pt-24">
        <div class="mt-6 mx-4">
            <h2 class="text-4xl font-bold text-gray-900">List All Order</h2>
            <div class="h-1 w-55 bg-yellow-500 mt-3 rounded-full"></div>
        </div>

        <div id="cartList" class="wrapper-menu mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4">
            @include('pelanggan.partials.cart', ['items' => $cartItems])
        </div>


        <div class="mt-8 mx-4 relative bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="mt-5">
                    <p class="text-gray-600 text-sm">Total Amount</p>
                    <p id="cartTotal" class="text-3xl font-bold text-gray-900">Rp
                        {{ number_format($cartItems->sum('total_price'), 0, ',', '.') }}</p>
                </div>
                <button id="promoBtn"
                    class="px-5 py-2 absolute top-5 right-5 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-100 transition font-medium text-sm cursor-pointer">
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

        <div class="transaction-list mt-6 px-4 space-y-4">
            <div class="mt-10 mx-4">
                <h2 class="text-4xl font-bold text-gray-900">Order History</h2>
                <div class="h-1 w-55 bg-yellow-500 mt-3 rounded-full"></div>
            </div>

            <div id="orderHistoryContainer" class="mt-6">
                @include('pelanggan.partials.history', ['transactions' => $transactions])
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

                    <div id="orderSummaryContainer">
                        @include('pelanggan.partials.order_summary', ['items' => $cartItems])
                    </div>

                    <!-- Payment Method -->
                    <form id="orderForm" method="POST" action="{{ route('pelanggan.order.confirm') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-lg font-semibold text-gray-900 mb-4">
                                Payment Method
                            </label>

                            <div class="space-y-3">
                                <!-- Cash -->
                                <label
                                    class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="cash" checked
                                        class="w-5 h-5 text-yellow-500">
                                    <div class="ml-4 flex-1">
                                        <p class="font-semibold text-gray-900">Cash</p>
                                        <p class="text-sm text-gray-600">
                                            Pay when order arrives
                                        </p>
                                    </div>
                                </label>

                                <!-- Cashless -->
                                <label
                                    class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="cashless"
                                        class="w-5 h-5 text-yellow-500">
                                    <div class="ml-4 flex-1">
                                        <p class="font-semibold text-gray-900">Cashless</p>
                                        <p class="text-sm text-gray-600">
                                            E-wallet / Transfer / QRIS
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-4">
                            <button type="button" id="cancelOrderBtn"
                                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">
                                Cancel
                            </button>

                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-semibold">
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

        // // Handle order form submission
        // orderForm.addEventListener('submit', (e) => {
        //     e.preventDefault();
        //     const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        //     alert(`Order confirmed!\nPayment Method: ${paymentMethod === 'cash' ? 'Cash' : 'Cashless'}`);
        //     closeOrderModal();
        //     // Tambahkan logika untuk send ke backend di sini
        // });

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
    <script>
        // Auto sign-out pelanggan after 5 minutes (300000 ms) of inactivity
        (function() {
            const SIGNOUT_TIMEOUT = 5 * 60 * 1000; // 5 minutes
            let timer = null;

            const resetTimer = () => {
                if (timer) clearTimeout(timer);
                timer = setTimeout(() => {
                    // perform sign out via POST
                    fetch("{{ route('pelanggan.signout') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            auto: true
                        })
                    }).then(() => {
                        if (window.Swal) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'info',
                                title: 'Sesi berakhir (otomatis), Anda telah keluar',
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                        setTimeout(() => location.reload(), 800);
                    }).catch(() => location.reload());
                }, SIGNOUT_TIMEOUT);
            };

            // reset on common interactions
            ['click', 'keydown', 'mousemove', 'touchstart'].forEach(evt => {
                document.addEventListener(evt, resetTimer, {
                    passive: true
                });
            });

            // start timer
            resetTimer();
        })();
    </script>
    <script>
        // polling order history for realtime status updates
        (function() {
            let prevHtml = '';
            const fetchStatus = () => {
                fetch("{{ route('pelanggan.order.status') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById('orderHistoryContainer');
                        if (!container) return;
                        if (data.html !== undefined) {
                            if (prevHtml && prevHtml !== data.html) {
                                if (window.Swal) {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'info',
                                        title: 'Status pesanan diperbarui',
                                        showConfirmButton: false,
                                        timer: 2500
                                    });
                                }
                            }
                            container.innerHTML = data.html;
                            prevHtml = data.html;
                        }
                    })
                    .catch(err => console.error('fetchStatus err', err));
            };

            // start polling every 3s
            fetchStatus();
            setInterval(fetchStatus, 3000);
        })();
    </script>
@endsection
