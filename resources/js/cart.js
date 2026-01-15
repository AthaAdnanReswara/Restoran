const csrf = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

/**
 * TAMBAH ITEM (draft di DB)
 */
function addToCart(menuId) {
    fetch("/order/add", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ menu_id: menuId }),
    })
        .then(async (res) => {
            const text = await res.text();
            console.log('addToCart response status:', res.status);
            console.log('addToCart response text:', text);

            if (!res.ok) {
                let message = text || `HTTP ${res.status}`;
                try {
                    const json = JSON.parse(text || '{}');
                    message = json.message || json.error || message;
                } catch (e) {
                    // not JSON
                }
                throw new Error(message);
            }

            // try parse JSON if present
            if (text) {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.warn('addToCart: response is not valid JSON');
                    return null;
                }
            }

            return null;
        })
        .then(() => {
            refreshCart(); // 🔥 penting
            // show success toast (SweetAlert2)
            if (window.Swal) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Ditambahkan ke keranjang',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch((err) => {
            console.error('addToCart error:', err);
            if (window.Swal) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: err.message || 'Gagal menambahkan ke cart',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert(err.message || 'Gagal menambahkan ke cart');
            }
        });
}

/**
 * UPDATE QTY
 */
function updateQty(transactionId, qty) {
    fetch("/order/qty", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            transaction_id: transactionId,
            quantity: qty,
        }),
    }).then(() => refreshCart());
}

/**
 * HAPUS ITEM
 */
function removeFromCart(transactionId) {
    fetch(`/order/remove/${transactionId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": csrf,
        },
    }).then(() => refreshCart());
}

function refreshCart() {
    const cartEl = document.getElementById("cartList");
    if (!cartEl) return;

    fetch("/order/cart", {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.html !== undefined) {
                cartEl.innerHTML = data.html;
            }

            // update order modal summary if server returned it
            const modalContainer = document.getElementById('orderSummaryContainer');
            if (modalContainer && data.modalHtml !== undefined) {
                modalContainer.innerHTML = data.modalHtml;
            }

            // update subtotal display
            const totalEl = document.getElementById("cartTotal");
            if (totalEl && data.subtotal !== undefined) {
                totalEl.textContent = formatCurrency(data.subtotal);
            }

            // enable/disable order button based on count
            const orderBtn = document.getElementById("orderNowBtn");
            if (orderBtn) {
                if (data.count && data.count > 0) {
                    orderBtn.disabled = false;
                    orderBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    orderBtn.disabled = true;
                    orderBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        })
        .catch((err) => console.error('refreshCart error', err));
}

function formatCurrency(value) {
    // assume integer/decimal number
    try {
        return 'Rp ' + Number(value).toLocaleString('id-ID', { maximumFractionDigits: 0 });
    } catch (e) {
        return 'Rp000';
    }
}

/**
 * INIT
 */
export function initCart() {
    // always expose functions to global scope so inline handlers work across pages
    window.addToCart = addToCart;
    window.updateQty = updateQty;
    window.removeFromCart = removeFromCart;
    window.refreshCart = refreshCart;

    // attach listeners to add-to-cart buttons if present
    document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            addToCart(btn.dataset.menu);
        });
    });

    const orderNowBtn = document.getElementById("orderNowBtn");
    const orderModal = document.getElementById("orderModal");

    if (orderNowBtn && orderModal) {
        orderNowBtn.addEventListener("click", () => {
            orderModal.classList.remove("hidden");
        });
    }
}
