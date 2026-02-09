<!-- Desktop Navbar -->
<nav class="hidden md:flex fixed top-0 left-0 right-0 bg-white shadow-lg z-50">
    <div class="flex justify-between items-center w-full px-8 py-4">
        <div class="logo font-bold text-2xl">Purple Cafe and Resto</div>
        <div class="menu flex gap-8 items-center">
            {{-- ================= ADMIN ================= --}}
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link py-2 px-4 transition hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'text-yellow-500 font-semibold' : 'text-gray-700' }}">
                        Home
                    </a>
                    <a href="{{ route('pegawai.dashboard') }}"
                        class="nav-link py-2 px-4 transition hover:bg-gray-100 {{ request()->routeIs('pegawai.dashboard') ? 'text-yellow-500 font-semibold' : 'text-gray-700' }}">
                        Orders
                    </a>

                    <a href="{{ route('admin.menu.index') }}"
                        class="nav-link py-2 px-4 transition hover:bg-gray-100 {{ request()->routeIs('admin.menu.*') ? 'text-yellow-500 font-semibold' : 'text-gray-700' }}">
                        Menu
                    </a>
                    <a href="{{ route('admin.table.index') }}" class="nav-link py-2 px-4 transition hover:bg-gray-100">
                        Table
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="py-2 px-4 rounded transition text-red-600 hover:bg-red-100 hover:text-red-700">
                            Logout
                        </button>
                    </form>
                @endif
            @endauth
            {{-- PEGAWAI features are now accessible by admin: show link under admin menu --}}
            {{-- ================= PELANGGAN / GUEST ================= --}}
            @guest
                <a href="{{ route('pelanggan.home') }}"
                    class="nav-link py-2 px-4 transition hover:bg-gray-100  {{ request()->routeIs('pelanggan.home') ? 'text-yellow-500' : 'text-gray-400' }}">
                    Home
                </a>
                <a href="{{ route('pelanggan.order') }}"
                    class="nav-link py-2 px-4 transition hover:bg-gray-100 {{ request()->routeIs('pelanggan.order') ? 'text-yellow-500 font-semibold' : 'text-gray-700' }}">
                    Order
                </a>
                <a href="{{ route('pelanggan.transaction') }}"
                    class="nav-link py-2 px-4 transition hover:bg-gray-100 {{ request()->routeIs('pelanggan.transaction') ? 'text-yellow-500 font-semibold' : 'text-gray-700' }}">
                    Transaction
                </a>
                <form method="POST" action="{{ route('pelanggan.signout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg text-sm">Sign Out</button>
                </form>
            @endguest
        </div>
    </div>
</nav>


<!-- Mobile Navbar (Sticky Bottom) -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50"
    style="box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);">
    <div class="flex justify-center items-center gap-6 px-2 py-3 flex-wrap">
        {{-- ================= ADMIN ================= --}}
        @auth
            @if (auth()->user()->role === 'admin')
                <!-- Home -->
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                    title="Home">
                    <svg class="w-7 h-7 {{ request()->routeIs('admin.dashboard') ? 'text-yellow-500' : 'text-gray-400' }}"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                </a>

                <!-- Orders (pegawai dashboard) -->
                <a href="{{ route('pegawai.dashboard') }}"
                    class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                    title="Orders">
                    <svg class="w-7 h-7 {{ request()->routeIs('pegawai.dashboard') ? 'text-yellow-500' : 'text-gray-400' }}"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                </a>

                <!-- Pegawai -->
                <a href="{{ route('admin.pegawai.index') }}"
                    class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                    title="Pegawai">
                    <svg class="w-7 h-7 {{ request()->routeIs('admin.pegawai.*') ? 'text-yellow-500' : 'text-gray-400' }}"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </a>

                <!-- Menu -->
                <a href="{{ route('admin.menu.index') }}"
                    class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                    title="Menu">
                    <svg class="w-7 h-7 {{ request()->routeIs('admin.menu.*') ? 'text-yellow-500' : 'text-gray-400' }}"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                </a>
                <!-- Table -->
                <a href="{{ route('admin.table.index') }}"
                    class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                    title="Menu">
                    <svg class="w-7 h-7 {{ request()->routeIs('admin.table.*') ? 'text-yellow-500' : 'text-gray-400' }}"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="flex">
                    @csrf
                    <button type="submit"
                        class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300 text-red-600 hover:text-red-700"
                        title="Logout">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                        </svg>
                    </button>
                </form>
            @endif
        @endauth

        {{-- removed separate pegawai block (features merged into admin menu) --}}

        {{-- ================= PELANGGAN / GUEST ================= --}}
        @guest
            <!-- Home -->
            <a href="{{ route('pelanggan.home') }}"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                title="Home">
                <svg class="w-7 h-7 {{ request()->routeIs('pelanggan.home') ? 'text-yellow-500' : 'text-gray-400' }}"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
            </a>

            <!-- Order -->
            <a href="{{ route('pelanggan.order') }}"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                title="Order">
                <svg class="w-7 h-7 {{ request()->routeIs('pelanggan.order') ? 'text-yellow-500' : 'text-gray-400' }}"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
            </a>

            <!-- Transaction -->
            <a href="{{ route('pelanggan.transaction') }}"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                title="Transaction">
                <svg class="w-7 h-7 {{ request()->routeIs('pelanggan.transaction') ? 'text-yellow-500' : 'text-gray-400' }}"
                    fill="currentColor" viewBox="0 -960 960 960">
                    <path
                        d="M240-80q-50 0-85-35t-35-85v-120h120v-560h600v680q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-600H320v480h360v120q0 17 11.5 28.5T720-160ZM360-600v-80h360v80H360Zm0 120v-80h360v80H360ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm0 0h-40 400-360Z" />
                </svg>
            </a>

            <!-- Sign Out (mobile: icon) -->
            <form method="POST" action="{{ route('pelanggan.signout') }}" class="flex">
                @csrf
                <button type="submit" title="Sign Out"
                    class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300 text-red-600 hover:text-red-700">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 13v-2H7V8l-5 4 5 4v-3zM20 3H10v2h10v14H10v2h10c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                    </svg>
                </button>
            </form>
        @endguest
    </div>
</nav>
