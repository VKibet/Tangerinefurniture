@extends('layouts.app')

@section('title', 'Furniture Products - Tangerine Furniture Kenya')
@section('description', 'Shop quality furniture in Kenya. Find dining sets, beds, sofas, coffee tables and more at Tangerine Furniture. Fast delivery and excellent customer service.')
@section('keywords', 'furniture Kenya, dining sets Nairobi, beds Kenya, sofas Kenya, furniture store, Tangerine Furniture, online furniture shop')
@section('og_title', 'Furniture Products - Tangerine Furniture Kenya')
@section('og_description', 'Shop quality furniture in Kenya. Find dining sets, beds, sofas, coffee tables and more at Tangerine Furniture.')
@section('og_type', 'website')
@section('og_image', asset('images/logo.svg'))

@section('structured_data')
@php
    $itemListElements = [];
    foreach($products as $index => $product) {
        $itemListElements[] = '{
            "@type": "ListItem",
            "position": ' . ($index + 1) . ',
            "item": {
                "@type": "Product",
                "name": "' . addslashes($product->name) . '",
                "url": "' . route('products.show', $product->slug) . '",
                "image": "' . $product->main_image_url . '",
                "description": "' . addslashes($product->description) . '",
                "category": "' . addslashes($product->category->name ?? 'Furniture') . '",
                "brand": "' . addslashes($product->brand ?? 'Tangerine Furniture') . '",
                "offers": {
                    "@type": "Offer",
                    "price": "' . $product->price . '",
                    "priceCurrency": "KES",
                    "availability": "' . ($product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock') . '"
                }
            }
        }';
    }
    $itemListJson = implode(',', $itemListElements);
@endphp
{!! '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Furniture Products",
    "description": "Quality furniture products in Kenya",
    "url": "' . request()->url() . '",
    "numberOfItems": ' . $products->count() . ',
    "itemListElement": [
        ' . $itemListJson . '
    ]
}
</script>' !!}
@endsection

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Furniture Collection</h1>
                <p class="text-lg text-gray-600 mb-6">Discover our amazing collection of quality furniture</p>
                <!-- Availability tabs: Ready / On order -->
                <div class="flex flex-wrap justify-center gap-2 mb-4">
                    <a href="{{ route('products.index', request()->except('availability', 'page')) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('availability') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('products.index', ['availability' => 'ready'] + request()->except('availability', 'page')) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('availability') === 'ready' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                        Ready
                    </a>
                    <a href="{{ route('products.index', ['availability' => 'on_order'] + request()->except('availability', 'page')) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('availability') === 'on_order' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                        On order
                    </a>
                </div>
                <div class="flex justify-center">
                    <p class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg shadow-sm">Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $totalProducts }} products</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <!-- Mobile Filter Toggle -->
                <div class="lg:hidden mb-4">
                    <button id="mobile-filter-toggle" class="w-full flex items-center justify-between p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-filter text-gray-600"></i>
                            <span class="font-medium text-gray-900">Filters</span>
                            @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'rating', 'sort', 'availability']))
                                <span class="bg-blue-500 text-white text-xs rounded-full px-2 py-1">{{ count(array_filter(request()->only(['search', 'category', 'min_price', 'max_price', 'rating', 'sort', 'availability']))) }}</span>
                            @endif
                        </div>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200" id="filter-toggle-icon"></i>
                    </button>
                </div>
                
                <!-- Filters Content -->
                <div id="mobile-filters" class="lg:block hidden bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold mb-6">Filters</h3>
                    
                    <!-- Availability -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Availability</label>
                        <div class="space-y-2">
                            <a href="{{ route('products.index', request()->except('availability', 'page')) }}" 
                               class="block text-sm {{ !request('availability') ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                All
                            </a>
                            <a href="{{ route('products.index', ['availability' => 'ready'] + request()->except('availability', 'page')) }}" 
                               class="block text-sm {{ request('availability') === 'ready' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Ready
                            </a>
                            <a href="{{ route('products.index', ['availability' => 'on_order'] + request()->except('availability', 'page')) }}" 
                               class="block text-sm {{ request('availability') === 'on_order' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                On order
                            </a>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <form method="GET" action="{{ route('products.index') }}" id="search-form">
                            @if(request('availability'))
                                <input type="hidden" name="availability" value="{{ request('availability') }}">
                            @endif
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search furniture..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}" 
                               class="block text-sm {{ !request('category') ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug] + request()->except('category')) }}" 
                                   class="block text-sm {{ request('category') == $category->slug ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <form method="GET" action="{{ route('products.index') }}" id="price-form">
                            @if(request('availability'))
                                <input type="hidden" name="availability" value="{{ request('availability') }}">
                            @endif
                            @if(request('min_price') || request('max_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif
                            <div class="space-y-2">
                                <input type="range" 
                                       id="price-range" 
                                       min="{{ $minPrice }}" 
                                       max="{{ $maxPrice }}" 
                                       value="{{ request('max_price', $maxPrice) }}"
                                       class="w-full">
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>KES {{ number_format($minPrice, 0) }}</span>
                                    <span id="price-value">KES {{ number_format(request('max_price', $maxPrice), 0) }}</span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="space-y-2">
                            @for($i = 5; $i >= 1; $i--)
                                <a href="{{ route('products.index', ['rating' => $i] + request()->except('rating')) }}" 
                                   class="flex items-center text-sm {{ request('rating') == $i ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                    <div class="flex items-center mr-2">
                                        @for($star = 1; $star <= 5; $star++)
                                            <svg class="w-4 h-4 {{ $star <= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span>{{ $i }}+ Stars</span>
                                </a>
                            @endfor
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'rating', 'sort', 'availability']))
                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('products.index') }}" 
                               class="text-sm text-red-600 hover:text-red-700 font-medium">
                                Clear All Filters
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Featured Products Sidebar -->
                <!-- Hidden on mobile so category navigation lands users directly on results -->
                <div class="mt-6 lg:mt-0 hidden lg:block">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold mb-4">Featured Products</h3>
                        <div class="space-y-4">
                            @foreach($featuredProducts as $product)
                                <a href="{{ route('products.show', $product->slug) }}" class="block hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors">
                                    <div class="flex space-x-3">
                                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $product->formatted_price }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <!-- Sort and View Options -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select name="sort"
                                data-base-url="{{ route('products.index') }}"
                                onchange="window.location.href=this.dataset.baseUrl + '?sort=' + this.value + '&' + new URLSearchParams(window.location.search).toString().replace(/sort=[^&]*&?/g, '')"
                                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600" title="Grid View">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-600" title="List View">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Price range slider
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    const priceForm = document.getElementById('price-form');
    
    if (priceRange && priceValue) {
        priceRange.addEventListener('input', function() {
            const value = this.value;
            priceValue.textContent = 'KES ' + parseInt(value).toLocaleString();
        });
        
        priceRange.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('max_price', this.value);
            window.location.href = url.toString();
        });
    }
});
</script>
@endpush 