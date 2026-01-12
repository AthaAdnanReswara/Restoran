// ===== PROMO MODAL =====
const promoBtn = document.getElementById("promoBtn");
const promoModal = document.getElementById("promoModal");
const closePromoBtn = document.getElementById("closePromoBtn");
const cancelPromoBtn = document.getElementById("cancelPromoBtn");
const promoForm = document.getElementById("promoForm");
const promoCode = document.getElementById("promoCode");

// Open promo modal
if (promoBtn) {
    promoBtn.addEventListener("click", () => {
        promoModal.classList.remove("hidden");
        promoCode.focus();
    });
}

// Close promo modal function
function closePromoModal() {
    promoModal.classList.add("hidden");
    promoCode.value = "";
}

// Close promo modal button
if (closePromoBtn) closePromoBtn.addEventListener("click", closePromoModal);
if (cancelPromoBtn) cancelPromoBtn.addEventListener("click", closePromoModal);

// Close promo modal when clicking outside
if (promoModal) {
    promoModal.addEventListener("click", (e) => {
        if (e.target === promoModal) {
            closePromoModal();
        }
    });
}

// Handle promo form submission
if (promoForm) {
    promoForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const code = promoCode.value.trim();

        if (code) {
            alert(`Promo code "${code}" applied successfully!`);
            closePromoModal();
            // Tambahkan logika untuk send ke backend di sini
        } else {
            alert("Please enter a promo code");
        }
    });
}

// ===== ORDER MODAL =====
const orderNowBtn = document.getElementById("orderNowBtn");
const orderModal = document.getElementById("orderModal");
const closeOrderBtn = document.getElementById("closeOrderBtn");
const cancelOrderBtn = document.getElementById("cancelOrderBtn");
const orderForm = document.getElementById("orderForm");

// Open order modal
if (orderNowBtn) {
    orderNowBtn.addEventListener("click", () => {
        orderModal.classList.remove("hidden");
    });
}

// Close order modal function
function closeOrderModal() {
    orderModal.classList.add("hidden");
}

// Close order modal button
if (closeOrderBtn) closeOrderBtn.addEventListener("click", closeOrderModal);
if (cancelOrderBtn) cancelOrderBtn.addEventListener("click", closeOrderModal);

// Close order modal when clicking outside
if (orderModal) {
    orderModal.addEventListener("click", (e) => {
        if (e.target === orderModal) {
            closeOrderModal();
        }
    });
}

// Handle order form submission
if (orderForm) {
    orderForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const paymentMethod = document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;

        alert(
            `Order confirmed!\nPayment Method: ${
                paymentMethod === "cash" ? "Cash" : "Cashless"
            }`
        );
        closeOrderModal();
        // Tambahkan logika untuk send ke backend di sini
    });
}

// Close modals with Escape key
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        if (promoModal && !promoModal.classList.contains("hidden")) {
            closePromoModal();
        }
        if (orderModal && !orderModal.classList.contains("hidden")) {
            closeOrderModal();
        }
    }
});
