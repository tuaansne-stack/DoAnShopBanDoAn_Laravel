/**
 * Cart JavaScript for Laravel Food Shop
 * Clean and simple implementation
 */

(function () {
    'use strict';

    // Get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
    }

    // Show notification
    function showNotification(message, type = 'success') {
        // Simple alert for now, can be replaced with toast
        if (type === 'success') {
            console.log('Success:', message);
        } else {
            alert(message);
        }
    }

    // Update cart item quantity
    function updateCartItem(itemId, quantity) {
        const cartRow = document.querySelector(`[data-item-id="${itemId}"]`);
        if (!cartRow) return;

        // Show loading
        cartRow.classList.add('updating');

        const formData = new FormData();
        formData.append('quantity', quantity);
        formData.append('_token', getCsrfToken());

        fetch(`/cart/${itemId}/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                cartRow.classList.remove('updating');

                if (data.status === 'success') {
                    // Update input value
                    const input = cartRow.querySelector('.cart-quantity-input');
                    if (input) {
                        input.value = data.quantity;
                    }

                    // Update item subtotal
                    const subtotalEl = cartRow.querySelector('.subtotal-value');
                    if (subtotalEl && data.item_subtotal) {
                        subtotalEl.textContent = formatCurrency(data.item_subtotal);
                    }

                    // Update cart total
                    const cartTotalEl = document.getElementById('cart-total');
                    if (cartTotalEl && data.cart_total !== undefined) {
                        cartTotalEl.textContent = formatCurrency(data.cart_total);
                    }

                    // Update summary total
                    const summaryTotal = document.getElementById('cart-total-summary');
                    if (summaryTotal && data.cart_total !== undefined) {
                        summaryTotal.textContent = formatCurrency(data.cart_total);
                    }
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                cartRow.classList.remove('updating');
                window.location.reload();
            });
    }

    // Remove cart item
    function removeCartItem(itemId) {
        const cartRow = document.querySelector(`[data-item-id="${itemId}"]`);
        if (!cartRow) return;

        cartRow.classList.add('removing');

        const formData = new FormData();
        formData.append('_token', getCsrfToken());

        fetch(`/cart/${itemId}/remove`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Animate removal
                    setTimeout(() => {
                        cartRow.style.transition = 'all 0.3s ease';
                        cartRow.style.opacity = '0';
                        cartRow.style.height = cartRow.offsetHeight + 'px';

                        setTimeout(() => {
                            cartRow.style.height = '0';
                            cartRow.style.margin = '0';
                            cartRow.style.padding = '0';

                            setTimeout(() => {
                                cartRow.remove();

                                // Update cart total
                                const cartTotalEl = document.getElementById('cart-total');
                                if (cartTotalEl && data.cart_total !== undefined) {
                                    cartTotalEl.textContent = formatCurrency(data.cart_total);
                                }

                                const summaryTotal = document.getElementById('cart-total-summary');
                                if (summaryTotal && data.cart_total !== undefined) {
                                    summaryTotal.textContent = formatCurrency(data.cart_total);
                                }

                                // Update cart count badge in header
                                if (data.cart_count !== undefined) {
                                    // Find cart link by shopping cart icon
                                    let cartLink = document.querySelector('a[href*="cart"] .fa-shopping-cart')?.closest('a') ||
                                        document.querySelector('.header-icon-link .fa-shopping-cart')?.closest('a') ||
                                        document.querySelector('.cart-icon a') ||
                                        document.querySelector('a:has(.fa-shopping-cart)');

                                    if (!cartLink) {
                                        const allLinks = document.querySelectorAll('a');
                                        allLinks.forEach(link => {
                                            if (link.href.includes('cart') && link.querySelector('.fa-shopping-cart')) {
                                                cartLink = link;
                                            }
                                        });
                                    }

                                    if (cartLink) {
                                        let cartBadge = cartLink.querySelector('.cart-badge');
                                        if (cartBadge) {
                                            if (data.cart_count > 0) {
                                                cartBadge.textContent = data.cart_count;
                                                cartBadge.style.display = 'block';
                                            } else {
                                                cartBadge.style.display = 'none';
                                            }
                                        }
                                    }

                                    // Update "X món" badge in cart header
                                    const cartMonsBadge = document.getElementById('cart-items-count');
                                    if (cartMonsBadge) {
                                        cartMonsBadge.textContent = data.cart_count + ' món';
                                    }
                                }

                                // Reload if cart is empty
                                if (data.cart_count === 0) {
                                    window.location.reload();
                                }
                            }, 300);
                        }, 10);
                    }, 100);
                } else {
                    cartRow.classList.remove('removing');
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                cartRow.classList.remove('removing');
                window.location.reload();
            });
    }

    // Add to cart
    function addToCart(productId, quantity = 1, button = null) {
        // Check if user is authenticated
        if (window.Laravel && !window.Laravel.isAuthenticated) {
            const loginUrl = window.Laravel.routes.login || '/login';
            window.location.href = loginUrl + '?redirect=' + encodeURIComponent(window.location.pathname);
            return;
        }

        // Get toppings from button data attribute
        let toppings = [];
        if (button && button.dataset.toppings) {
            try {
                toppings = JSON.parse(button.dataset.toppings);
            } catch (e) {
                console.error('Error parsing toppings:', e);
            }
        }

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('_token', getCsrfToken());

        // Append toppings as JSON
        if (toppings.length > 0) {
            toppings.forEach((topping, index) => {
                formData.append(`toppings[${index}][id]`, topping.id);
                formData.append(`toppings[${index}][name]`, topping.name);
                formData.append(`toppings[${index}][price]`, topping.price);
            });
        }

        if (button) {
            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
        }

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
            .then(response => {
                // Check if response is unauthorized
                if (response.status === 401 || response.status === 403) {
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = button.getAttribute('data-original-text') || 'Thêm vào giỏ';
                    }
                    // Redirect to login page
                    const loginUrl = window.Laravel && window.Laravel.routes.login
                        ? window.Laravel.routes.login
                        : window.location.origin + '/login';
                    window.location.href = loginUrl + '?redirect=' + encodeURIComponent(window.location.pathname);
                    return Promise.reject('Unauthenticated');
                }
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Có lỗi xảy ra');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (!data) return; // Skip if already handled

                if (button) {
                    button.disabled = false;
                    button.innerHTML = button.getAttribute('data-original-text') || 'Thêm vào giỏ';
                }

                if (data.status === 'success') {
                    // Update cart count - find cart link by shopping cart icon
                    // Try multiple selectors to find the cart icon
                    let cartLink = document.querySelector('a[href*="cart"] .fa-shopping-cart')?.closest('a') ||
                        document.querySelector('.header-icon-link .fa-shopping-cart')?.closest('a') ||
                        document.querySelector('.cart-icon a') ||
                        document.querySelector('a:has(.fa-shopping-cart)');

                    if (!cartLink) {
                        // Fallback: find any link with cart in href and shopping cart icon
                        const allLinks = document.querySelectorAll('a');
                        allLinks.forEach(link => {
                            if (link.href.includes('cart') && link.querySelector('.fa-shopping-cart')) {
                                cartLink = link;
                            }
                        });
                    }

                    if (cartLink) {
                        let cartBadge = cartLink.querySelector('.cart-badge');

                        // Create badge if it doesn't exist
                        if (!cartBadge) {
                            cartBadge = document.createElement('span');
                            cartBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge';
                            cartLink.appendChild(cartBadge);
                        }

                        // Update badge
                        if (data.cart_count > 0) {
                            cartBadge.textContent = data.cart_count;
                            cartBadge.style.display = 'block';
                            // Add animation
                            cartBadge.style.animation = 'none';
                            setTimeout(() => {
                                cartBadge.style.animation = 'pulse 0.5s ease';
                            }, 10);
                        } else {
                            cartBadge.style.display = 'none';
                        }
                    }

                    // Also update any other cart count elements
                    const cartCountEls = document.querySelectorAll('.cart-count');
                    cartCountEls.forEach(el => {
                        el.textContent = data.cart_count;
                    });

                    // Use toast notification if available, otherwise show alert
                    if (typeof showToast === 'function') {
                        showToast(data.message, 'success');
                    } else {
                        showNotification(data.message, 'success');
                    }
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (button) {
                    button.disabled = false;
                    button.innerHTML = button.getAttribute('data-original-text') || 'Thêm vào giỏ';
                }
                // Don't show alert if it's an authentication error (already handled)
                if (error !== 'Unauthenticated') {
                    alert('Đã xảy ra lỗi khi thêm sản phẩm');
                }
            });
    }

    // Initialize cart functionality
    function initCart() {
        // Quantity input change
        document.querySelectorAll('.cart-quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                const itemId = this.dataset.itemId;
                let quantity = parseInt(this.value) || 1;

                if (quantity < 1) {
                    this.value = 1;
                    quantity = 1;
                } else if (quantity > 10) {
                    this.value = 10;
                    quantity = 10;
                }

                updateCartItem(itemId, quantity);
            });
        });

        // Minus button (for cart and product pages)
        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Check if it's in cart or product page
                const targetId = this.dataset.target;
                let input;

                if (targetId) {
                    // Product page
                    input = document.querySelector(targetId);
                } else {
                    // Cart page
                    const qtyControl = this.closest('.quantity-control');
                    if (!qtyControl) return;
                    input = qtyControl.querySelector('.cart-quantity-input');
                }

                if (!input) return;

                let value = parseInt(input.value) || 1;
                if (value > 1) {
                    const newValue = value - 1;
                    input.value = newValue;

                    // Only update cart if it's a cart item
                    const itemId = input.dataset.itemId;
                    if (itemId) {
                        updateCartItem(itemId, newValue);
                    }
                }
            });
        });

        // Plus button (for cart and product pages)
        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Check if it's in cart or product page
                const targetId = this.dataset.target;
                let input;

                if (targetId) {
                    // Product page
                    input = document.querySelector(targetId);
                } else {
                    // Cart page
                    const qtyControl = this.closest('.quantity-control');
                    if (!qtyControl) return;
                    input = qtyControl.querySelector('.cart-quantity-input');
                }

                if (!input) return;

                let value = parseInt(input.value) || 1;
                if (value < 10) {
                    const newValue = value + 1;
                    input.value = newValue;

                    // Only update cart if it's a cart item
                    const itemId = input.dataset.itemId;
                    if (itemId) {
                        updateCartItem(itemId, newValue);
                    }
                }
            });
        });

        // Remove item button
        document.querySelectorAll('.remove-cart-item').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const itemId = this.dataset.itemId;
                removeCartItem(itemId);
            });
        });

        // Add to cart buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                const productId = this.dataset.productId;
                const quantityInput = document.querySelector(`#quantity-${productId}`);
                const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

                // Store original text
                if (!this.getAttribute('data-original-text')) {
                    this.setAttribute('data-original-text', this.innerHTML);
                }

                addToCart(productId, quantity, this);
            });
        });

        // Clear cart
        const clearCartBtn = document.getElementById('clearCartBtn');
        const confirmClearCart = document.getElementById('confirmClearCart');

        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function () {
                const modalEl = document.getElementById('clearCartModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        }

        if (confirmClearCart) {
            confirmClearCart.addEventListener('click', function () {
                const formData = new FormData();
                formData.append('_token', getCsrfToken());

                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Có lỗi xảy ra');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.location.reload();
                    });
            });
        }

        // Update cart count on page load (only if authenticated)
        if (window.Laravel && window.Laravel.isAuthenticated) {
            fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(response => {
                    if (!response.ok) return null;
                    return response.json();
                })
                .then(data => {
                    if (data && data.count !== undefined) {
                        const cartCountEls = document.querySelectorAll('.cart-badge, .cart-count');
                        cartCountEls.forEach(el => {
                            el.textContent = data.count;
                        });
                    }
                })
                .catch(error => {
                    // Silently ignore errors for cart count
                });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCart);
    } else {
        initCart();
    }

})();
