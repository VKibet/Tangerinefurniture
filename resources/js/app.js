import './bootstrap';
import './product';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// E-commerce functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart functionality
    initializeCart();
    
    // Initialize wishlist functionality
    initializeWishlist();
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize product filters
    initializeFilters();
    
    // Initialize smooth scrolling
    initializeSmoothScrolling();
    
    // Initialize mobile menu
    initializeMobileMenu();
    
    // Initialize mobile drawer
    initializeMobileDrawer();
    
    // Initialize mobile search
    initializeMobileSearch();
    
    // Initialize mobile filters
    initializeMobileFilters();
    
    // Initialize carousel
    initializeCarousel();
    
    // Initialize quantity controls
    initializeQuantityControls();
    

});

// Format number with abbreviations (K, M, etc.)
function formatNumber(num) {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    } else {
        return num.toString();
    }
}

// Carousel functionality
function initializeCarousel() {
    const carousel = document.querySelector('.carousel-container');
    if (!carousel) return;
    
    const slides = carousel.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = carousel.querySelector('.carousel-prev');
    const nextBtn = carousel.querySelector('.carousel-next');
    
    let currentSlide = 0;
    let autoPlayInterval;
    
    // Function to show a specific slide
    function showSlide(index) {
        // Remove active class from all slides and dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Add active class to current slide and dot
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        
        currentSlide = index;
    }
    
    // Function to go to next slide
    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }
    
    // Function to go to previous slide
    function prevSlide() {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    }
    
    // Event listeners for navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetAutoPlay();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetAutoPlay();
        });
    }
    
    // Event listeners for dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            resetAutoPlay();
        });
    });
    
    // Auto-play functionality
    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
    }
    
    function resetAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }
    
    // Pause auto-play on hover
    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
            resetAutoPlay();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            resetAutoPlay();
        }
    });
    
    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    carousel.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next slide
                nextSlide();
            } else {
                // Swipe right - previous slide
                prevSlide();
            }
            resetAutoPlay();
        }
    }
    
    // Initialize carousel
    showSlide(0);
    startAutoPlay();
}

