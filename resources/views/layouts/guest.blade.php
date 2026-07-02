<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Tangerine Furniture') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Figtree', sans-serif; background: #f8f8f6; }

        .auth-wrap {
            min-height: 100vh;
            display: flex;
        }

        /* Left brand panel */
        .auth-brand {
            flex: 1;
            background: #1a1a1a;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .auth-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=900&auto=format&fit=crop&q=60') center/cover no-repeat;
            opacity: 0.22;
        }
        .auth-brand-content { position: relative; z-index: 1; }
        .auth-logo { display: flex; align-items: center; gap: 12px; margin-bottom: auto; }
        .auth-logo-text { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .auth-logo-text span { color: #f97316; }
        .auth-tagline { margin-top: auto; }
        .auth-tagline h2 { color: #fff; font-size: 32px; font-weight: 700; line-height: 1.2; margin: 0 0 12px; }
        .auth-tagline p { color: rgba(255,255,255,.6); font-size: 15px; margin: 0; line-height: 1.6; }
        .auth-dots { display: flex; gap: 8px; margin-top: 32px; }
        .auth-dots span { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.3); }
        .auth-dots span.active { background: #f97316; width: 24px; border-radius: 4px; }

        /* Right form panel */
        .auth-form-panel {
            width: 480px;
            flex-shrink: 0;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 48px;
            overflow-y: auto;
        }

        /* Mobile: stack vertically */
        @media (max-width: 768px) {
            .auth-wrap { flex-direction: column; }
            .auth-brand { display: none; }
            .auth-form-panel { width: 100%; padding: 32px 24px; min-height: 100vh; justify-content: center; }
        }

        /* Form styles */
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            color: #111;
            background: #fafafa;
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }
        .form-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.12); background: #fff; }
        .form-input.error { border-color: #ef4444; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 14px; pointer-events: none; }
        .input-icon ~ .form-input { padding-left: 38px; }
        .toggle-pw { position: absolute; right: 13px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 14px; padding: 0; }
        .toggle-pw:hover { color: #6b7280; }
        .err-msg { font-size: 12px; color: #ef4444; margin-top: 5px; }
        .btn-primary {
            width: 100%;
            padding: 13px;
            background: #f97316;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s, transform .1s;
            letter-spacing: .2px;
        }
        .btn-primary:hover { background: #ea6c0a; }
        .btn-primary:active { transform: scale(.99); }
        .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
        .divider hr { flex: 1; border: none; border-top: 1px solid #e5e7eb; }
        .divider span { font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="auth-wrap">

    <!-- Brand Panel -->
    <div class="auth-brand">
        <div class="auth-brand-content">
            <div class="auth-logo">
                <a href="{{ route('home') }}" style="text-decoration:none;">
                    <span class="auth-logo-text">TANGERINE <span>FURNITURE</span></span>
                </a>
            </div>
        </div>
        <div class="auth-brand-content auth-tagline">
            <h2>Crafting beautiful spaces,<br>one piece at a time.</h2>
            <p>Quality furniture for every home in Kenya.<br>Discover pieces that tell your story.</p>
            <div class="auth-dots">
                <span class="active"></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Form Panel -->
    <div class="auth-form-panel">
        {{ $slot }}
    </div>

</div>
</body>
</html>
