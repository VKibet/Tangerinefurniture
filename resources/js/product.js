document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('productPage');
    if (!root) return;

    /* ---------------- Root data ---------------- */
    const productId = root.dataset.productId;
    const stock = parseInt(root.dataset.stock ?? '0', 10);
    const csrf = root.dataset.csrf;
    const addToCartUrl = root.dataset.cartUrl;
    const wishlistUrl = root.dataset.wishlistUrl;

    /* ---------------- Elements ---------------- */
    const qtyInput = document.getElementById('quantity');
    const addBtn = document.getElementById('addToCartBtn');
    const wishlistBtn = document.getElementById('wishlistBtn');
    const loader = addBtn?.querySelector('.loader');

    /* Guard: essential elements */
    if (!qtyInput || !addBtn) return;

    /* =====================================================
       Quantity controls
    ===================================================== */
    const minusBtn = root.querySelector('[data-qty-minus]');
    const plusBtn = root.querySelector('[data-qty-plus]');

    minusBtn?.addEventListener('click', () => {
        const current = parseInt(qtyInput.value, 10) || 1;
        qtyInput.value = Math.max(1, current - 1);
    });

    plusBtn?.addEventListener('click', () => {
        const current = parseInt(qtyInput.value, 10) || 1;
        qtyInput.value = Math.min(stock || current + 1, current + 1);
    });

    /* =====================================================
       Add to cart
    ===================================================== */
    let isAdding = false;

    addBtn.addEventListener('click', async () => {
        if (isAdding) return;

        isAdding = true;
        addBtn.disabled = true;
        loader?.classList.remove('hidden');

        try {
            const response = await fetch(addToCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(qtyInput.value, 10) || 1
                })
            });

            const data = await response.json();

            if (data?.success) {
                updateCartBadge(data.cart_count);
                toast(data.message || 'Added to cart', 'success');
            } else {
                toast(data?.message || 'Failed to add to cart', 'error');
            }
        } catch (e) {
            toast('Network error. Please try again.', 'error');
        } finally {
            isAdding = false;
            addBtn.disabled = false;
            loader?.classList.add('hidden');
        }
    });
/* =====================================================
   Wishlist
===================================================== */
if (wishlistBtn && wishlistUrl) {
    wishlistBtn.addEventListener('click', async () => {
        try {
            const response = await fetch(wishlistUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            });

            // User not authenticated
            if (response.status === 401) {
                toast('Please login to use wishlist', 'info');
                return;
            }

            //Any non-OK response
            if (!response.ok) {
                toast('Wishlist request failed', 'error');
                return;
            }

            const data = await response.json();

            // toggle() alignment
            if (data.added === true) {
                wishlistBtn.classList.add('text-red-500');
                toast('Added to wishlist', 'success');
            } else {
                wishlistBtn.classList.remove('text-red-500');
                toast('Removed from wishlist', 'info');
            }

        } catch (error) {
            console.error(error);
            toast('Wishlist error. Try again.', 'error');
        }
    });
}


    /* =====================================================
       Image gallery
    ===================================================== */
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail-image');

    if (mainImage && thumbnails.length) {
        thumbnails.forEach(thumbnail => {
            const imageSrc = thumbnail.dataset.image;
            if (!imageSrc) return;

            // Preload
            const preload = new Image();
            preload.src = imageSrc;

            ['mouseenter', 'click'].forEach(event => {
                thumbnail.addEventListener(event, () => {
                    if (mainImage.src === imageSrc) return;

                    mainImage.classList.add('opacity-50');

                    const img = new Image();
                    img.src = imageSrc;

                    img.onload = () => {
                        mainImage.src = imageSrc;
                        mainImage.classList.remove('opacity-50');

                        thumbnails.forEach(t =>
                            t.classList.remove('border-blue-500')
                        );
                        thumbnail.classList.add('border-blue-500');
                    };
                });
            });
        });
    }
});

/* =====================================================
   Helpers
===================================================== */
function updateCartBadge(count) {
    const badge = document.getElementById('cartCount');
    if (badge && typeof count !== 'undefined') {
        badge.textContent = count;
    }
}

function toast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const el = document.createElement('div');

    const colors = {
        success: 'bg-green-600',
        error: 'bg-red-600',
        info: 'bg-gray-800'
    };

    el.className = `${colors[type] ?? colors.info} text-white px-4 py-3 rounded shadow transition-opacity duration-300`;
    el.textContent = message;

    container.appendChild(el);

    setTimeout(() => {
        el.classList.add('opacity-0');
        setTimeout(() => el.remove(), 300);
    }, 3000);
}
