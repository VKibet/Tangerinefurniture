<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', config('app.name', 'Tangerine Furniture') . ' - Quality Furniture & Home Decor in Kenya')</title>
    <meta name="description" content="@yield('description', 'Tangerine Furniture - Your trusted source for quality furniture and home decor in Kenya. Shop sofas, beds, tables, and more with excellent customer service.')">
    <meta name="keywords" content="@yield('keywords', 'furniture, home decor, sofas, beds, tables, Kenya, Tangerine Furniture, online shopping')">
    <meta name="author" content="Tangerine Furniture">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', config('app.name', 'Tangerine Furniture'))">
    <meta property="og:description" content="@yield('og_description', 'Your trusted source for quality furniture and home decor in Kenya')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.svg'))">
    <meta property="og:site_name" content="Tangerine Furniture">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name', 'Tangerine Furniture'))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Your trusted and quality furniture provider in Kenya')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/logo.svg'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ request()->url() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Structured Data -->
    @yield('structured_data')
</head>
<div 
    id="toastContainer" class="fixed top-5 right-5 space-y-3 z-50">
</div>
<body class="bg-gray-50">
    @include('components.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')

    <!-- WhatsApp Chat Widget -->
    <div id="wa-widget" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">

        <!-- Chat bubble popup -->
        <div id="wa-bubble"
             class="hidden bg-white rounded-2xl shadow-2xl border border-gray-100 w-72 overflow-hidden"
             style="animation: waSlideUp .25s ease;">
            <!-- Header -->
            <div class="bg-[#25D366] px-4 py-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center flex-shrink-0">
                    <i class="fab fa-whatsapp text-white text-2xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold text-sm leading-tight">Tangerine Furniture</p>
                    <p class="text-green-100 text-xs">Typically replies instantly</p>
                </div>
                <button onclick="toggleWa()" class="text-white opacity-70 hover:opacity-100 ml-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Chat preview -->
            <div class="bg-[#ece5dd] px-4 py-4">
                <div class="bg-white rounded-xl rounded-tl-none px-3 py-2.5 shadow-sm max-w-[90%]">
                    <p class="text-gray-800 text-sm leading-snug">
                        👋 Hi there! Welcome to <strong>Tangerine Furniture</strong>.<br>
                        How can we help you today?
                    </p>
                    <p class="text-gray-400 text-xs mt-1 text-right">Just now</p>
                </div>
            </div>
            <!-- CTA -->
            <a href="https://wa.me/254791708894?text=Hello%2C%20I%20am%20interested%20in%20your%20furniture."
               target="_blank" rel="noopener noreferrer"
               class="flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#1ebe5d] text-white font-semibold text-sm py-3 transition-colors">
                <i class="fab fa-whatsapp text-lg"></i>
                Start Chat on WhatsApp
            </a>
        </div>

        <!-- Floating button -->
        <button onclick="toggleWa()" id="wa-btn"
                class="w-14 h-14 bg-[#25D366] hover:bg-[#1ebe5d] text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-200 hover:scale-110 relative">
            <i class="fab fa-whatsapp text-3xl"></i>
            <!-- Notification dot -->
            <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 rounded-full border-2 border-white" id="wa-dot"></span>
        </button>
    </div>

    <style>
        @keyframes waSlideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes waPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37,211,102,.5); }
            60%       { box-shadow: 0 0 0 10px rgba(37,211,102,0); }
        }
        #wa-btn { animation: waPulse 2.5s infinite; }
    </style>

    <script>
        function toggleWa() {
            var bubble = document.getElementById('wa-bubble');
            var dot    = document.getElementById('wa-dot');
            bubble.classList.toggle('hidden');
            if (!bubble.classList.contains('hidden')) {
                bubble.style.animation = 'none';
                void bubble.offsetWidth;
                bubble.style.animation = 'waSlideUp .25s ease';
                dot.style.display = 'none';
            }
        }
        // Show dot after 3 seconds to draw attention
        setTimeout(function() {
            var dot = document.getElementById('wa-dot');
            if (dot) dot.style.display = 'block';
        }, 3000);
    </script>

    @stack('scripts')
</body>
</html>
