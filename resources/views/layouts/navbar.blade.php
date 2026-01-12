<!-- Desktop Navbar -->
<nav class="hidden md:flex fixed top-0 left-0 right-0 bg-white shadow-lg z-50">
    <div class="flex justify-between items-center w-full px-8 py-4">
        <div class="logo font-bold text-2xl">Restoran</div>
        <div class="menu flex gap-8 items-center">
            {{-- ================= ADMIN ================= --}}
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                        Home
                    </a>
                    <a href="{{ route('admin.pegawai.index') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                        Pegawai
                    </a>
                    <a href="{{ route('admin.menu.index') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                        Menu
                    </a>
                    <a href="#" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                        Order
                    </a>
                    <a href="#" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                        Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"class="py-2 px-4 rounded transition text-red-600 hover:bg-red-100 hover:text-red-700">
                            Logout
                        </button>
                    </form>
                @endif
            @endauth
            {{-- ================= PELANGGAN / GUEST ================= --}}
            @guest
                <a href="{{ route('home') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                    Home
                </a>
                <a href="{{ route('menu.public') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                    Menu
                </a>
                <a href="{{ route('order') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                    Order
                </a>
            @endguest
        </div>
    </div>
</nav>


<!-- Mobile Navbar (Sticky Bottom) -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50"
    style="box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);">
    <div class="flex justify-center items-center gap-6 px-2 py-3 flex-wrap">
        <!-- Home -->
        @auth
        @if(auth()->user()->role == 'admin')
        <!-- Home -->
        <a href="{{ route('admin.pegawai.index') }}"
            class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
            data-menu="order" title="Order">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
            </svg>
        </a>
        <!-- Menu -->
        <a href="{{ route('admin.menu.index') }}"
            class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
            data-menu="menu" title="Menu">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
        </a>
        @endif
        @endauth
        <a href="#"
            class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
            data-menu="home" title="Home">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
            </svg>
        </a>
        <!-- Menu -->
        <a href="#"
            class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
            data-menu="menu" title="Menu">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
        </a>
        <!-- Order -->
        <a href="/order"
            class="nav-link-mobile flex flex-col items-center justify-center px-4 py-3 rounded-lg transition duration-300"
            data-menu="order" title="Order">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
            </svg>
        </a>

        <!-- Transactions -->
        <a href="/transaction"
            class="nav-link-mobile flex flex-col items-center justify-center px-4 py-3 rounded-lg transition duration-300"
            data-menu="transactions" title="Transactions">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 -960 960 960" fill="currentColor">
                <path
                    d="M240-80q-50 0-85-35t-35-85v-120h120v-560h600v680q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-600H320v480h360v120q0 17 11.5 28.5T720-160ZM360-600v-80h360v80H360Zm0 120v-80h360v80H360ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm0 0h-40 400-360Z" />
            </svg>
        </a>

    </div>
</nav>
