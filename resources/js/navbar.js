// Navbar functionality
export function initNavbar() {
    const navLinks = document.querySelectorAll(".nav-link-mobile");

    // Function to set active state based on current path
    function setActiveByPath() {
        const currentPath = window.location.pathname;
        let activeSet = false;

        navLinks.forEach((link) => {
            const href = link.getAttribute("href");
            // Check if current path matches the link's href
            if (currentPath === href || (href === "/" && currentPath === "/")) {
                link.style.color = "#eab308"; // yellow-500
                activeSet = true;
            } else {
                link.style.color = "#9ca3af"; // gray-400
            }
        });

        // If no match found, set home as default
        if (!activeSet) {
            const homeLink = document.querySelector('[data-menu="home"]');
            if (homeLink) {
                homeLink.style.color = "#eab308"; // yellow-500
            }
        }
    }

    // Set active on initial page load
    setActiveByPath();

    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
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
