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
<body class="bg-gray-50">

    <div id="toastContainer" style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:12px;"></div>

    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- WhatsApp Chat Widget -->
    <style>
        #wa-widget { position:fixed; bottom:24px; right:24px; z-index:9998; display:flex; flex-direction:column; align-items:flex-end; gap:12px; }
        #wa-bubble { display:none; width:288px; background:#fff; border-radius:16px; box-shadow:0 8px 32px rgba(0,0,0,.18); overflow:hidden; }
        #wa-bubble.open { display:block; animation:waSlideUp .25s ease; }
        .wa-header { background:#25D366; padding:12px 16px; display:flex; align-items:center; gap:12px; }
        .wa-icon-wrap { width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .wa-chat-bg { background:#ece5dd; padding:16px; }
        .wa-msg { background:#fff; border-radius:0 12px 12px 12px; padding:10px 12px; max-width:90%; box-shadow:0 1px 3px rgba(0,0,0,.1); }
        .wa-cta { display:flex; align-items:center; justify-content:center; gap:8px; background:#25D366; color:#fff; font-weight:600; font-size:14px; padding:12px; text-decoration:none; transition:background .2s; }
        .wa-cta:hover { background:#1ebe5d; }
        #wa-btn { width:56px; height:56px; background:#25D366; border:none; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(37,211,102,.5); transition:transform .2s, background .2s; position:relative; }
        #wa-btn:hover { background:#1ebe5d; transform:scale(1.1); }
        #wa-dot { position:absolute; top:-2px; right:-2px; width:14px; height:14px; background:#ef4444; border-radius:50%; border:2px solid #fff; }
        @keyframes waSlideUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        @keyframes waPulse { 0%,100%{box-shadow:0 0 0 0 rgba(37,211,102,.5)} 60%{box-shadow:0 0 0 12px rgba(37,211,102,0)} }
        #wa-btn { animation: waPulse 2.5s infinite; }
    </style>

    <div id="wa-widget">
        <div id="wa-bubble">
            <div class="wa-header">
                <div class="wa-icon-wrap">
                    <i class="fab fa-whatsapp" style="color:#fff;font-size:22px;"></i>
                </div>
                <div style="flex:1;">
                    <p style="color:#fff;font-weight:600;font-size:14px;margin:0;line-height:1.3;">Tangerine Furniture</p>
                    <p style="color:rgba(255,255,255,.75);font-size:12px;margin:0;">Typically replies instantly</p>
                </div>
                <button onclick="toggleWa()" style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.8);font-size:16px;padding:0;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="wa-chat-bg">
                <div class="wa-msg">
                    <p style="color:#333;font-size:13px;margin:0;line-height:1.5;">
                        👋 Hi there! Welcome to <strong>Tangerine Furniture</strong>.<br>
                        How can we help you today?
                    </p>
                    <p style="color:#aaa;font-size:11px;margin:4px 0 0;text-align:right;">Just now</p>
                </div>
            </div>
            <a href="https://wa.me/254791708894?text=Hello%2C%20I%20am%20interested%20in%20your%20furniture."
               target="_blank" rel="noopener noreferrer" class="wa-cta">
                <i class="fab fa-whatsapp" style="font-size:18px;"></i>
                Start Chat on WhatsApp
            </a>
        </div>

        <button onclick="toggleWa()" id="wa-btn" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp" style="color:#fff;font-size:28px;"></i>
            <span id="wa-dot"></span>
        </button>
    </div>

    <script>
        function toggleWa() {
            var bubble = document.getElementById('wa-bubble');
            var dot    = document.getElementById('wa-dot');
            bubble.classList.toggle('open');
            if (bubble.classList.contains('open')) dot.style.display = 'none';
        }
        setTimeout(function() {
            var dot = document.getElementById('wa-dot');
            if (dot) dot.style.display = 'block';
        }, 3000);
    </script>

    @stack('scripts')
</body>
</html>
