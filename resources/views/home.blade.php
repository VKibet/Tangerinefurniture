@extends('layouts.app')

@section('title', 'Tangerine Furniture - Quality Furniture Store in Kenya')
@section('description', 'Shop quality furniture in Kenya. Find dining sets, beds, sofas, coffee tables and more at Tangerine Furniture. Fast delivery and excellent customer service.')
@section('keywords', 'furniture Kenya, dining sets Nairobi, beds Kenya, sofas Kenya, furniture store, Tangerine Furniture, online furniture shop')
@section('og_title', 'Tangerine Furniture - Quality Furniture Store in Kenya')
@section('og_description', 'Shop quality furniture in Kenya. Find dining sets, beds, sofas, coffee tables and more at Tangerine Furniture.')
@section('og_type', 'website')
@section('og_image', asset('images/logo.svg'))

@section('structured_data')@php
    $socialUrls = \App\Helpers\SocialMediaHelper::getSameAsArray();
    $sameAsJson = '';
    if (!empty($socialUrls)) {
        $sameAsJson = '"' . implode('","', $socialUrls) . '"';
    } else {
        $sameAsJson = '"https://example.com"';
    }
@endphp
{!! '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Tangerine Furniture",
    "url": "' . url('/') . '",
    "logo": "' . asset('images/logo.svg') . '",
    "description": "Your trusted source for quality furniture in Kenya",
    "address": {
        "@type": "PostalAddress",
        "addressCountry": "KE",
        "addressLocality": "Nairobi"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "customer service"
    },
    "sameAs": [
        ' . $sameAsJson . '
    ]
}
</script>' !!}