// Cart functionality with server-side session management
function initializeCart() {
    // Update cart display
    function updateCartDisplay() {
        fetch('/cart/data')
            .then(response => response.json())
            .then(data => {
                const cartCountElement = document.querySelector('.cart-count');
                const cartTotalElement = document.querySelector('.cart-total');
                const cartDropdownTotalElement = document.querySelector('.cart-dropdown-total');
                
                if (cartCountElement) {
                    cartCountElement.textContent = data.cart_count;

                    if (data.cart_count > 0) {
                        cartCountElement.classList.remove('hidden');
                    } else {
                        cartCountElement.classList.add('hidden');
                    }
                }
                
                if (cartTotalElement) {
                    cartTotalElement.textContent = `KES ${formatNumber(data.cart_total)}`;
                }
                
                if (cartDropdownTotalElement) {
                    cartDropdownTotalElement.textContent = `KES ${data.cart_total.toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                }
                
                // Update cart dropdown if it exists
                updateCartDropdown(data.cart);
                
                // Update cart page content if we're on the cart page
                updateCartPageContent(data.cart);
            })
            .catch(error => {
                console.error('Error fetching cart data:', error);
            });
    }
    
    // Update cart dropdown
    function updateCartDropdown(cart) {
        const cartDropdown = document.querySelector('.cart-dropdown');
        if (cartDropdown) {
            if (Object.keys(cart).length === 0) {
                cartDropdown.innerHTML = '<div class="p-4 text-center text-gray-500">Your basket is empty</div>';
            } else {
                let cartItemsHtml = '';
                let total = 0;
                
                Object.values(cart).forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    
                    cartItemsHtml += `
                        <div class="p-3 border-b border-gray-100 hover:bg-gray-50">
                            <div class="flex items-start space-x-3">
                                <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded flex-shrink-0" 
                                     onerror="this.src='https://via.placeholder.com/48x48/cccccc/ffffff?text=No+Image'">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">${item.name}</h4>
                                    <p class="text-sm text-gray-500">KES ${item.price.toLocaleString()}</p>
                                    
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center border border-gray-300 rounded">
                                            <button onclick="updateCartQuantity(${item.id}, ${parseInt(item.quantity) - 1})" 
                                                    class="px-2 py-1 text-gray-600 hover:text-gray-800 text-xs" 
                                                    ${parseInt(item.quantity) <= 1 ? 'disabled' : ''}>
                                                -
                                            </button>
                                            <span class="px-2 py-1 text-xs text-gray-900">${item.quantity}</span>
                                            <button onclick="updateCartQuantity(${item.id}, ${parseInt(item.quantity) + 1})" 
                                                    class="px-2 py-1 text-gray-600 hover:text-gray-800 text-xs">
                                                +
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-medium text-gray-900">KES ${itemTotal.toLocaleString()}</div>
                                            <button onclick="removeFromCart(${item.id})" 
                                                    class="text-red-500 hover:text-red-700 text-xs">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                cartDropdown.innerHTML = cartItemsHtml;
                
                // Update dropdown total
                const dropdownTotalElement = document.querySelector('.cart-dropdown-total');
                if (dropdownTotalElement) {
                    dropdownTotalElement.textContent = `KES ${total.toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                }
            }
        }
    }
    
function updateCartPageContent(cart) {
    const cartItemsContainer = document.querySelector('.divide-y.divide-gray-200');
    if (!cartItemsContainer) return;

    if (Object.keys(cart).length === 0) {
        window.location.reload();
        return;
    }

    let cartItemsHtml = '';
    let total = 0;

    Object.values(cart).forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        cartItemsHtml += `
            <div class="p-6 flex items-center space-x-4">
                <img 
                    src="${item.image || '/images/placeholder.png'}"
                    alt="${item.name}"
                    class="w-20 h-20 object-cover rounded"
                    onerror="this.src='/images/placeholder.png'"
                >

                <div class="flex-1">
                    <h3 class="text-lg font-medium text-gray-900">${item.name}</h3>
                    <p class="text-sm text-gray-500">${item.category || 'Product'}</p>
                    <span class="text-lg font-bold text-gray-900">
                        KES ${item.price.toLocaleString()}
                    </span>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button 
                            onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})"
                            class="px-3 py-2 text-gray-600 hover:text-gray-800"
                            ${item.quantity <= 1 ? 'disabled' : ''}
                        >
                            <i class="fas fa-minus text-xs"></i>
                        </button>

                        <span class="px-3 py-2 font-medium">${item.quantity}</span>

                        <button 
                            onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})"
                            class="px-3 py-2 text-gray-600 hover:text-gray-800"
                        >
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>

                    <div class="text-right">
                        <div class="text-lg font-bold">
                            KES ${itemTotal.toLocaleString()}
                        </div>
                        <button 
                            onclick="removeFromCart(${item.id})"
                            class="text-red-500 hover:text-red-700 text-sm"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
    });

    cartItemsContainer.innerHTML = cartItemsHtml;

    // Update cart total (ONE place only)
    const totalElement = document.getElementById('cart-page-total');
    if (totalElement) {
        totalElement.textContent = `KES ${total.toLocaleString('en-KE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`;
    }

    // Update order summary total (optional)
    const summaryTotal = document.getElementById('order-summary-total');
    if (summaryTotal) {
        summaryTotal.textContent = `KES ${total.toLocaleString('en-KE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`;
    }
}
    // Add to cart function
    window.addToCart = function(productId, productName, productPrice, productImage, quantity = 1) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDisplay();
                showNotification(data.message, 'success');
            } else {
                showNotification('Error adding to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding to cart', 'error');
        });
    };
    
    // Remove from cart function
    window.removeFromCart = function(productId) {
        const formData = new FormData();
        formData.append('product_id', productId);
        
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDisplay();
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };
    
    // Update cart quantity function
    window.updateCartQuantity = function(productId, quantity) {
        // Ensure quantity is a number and not less than 1
        quantity = parseInt(quantity);
        if (isNaN(quantity) || quantity < 1) return;
        
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        
        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDisplay();
                showNotification(`Quantity updated to ${quantity}`, 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating quantity', 'error');
        });
    };
    
    // Clear cart function
    window.clearCart = function() {
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDisplay();
                showNotification(data.message, 'success');
                // Reload page to show empty cart state
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };
    
    // Initialize cart display
    updateCartDisplay();
}

// Quantity controls functionality
function initializeQuantityControls() {
    // Global quantity update function
    window.updateQuantity = function(change, inputId = 'quantity') {
        const quantityInput = document.getElementById(inputId);
        if (!quantityInput) return;
        
        const currentValue = parseInt(quantityInput.value);
        const newValue = currentValue + change;
        const maxValue = parseInt(quantityInput.max) || 999;
        const minValue = parseInt(quantityInput.min) || 1;
        
        if (newValue >= minValue && newValue <= maxValue) {
            quantityInput.value = newValue;
        }
    };
    
    // Add to cart with quantity function
    window.addToCartWithQuantity = function(productId, productName, productPrice, productImage, inputId = 'quantity') {
        const quantityInput = document.getElementById(inputId);
        const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
        
        addToCart(productId, productName, productPrice, productImage, quantity);
    };
}

