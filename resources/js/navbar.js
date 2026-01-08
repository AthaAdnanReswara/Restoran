// Navbar functionality
export function initNavbar() {
    const navLinks = document.querySelectorAll(".nav-link-mobile");

    // Set home sebagai active default
    const homeLink = document.querySelector('[data-menu="home"]');
    if (homeLink) {
        homeLink.style.color = "#eab308"; // yellow-500
    }

    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const menu = this.getAttribute("data-menu");

            // Remove active state dari semua links
            navLinks.forEach((l) => {
                l.style.color = "#9ca3af"; // gray-400
            });

            // Add active state ke link yang diklik
            this.style.color = "#eab308"; // yellow-500

            // Optional: Emit custom event untuk routing atau actions
            const event = new CustomEvent("navbar:menu-changed", {
                detail: { menu },
            });
            document.dispatchEvent(event);
        });
    });
}

// Initialize on page load
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initNavbar);
} else {
    initNavbar();
}