{!! '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Tangerine Furniture",
    "url": "' . url('/') . '",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "' . url('/products') . '?search={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>' !!}
@endsection

@section('content')


    @php
        // Select from featured products available in various categories
    $featuredProducts = collect()
        ->merge($livingRoomProducts ?? collect())
        ->merge($bedProducts ?? collect())
        ->merge($sofaProducts ?? collect())
        ->merge($diningProducts ?? collect())
        ->merge($coffeeTableProducts ?? collect())
        ->merge($airbnbProducts ?? collect())
        ->unique('id')
        ->take(10);
@endphp

<!-- HERO SECTION -->
<section class="relative h-screen w-full overflow-hidden">

    <!-- Background Video -->
        <video
        class="absolute inset-0 w-full h-full object-cover"
        autoplay
        loop
        muted
        preload="auto"
        playsinline
        poster="{{ asset('images/landing-fallback.jpg') }}"
    >
        <source src="{{ asset('video/TFM.mp4') }}" type="video/mp4" media="(min-width: 1280px)">
        <source src="{{ asset('video/TFM.mp4') }}" type="video/mp4">
        </video>
    
    <!-- overlay + content on top as usual -->
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="absolute inset-0 flex items-center justify-center text-white">
        Kenya’s home for quality furniture
    </div>
</section>

<!-- HERO (SLIDE) SECTION -->
@if($featuredProducts->count() > 0)
<section class="bg-gray-900 text-white py-10 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <p class="uppercase tracking-[0.2em] text-xs text-yellow-400 mb-2">
                    Curated just for you
                </p>
                <h2 class="text-2xl md:text-3xl font-bold">
                    Featured Tangerine Picks
                </h2>
                <p class="text-sm md:text-base text-gray-300 mt-2 max-w-xl">
                    A glimpse of our best-selling products. Scroll to explore and click to view details.
                </p>
            </div>

            <a href="{{ route('products.index') }}"
               class="inline-flex items-center text-sm md:text-base text-yellow-400 hover:text-yellow-300">
                View all products
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>

        <!-- Carousel Wrapper -->
        <div class="relative">

            <!-- Left Button -->
            <button
                type="button"
                aria-label="Scroll left"
                data-carousel-left
                class="absolute left-2 top-1/2 -translate-y-1/2 z-40 bg-gray-900/70 hover:bg-gray-900 text-white p-3 rounded-full shadow-lg"
            >
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Right Button -->
            <button
                type="button"
                aria-label="Scroll right"
                data-carousel-right
                class="absolute right-2 top-1/2 -translate-y-1/2 z-40 bg-gray-900/70 hover:bg-gray-900 text-white p-3 rounded-full shadow-lg"
            >
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Scroll Container -->
            <div
                class="featured-carousel flex gap-6 overflow-x-auto scroll-smooth no-scrollbar snap-x snap-mandatory"
            >
                @php
                    // Duplicate products for infinite loop
                    $loopProducts = $featuredProducts->concat($featuredProducts);
                @endphp

                @foreach($loopProducts as $product)
                    <a
                        href="{{ route('products.show', $product->slug ?? $product->id) }}"
                        class="snap-start group bg-gray-900/70 border border-gray-800 rounded-2xl
                               min-w-[240px] max-w-[260px] flex-shrink-0 overflow-hidden
                               hover:border-yellow-400/70 transition shadow-lg"
                    >
                        <div class="aspect-[4/3] bg-gray-800 overflow-hidden">
                            <img
                                loading="lazy"
                                src="{{ $product->main_image_url ?? 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=1200&q=80' }}"
                                alt="{{ $product->name ?? 'Product image' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                        </div>

                        <div class="p-4 flex flex-col gap-1">
                            @if($product->category?->name)
                                <p class="text-[11px] uppercase tracking-[0.18em] text-gray-400">
                                    {{ $product->category->name }}
                                </p>
                            @endif

                            <h3 class="text-sm md:text-base font-semibold line-clamp-2">
                                {{ $product->name }}
                            </h3>

                            @if($product->price)
                                <p class="mt-1 text-sm text-yellow-400 font-semibold">
                                    KES {{ number_format($product->price) }}
                                </p>
                            @endif

                            <p class="text-xs text-gray-400 mt-1 line-clamp-2">
                                {{ $product->short_description ?? 'Premium, functional and durable furniture.' }}
                            </p>

                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-[11px] uppercase tracking-[0.2em] text-gray-400">
                                    View details
                                </span>
                                <span class="w-7 h-7 rounded-full border border-yellow-400/70 flex items-center justify-center text-[10px] text-yellow-400 group-hover:bg-yellow-400 group-hover:text-gray-900 transition">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

    <!-- Full Screen Hero Banner -->
    <section class="relative h-[50vh] bg-gray-900 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            @if($livingRoomProducts->count() > 100)
                <img src="{{ $livingRoomProducts->first()->main_image_url }}" alt="Living Room" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Dining Room" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 hero-overlay"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="absolute bottom-8 w-full text-white z-10 justify-center items-center flex flex-col">
            <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Living Room</h2>
                    <a href="{{ route('products.index', ['category' => 'living-room']) }}" class="btn-yellow-border inline-block px-6 py-3 font-semibold">
                        View More
                    </a>
        </div>
        </div>
    </section>

    <!-- Product Categories Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Product Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Beds -->
                <div class="text-center aspect-[3/2] relative">
                    <div class="relative h-full  bg-gray-200 rounded-lg overflow-hidden mb-4">
                        @if($bedProducts->count() > 0)
                            <img src="{{ $bedProducts->first()->main_image_url }}" alt="Beds" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Beds" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class=" absolute inset-0 flex w-full h-full items-center justify-center flex-col">
                    <!-- <h3 class="text-xl font-semibold text-gray-100 border-2 px-6 py-2 border-yellow-400">Bed</h3> -->
                    <a href="{{ route('products.index', ['category' => 'bed']) }}" class="btn-yellow-border inline-block px-6 py-3 font-semibold">
                        View bed products
                    </a>
                    </div>
                </div>

                <div class="text-center aspect-[3/2] relative">
                    <div class="relative h-full  bg-gray-200 rounded-lg overflow-hidden mb-4">
                        @if($livingRoomProducts->count() > 0)
                            <img src="{{ $livingRoomProducts->first()->main_image_url }}" alt="Living Room" class="w-full h-full object-cover">
                        @else
                        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Sofa" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class=" absolute inset-0 flex w-full h-full items-center justify-center flex-col">
                    <a href="{{ route('products.index', ['category' => 'living-room']) }}" class="btn-yellow-border inline-block px-6 py-3 font-semibold">
                        View Living room products
                    </a>
                    </div>
                </div>
                <div class="text-center aspect-[3/2] relative">
                    <div class="relative h-full  bg-gray-200 rounded-lg overflow-hidden mb-4">
                        @if($bedProducts->count() > 0)
                            <img src="{{ $coffeeTableProducts->first()->main_image_url }}" alt="Beds" class="w-full h-full object-cover">
                        @else
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Coffee Tables" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class=" absolute inset-0 flex w-full h-full items-center justify-center flex-col">
                    <a href="{{ route('products.index', ['category' => 'coffee-table']) }}" class="btn-yellow-border inline-block px-6 py-3 font-semibold">
                    View Coffee Tables
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem Solving Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">we are solving the biggest problems in furniture</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fast Deliveries -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 feature-icon">
                        <i class="fas fa-truck text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Fast deliveries</h3>
                    <p class="text-gray-600">Same day deliveries within Nairobi for ready made orders.</p>
                </div>

                <!-- Function, Aesthetic Furniture -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 feature-icon">
                        <i class="fas fa-couch text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">functional, aesthetic furniture</h3>
                    <p class="text-gray-600">We prioritize functional and beauty on all our pieces, making them both usable and appealing.</p>
                </div>

                <!-- Durable, Premium Materials -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 feature-icon">
                        <i class="fas fa-tree text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Durable, premium materials</h3>
                    <p class="text-gray-600">Our raw materials are carefully picked to ensure they meet quality standards before use in the assembly process.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Coffee Table Furnishing Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Coffee Image -->
            <div class="relative mb-12">
                <div class="relative h-96 md:h-[500px] bg-gray-200 rounded-lg overflow-hidden">
                    @if($coffeeTableProducts->count() > 0)
                        <img src="{{ $coffeeTableProducts->last()->main_image_url }}" alt="Coffee Tables" class="w-full h-full object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Coffee Tables" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 hero-overlay"></div>
                    <div class="absolute bottom-8 left-8 text-white z-10">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">COFFEE TABLES</h2>
                        <a href="{{ route('products.index', ['category' => 'coffee table']) }}" class="btn-yellow-border inline-block px-6 py-3 font-semibold">
                            Click Here
                        </a>
                    </div>
                </div>
            </div>

            <!-- Coffee Table Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Living Rooms -->
                <div class="relative category-card">
                    <div class="relative h-64 bg-gray-200 rounded-lg overflow-hidden">
                        @if($livingRoomProducts->count() > 0)
                            <img src="{{ $livingRoomProducts->last()->main_image_url }}" alt="Living Rooms" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Living Rooms" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute bottom-4 left-4">
                            <a href="{{ route('products.index', ['category' => 'living-room']) }}" class="btn-yellow-border inline-block px-4 py-2 font-semibold">
                                SHOP LIVING ROOMS
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bedroom -->
                <div class="relative category-card">
                    <div class="relative h-64 bg-gray-200 rounded-lg overflow-hidden">
                        @if($bedProducts->count() > 0)
                            <img src="{{ $bedProducts->last()->main_image_url }}" alt="Bedroom" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Bedroom" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute bottom-4 left-4">
                            <a href="{{ route('products.index', ['category' => 'bedroom']) }}" class="btn-yellow-border inline-block px-4 py-2 font-semibold">
                            BEDROOM
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dining -->
                <div class="relative category-card">
                    <div class="relative h-64 bg-gray-200 rounded-lg overflow-hidden">
                        @if($diningProducts->count() > 0)
                            <img src="{{ $diningProducts->last()->main_image_url }}" alt="Dining" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Dining" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute bottom-4 left-4">
                            <a href="{{ route('products.index', ['category' => 'dining']) }}" class="btn-yellow-border inline-block px-4 py-2 font-semibold">
                                SHOP DINING
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Hotels & Restaurants -->
                <div class="relative category-card">
                    <div class="relative h-64 bg-gray-200 rounded-lg overflow-hidden">
                        @if($diningProducts->count() > 0)
                            <img src="{{ $diningProducts->last()->main_image_url }}" alt="Hotels & Restaurants" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2016&q=80" alt="Hotels & Restaurants" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute bottom-4 left-4">
                            <a href="{{ route('products.index', ['category' => 'hotels-restaurants']) }}" class="btn-yellow-border inline-block px-4 py-2 font-semibold">
                                Hotels & Restaurants
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Testimonials Section -->
<section class="bg-white py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">
                What our customers are saying
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                <div class="w-14 h-14 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-quote-left text-white"></i>
                </div>
                <p class="text-gray-600 mb-4">
                    “The quality of the furniture exceeded my expectations. Beautiful design, very solid, and delivered on time.”
                </p>
                <h4 class="font-semibold text-gray-900">Sarah M.</h4>
                <span class="text-sm text-gray-500">Nairobi</span>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                <div class="w-14 h-14 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-quote-left text-white"></i>
                </div>
                <p class="text-gray-600 mb-4">
                    “Great craftsmanship and attention to detail. My custom sofa fits perfectly and looks amazing.”
                </p>
                <h4 class="font-semibold text-gray-900">James K.</h4>
                <span class="text-sm text-gray-500">Kiambu</span>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                <div class="w-14 h-14 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-quote-left text-white"></i>
                </div>
                <p class="text-gray-600 mb-4">
                    “Excellent service from start to finish. The furniture is both functional and stylish.”
                </p>
                <h4 class="font-semibold text-gray-900">Linda W.</h4>
                <span class="text-sm text-gray-500">Westlands</span>
            </div>
        </div>
    </div>
</section>
@endsection


<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.featured-carousel').forEach(carousel => {
        const GAP = 24; // gap-6
        const cards = carousel.children;
        if (!cards.length) return;

        // Wait for layout to settle
        requestAnimationFrame(() => {
            const cardWidth = cards[0].getBoundingClientRect().width + GAP;
            const totalUniqueCards = cards.length / 2;
            const loopWidth = totalUniqueCards * cardWidth;

            // Start in the middle
            carousel.scrollLeft = loopWidth;

            // Infinite correction
            carousel.addEventListener('scroll', () => {
                if (carousel.scrollLeft <= 0) {
                    carousel.scrollLeft += loopWidth;
                } else if (carousel.scrollLeft >= loopWidth * 2) {
                    carousel.scrollLeft -= loopWidth;
                }
            });

            // Buttons
            const wrapper = carousel.parentElement;
            wrapper.querySelector('[data-carousel-left]')
                ?.addEventListener('click', () => {
                    carousel.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                });

            wrapper.querySelector('[data-carousel-right]')
                ?.addEventListener('click', () => {
                    carousel.scrollBy({ left: cardWidth, behavior: 'smooth' });
                });
        });
    });
});
</script>