// Wishlist functionality with cookies
function initializeWishlist() {
    // Get wishlist from cookies
    function getWishlistFromCookies() {
        const cookies = document.cookie.split(';');
        const wishlistCookie = cookies.find(cookie => cookie.trim().startsWith('wishlist='));
        if (wishlistCookie) {
            try {
                return JSON.parse(decodeURIComponent(wishlistCookie.split('=')[1]));
            } catch (e) {
                return [];
            }
        }
        return [];
    }
    
    // Save wishlist to cookies
    function saveWishlistToCookies(wishlist) {
        const wishlistData = encodeURIComponent(JSON.stringify(wishlist));
        document.cookie = `wishlist=${wishlistData}; path=/; max-age=${60 * 60 * 24 * 30}`; // 30 days
    }
    
    let wishlist = getWishlistFromCookies();
    
    // Update wishlist count display
    function updateWishlistCount() {
        const wishlistCountElements = document.querySelectorAll('.wishlist-count');
        wishlistCountElements.forEach(element => {
            element.textContent = wishlist.length;
        });
    }
    
    // Update wishlist button states
    function updateWishlistButtons() {
        const wishlistButtons = document.querySelectorAll('.wishlist-btn');
        const removeButtons = document.querySelectorAll('.remove-wishlist-btn');
        
        wishlistButtons.forEach(button => {
            const heartIcon = button.querySelector('.wishlist-icon');
            const productId = button.getAttribute('data-product-id');
            const removeButton = document.querySelector(`.remove-wishlist-btn[data-product-id="${productId}"]`);
            
            if (productId) {
                const isInWishlist = wishlist.findIndex(item => item.id === productId) !== -1;
                if (isInWishlist) {
                    // Hide heart button, show remove button
                    button.classList.add('hidden');
                    if (removeButton) {
                        removeButton.classList.remove('hidden');
                    }
                } else {
                    // Show heart button, hide remove button
                    button.classList.remove('hidden');
                    if (removeButton) {
                        removeButton.classList.add('hidden');
                    }
                    heartIcon.classList.remove('text-red-500');
                    heartIcon.classList.add('text-gray-400');
                }
            }
        });
    }
    
    window.toggleWishlist = function(productId, productName) {
        const existingIndex = wishlist.findIndex(item => item.id === productId);
        
        if (existingIndex !== -1) {
            // Remove from wishlist
            wishlist.splice(existingIndex, 1);
            showNotification('Removed from wishlist', 'info');
        } else {
            // Add to wishlist
            wishlist.push({
                id: productId,
                name: productName,
                addedAt: new Date().toISOString()
            });
            showNotification('Added to wishlist!', 'success');
        }
        
        // Save to cookies
        saveWishlistToCookies(wishlist);
        
        // Update displays
        updateWishlistCount();
        updateWishlistButtons();
    };
    
    // Initialize wishlist displays
    updateWishlistCount();
    updateWishlistButtons();
    
    // Clear wishlist function
    window.clearWishlist = function() {
        wishlist = [];
        saveWishlistToCookies(wishlist);
        updateWishlistCount();
        updateWishlistButtons();
        showNotification('Wishlist cleared', 'info');
    };
    
    // Get wishlist items for display
    window.getWishlistItems = function() {
        return wishlist;
    };
    
    // Remove from wishlist function
    window.removeFromWishlist = function(productId) {
        const existingIndex = wishlist.findIndex(item => item.id === productId);
        
        if (existingIndex !== -1) {
            // Remove from wishlist
            wishlist.splice(existingIndex, 1);
            saveWishlistToCookies(wishlist);
            updateWishlistCount();
            updateWishlistButtons();
            showNotification('Removed from wishlist', 'info');
        }
    };
    

}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[placeholder*="Search"]');
    const searchResults = document.createElement('div');
    searchResults.className = 'absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-lg shadow-lg z-50 hidden';
    searchResults.innerHTML = '<div class="p-4 text-gray-500">Type to search...</div>';
    
    if (searchInput) {
        searchInput.parentElement.style.position = 'relative';
        searchInput.parentElement.appendChild(searchResults);
        
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length > 2) {
                // Simulate search results for furniture
                const results = [
                    { name: 'Modern Oak Dining Set', price: 'KES 85,000.00', image: 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' },
                    { name: 'Luxury King Size Bed', price: 'KES 65,000.00', image: 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' },
                    { name: 'Comfortable 3-Seater Sofa', price: 'KES 75,000.00', image: 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' },
                    { name: 'Glass Coffee Table', price: 'KES 25,000.00', image: 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' },
                    { name: 'Executive Office Chair', price: 'KES 35,000.00', image: 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }
                ].filter(item => item.name.toLowerCase().includes(query.toLowerCase()));
                
                if (results.length > 0) {
                    searchResults.innerHTML = results.map(item => `
                        <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100">
                            <img src="${item.image}" alt="${item.name}" class="w-10 h-10 rounded mr-3 object-cover">
                            <div>
                                <div class="font-medium">${item.name}</div>
                                <div class="text-sm text-gray-500">${item.price}</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    searchResults.innerHTML = '<div class="p-4 text-gray-500">No furniture found</div>';
                }
                
                searchResults.classList.remove('hidden');
            } else {
                searchResults.classList.add('hidden');
            }
        });
        
        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
}

// Product filters
function initializeFilters() {
    const categorySelect = document.querySelector('select');
    
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;
            
            // Simulate filtering products
            if (selectedCategory !== 'Choose Categories') {
                showNotification(`Filtering by ${selectedCategory}...`, 'info');
            }
        });
    }
}

// Smooth scrolling
function initializeSmoothScrolling() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Mobile drawer functionality
function initializeMobileDrawer() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileDrawerClose = document.getElementById('mobile-drawer-close');
    const mobileDrawerBackdrop = document.getElementById('mobile-drawer-backdrop');
    const drawerContent = mobileDrawer?.querySelector('.absolute.right-0');
    
    if (!mobileMenuButton || !mobileDrawer || !mobileDrawerClose || !drawerContent) {
        console.log('Mobile drawer elements not found');
        return;
    }
    
    // Open drawer
    mobileMenuButton.addEventListener('click', function() {
        mobileDrawer.classList.remove('hidden');
        // Trigger animation after a brief delay
        setTimeout(() => {
            drawerContent.classList.remove('translate-x-full');
        }, 10);
    });
    
    // Close drawer
    function closeDrawer() {
        drawerContent.classList.add('translate-x-full');
        setTimeout(() => {
            mobileDrawer.classList.add('hidden');
        }, 300);
    }
    
    mobileDrawerClose.addEventListener('click', closeDrawer);
    mobileDrawerBackdrop.addEventListener('click', closeDrawer);
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileDrawer.classList.contains('hidden')) {
            closeDrawer();
        }
    });
    
    // Close drawer when clicking on links
    const drawerLinks = mobileDrawer.querySelectorAll('a');
    drawerLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Don't close for external links or anchor links
            if (this.href.includes('#') || this.href.startsWith('http')) {
                return;
            }
            closeDrawer();
        });
    });
}

// Mobile search functionality
function initializeMobileSearch() {
    const mobileSearchButton = document.getElementById('mobile-search-button');
    const mobileSearch = document.getElementById('mobile-search');
    const mobileSearchClose = document.getElementById('mobile-search-close');
    
    if (!mobileSearchButton || !mobileSearch || !mobileSearchClose) {
        console.log('Mobile search elements not found');
        return;
    }
    
    // Open search
    mobileSearchButton.addEventListener('click', function() {
        mobileSearch.classList.remove('hidden');
        // Focus on search input
        setTimeout(() => {
            const searchInput = mobileSearch.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.focus();
            }
        }, 100);
    });
    
    // Close search
    mobileSearchClose.addEventListener('click', function() {
        mobileSearch.classList.add('hidden');
    });
    
    // Close on backdrop click
    mobileSearch.addEventListener('click', function(e) {
        if (e.target === mobileSearch) {
            mobileSearch.classList.add('hidden');
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileSearch.classList.contains('hidden')) {
            mobileSearch.classList.add('hidden');
        }
    });
}

// Mobile filters functionality
function initializeMobileFilters() {
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const mobileFilters = document.getElementById('mobile-filters');
    const filterToggleIcon = document.getElementById('filter-toggle-icon');
    
    if (!mobileFilterToggle || !mobileFilters || !filterToggleIcon) {
        // Mobile filter elements not found - this is normal on pages without filters
        return;
    }
    
    // Toggle filters
    mobileFilterToggle.addEventListener('click', function() {
        const isHidden = mobileFilters.classList.contains('hidden');
        
        if (isHidden) {
            // Show filters
            mobileFilters.classList.remove('hidden');
            filterToggleIcon.style.transform = 'rotate(180deg)';
        } else {
            // Hide filters
            mobileFilters.classList.add('hidden');
            filterToggleIcon.style.transform = 'rotate(0deg)';
        }
    });
    
    // Close filters when clicking on filter links (optional)
    const filterLinks = mobileFilters.querySelectorAll('a');
    filterLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Don't close for external links
            if (this.href.startsWith('http')) {
                return;
            }
            // Close filters after a brief delay to allow the link to work
            setTimeout(() => {
                mobileFilters.classList.add('hidden');
                filterToggleIcon.style.transform = 'rotate(0deg)';
            }, 300);
        });
    });
}

// Mobile menu functionality (legacy)
function initializeMobileMenu() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    const colors = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        info: 'bg-blue-500 text-white',
        warning: 'bg-yellow-500 text-white'
    };
    
    notification.className += ` ${colors[type]}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span>${message}</span>
            <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Product image lazy loading
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading
initializeLazyLoading();

// Add hover effects to product cards
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});


Alpine.start();
