<!-- Desktop Navbar -->
<nav class="hidden md:flex fixed top-0 left-0 right-0 bg-white shadow-lg z-50">
    <div class="flex justify-between items-center w-full px-8 py-4">
        <div class="logo font-bold text-2xl">Restoran</div>
        <div class="menu flex gap-8">
            <a href="#" class="nav-link py-2 px-4 transition" data-menu="home">Home</a>
            <a href="{{ route('admin.pegawai.index') }}" class="nav-link py-2 px-4 transition" data-menu="home">Pegawai</a>
            <a href="{{ route('admin.menu.index') }}" class="nav-link py-2 px-4 transition" data-menu="menu">Menu</a>
            <a href="#" class="nav-link py-2 px-4 transition" data-menu="order">Order</a>
            <a href="#" class="nav-link py-2 px-4 transition" data-menu="profile">Profile</a>
        </div>
    </div>
</nav>

<!-- Mobile Navbar (Sticky Bottom) -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50"
    style="box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);">
    <div class="grid grid-cols-5 gap-0 px-2 py-3">
        <!-- Home -->
        @if (auth()->user()->role == 'admin')
            <!-- Menu -->
            <a href="{{ route('admin.menu.index') }}"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                data-menu="menu" title="Menu">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
            </a>
        @else
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
            <a href="#"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                data-menu="order" title="Order">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
            </a>

            <!-- Settings/Transactions -->
            <a href="#"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                data-menu="transactions" title="Transactions">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-2.41-2.41-4.04 4.04H19V9z" />
                </svg>
            </a>

            <!-- Profile -->
            <a href="#"
                class="nav-link-mobile flex flex-col items-center justify-center py-3 rounded-lg transition duration-300"
                data-menu="profile" title="Profile">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </a>
        @endif
    </div>
</nav>

<!-- Spacer untuk mobile agar content tidak tertutup navbar -->
<div class="md:hidden h-24"></div>

<script>
    // Immediate initialization untuk navbar
    (function() {
        const navLinks = document.querySelectorAll(".nav-link-mobile");

        // Set home sebagai active default
        const homeLink = document.querySelector('[data-menu="home"]');
        if (homeLink) {
            homeLink.style.color = "#eab308"; // yellow-500
        }

        navLinks.forEach((link) => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove active state dari semua links
                navLinks.forEach((l) => {
                    l.style.color = "#9ca3af"; // gray-400
                });

                // Add active state ke link yang diklik
                this.style.color = "#eab308"; // yellow-500
            });
        });
    })();
</script>
