<!-- Top Header Bar -->

<div class="bg-gray-100 py-2 hidden md:block">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center text-sm">
            <div class="text-gray-600">
                This is site is still under development
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('wishlist.index') }}" class="text-gray-600 hover:text-gray-800">Wishlist</a>
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-800">Cart</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-gray-900 shadow-sm position: sticky top-0 z-30">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <h1 class="text-2xl font-bold text-white">TANGERINE FURNITURE</h1>
                </a>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-300 text-sm font-medium {{ request()->routeIs('home') ? 'text-gray-300' : '' }}">Home</a>
                <a href="{{ route('products.index', ['category' => 'sofas-seating']) }}" class="text-white hover:text-gray-300 text-sm font-medium">Sofa</a>
                <a href="{{ route('products.index', parameters: ['category' => 'dining']) }}" class="text-white hover:text-gray-300 text-sm font-medium">Dining Sets</a>
                <a href="{{ route('products.index', ['category' => 'beds-bedroom']) }}" class="text-white hover:text-gray-300 text-sm font-medium">Beds</a>
                <a href="{{ route('products.index', ['category' => 'hotel-restaurant']) }}" class="text-white hover:text-gray-300 text-sm font-medium">Hotel & Restaurants</a>
                <a href="{{ route('pages.about') }}" class="text-white hover:text-gray-300 text-sm font-medium">About Us</a>
            </nav>
            
            <!-- Search Bar -->
            <div class="hidden md:flex items-center">
                <form action="{{ route('products.index') }}" method="GET" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="bg-white border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2.5 rounded-l-lg" placeholder="Search for products...">
                    <button type="submit" class="bg-white border border-l-0 border-gray-300 text-gray-400 p-2.5 rounded-r-lg hover:text-gray-600">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden flex items-center space-x-2 text-white hover:text-gray-300">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Mobile Search Button -->
            <button id="mobile-search-button" class="md:hidden flex items-center space-x-2 text-white hover:text-gray-300">
                <i class="fas fa-search text-xl"></i>
            </button>
            <!-- Cart Icon -->
<div class="relative group">
    <a href="{{ route('cart.index') }}" class="relative text-white hover:text-gray-300">
        <i class="fas fa-shopping-cart text-xl"></i>

        <span
            class="cart-count absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-1.5 min-w-[18px] text-center hidden">
            0
        </span>
    </a>

    <!-- Mini Cart Dropdown -->
    <div
        class="cart-dropdown absolute right-0 mt-3 w-80 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
        <div class="p-4 text-gray-500 text-center">
            Your basket is empty
        </div>

        <div class="border-t p-4">
            <div class="flex justify-between text-sm font-semibold">
                <span>Total</span>
                <span class="cart-dropdown-total">KES 0.00</span>
            </div>

            <a href="{{ route('cart.index') }}"
               class="block mt-3 text-center bg-gray-900 text-white py-2 rounded hover:bg-gray-800">
                View Cart
            </a>
        </div>
    </div>
</div>

        </div>
    </div>
</header>

<!-- Mobile Search Form -->
<div id="mobile-search" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50">
    <div class="absolute top-0 left-0 right-0 bg-white p-4 shadow-lg">
        <div class="flex items-center space-x-3">
            <button id="mobile-search-close" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
            <form action="{{ route('products.index') }}" method="GET" class="flex-1 flex">
                <input type="text" name="search" value="{{ request('search') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Search for products...">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Mobile Drawer Menu -->
<div id="mobile-drawer" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div id="mobile-drawer-backdrop" class="absolute inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Drawer Content -->
    <div class="absolute right-0 top-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Menu</h2>
            <button id="mobile-drawer-close" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <div class="p-4 h-full overflow-y-auto">
            <div class="space-y-4">
                <!-- Main Navigation -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Navigation</h3>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-home text-lg"></i>
                            <span>Home</span>
                        </a>
                        <a href="{{ route('pages.about') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-info-circle text-lg"></i>
                            <span>About Us</span>
                        </a>
                    </div>
                </div>
                
                <!-- Categories -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Categories</h3>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}"
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 {{ !request('category') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-box text-lg"></i>
                            <span>All Products</span>
                        </a>

                        @foreach($headerCategories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                               class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 {{ request('category') === $category->slug ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                                @if(!empty($category->icon))
                                    <i class="{{ $category->icon }} text-lg"></i>
                                @else
                                    <i class="fas fa-tag text-lg"></i>
                                @endif
                                <span>{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Account & Cart -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Account</h3>
                    <div class="space-y-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 text-gray-700">
                                <i class="fas fa-user text-lg"></i>
                                <span>My Account</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 text-gray-700">
                                <i class="fas fa-sign-in-alt text-lg"></i>
                                <span>Login</span>
                            </a>
                        @endauth
                        <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>Cart</span>
                            <span class="ml-auto bg-blue-500 text-white text-xs rounded-full px-2 py-1 cart-count">0</span>
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-heart text-lg"></i>
                            <span>Wishlist</span>
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 wishlist-count">0</span>
                        </a>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Contact</h3>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3 p-3 text-gray-700">
                            <i class="fas fa-phone text-lg"></i>
                            <span>{{ $settings['contact_phone'] ?? '+254 700 123 456' }}</span>
                        </div>
                        <div class="flex items-center space-x-3 p-3 text-gray-700">
                            <i class="fas fa-envelope text-lg"></i>
                            <span>{{ $settings['contact_email'] ?? 'hello@tangerinefurniture.co.ke' }}</span>
                        </div>
                        <div class="flex items-center space-x-3 p-3 text-gray-700">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                            <span>{{ $settings['contact_address'] ?? 'Westlands, Nairobi' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
