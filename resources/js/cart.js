let menuQty = {};
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function increaseMenuQty(menuId) {
    menuQty[menuId] = (menuQty[menuId] || 0) + 1;
    updateMenuQtyUI(menuId);
}

function decreaseMenuQty(menuId) {
    if (!menuQty[menuId]) return;
    menuQty[menuId]--;
    updateMenuQtyUI(menuId);
}

function updateMenuQtyUI(menuId) {
    const qtyEl = document.getElementById(`menu-qty-${menuId}`);
    if (qtyEl) {
        qtyEl.textContent = menuQty[menuId] || 0;
    }
}

function addToCart(menu) {
    const qty = menuQty[menu.menu_id] || 0;
    if (qty === 0) {
        alert("Jumlah masih 0");
        return;
    }

    const existing = cart.find((i) => i.menu_id === menu.menu_id);

    if (existing) {
        existing.qty += qty;
        existing.subtotal = existing.qty * existing.price;
    } else {
        cart.push({
            ...menu,
            qty,
            subtotal: qty * menu.price,
        });
    }

    // reset qty menu
    menuQty[menu.menu_id] = 0;
    updateMenuQtyUI(menu.menu_id);

    saveCart();
    renderCart();
}

function updateQty(menuId, qty) {
    const item = cart.find((i) => i.menu_id === menuId);
    if (!item) return;

    item.qty = Math.max(0, qty);
    item.subtotal = item.qty * item.price;

    if (item.qty === 0) {
        cart = cart.filter((i) => i.menu_id !== menuId);
    }

    saveCart();
    renderCart();
}

function getTotal() {
    return cart.reduce((sum, i) => sum + i.subtotal, 0);
}

function renderCart() {
    const container = document.getElementById("cartList");
    const totalEl = document.getElementById("cartTotal");

    if (!container || !totalEl) return;

    container.innerHTML = "";

    if (cart.length === 0) {
        container.innerHTML = `
            <p class="text-center text-gray-500 italic">
                Belum ada pesanan
            </p>`;
        totalEl.textContent = "Rp 0";
        return;
    }

    cart.forEach((item) => {
        container.innerHTML += `
        <div class="item-menu rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
            <img 
                class="rounded-2xl w-full object-cover h-48"
                src="/storage/${item.image}"
                alt="${item.name}"
            >

            <div class="p-4">
                <div class="info-menu flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-gray-900">
                        ${item.name}
                    </h3>
                    <span class="font-bold text-yellow-500">
                        Rp ${item.subtotal.toLocaleString()}
                    </span>
                </div>

                <div class="flex justify-between items-center bg-gray-100 rounded-lg p-2">
                    <p class="font-semibold">
                        Qty: ${item.qty}
                    </p>

                    <button
                        onclick="removeFromCart(${item.menu_id})"
                        class="text-red-500 hover:text-white hover:bg-red-500
                               px-3 py-1 rounded-lg transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        `;
    });

    totalEl.textContent = `Rp ${getTotal().toLocaleString()}`;
}

function removeFromCart(menuId) {
    cart = cart.filter((item) => item.menu_id !== menuId);
    saveCart();
    renderCart();
}

/**
 * INIT CART
 */
export function initCart() {
    renderCart();

    // expose ke window agar bisa dipakai di blade
    window.increaseMenuQty = increaseMenuQty;
    window.decreaseMenuQty = decreaseMenuQty;
    window.addToCart = addToCart;
    window.removeFromCart = removeFromCart; 

    const orderNowBtn = document.getElementById("orderNowBtn");
    const orderModal = document.getElementById("orderModal");
    const orderForm = document.getElementById("orderForm");

    if (orderNowBtn) {
        orderNowBtn.addEventListener("click", () => {
            if (cart.length === 0) {
                alert("Cart masih kosong");
                return;
            }
            orderModal.classList.remove("hidden");
        });
    }

    if (orderForm) {
        orderForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const paymentMethod = document.querySelector(
                'input[name="payment_method"]:checked'
            ).value;

            if (paymentMethod === "cashless") {
                window.location.href = "/payment/qris";
                return;
            }

            const res = await fetch("/order/store", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({ cart }),
            });

            if (res.ok) {
                localStorage.removeItem("cart");
                window.location.href = "/order/history";
            }
        });
    }
}
