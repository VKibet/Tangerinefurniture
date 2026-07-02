<x-guest-layout>

    <!-- Mobile logo (only visible on small screens since brand panel is hidden) -->
    <div style="display:none;" id="mobile-logo">
        <a href="{{ route('home') }}" style="text-decoration:none;">
            <p style="font-size:22px;font-weight:800;color:#111;margin:0 0 24px;">TANGERINE <span style="color:#f97316;">FURNITURE</span></p>
        </a>
    </div>
    <style>
        @media(max-width:768px){ #mobile-logo { display:block !important; } }
    </style>

    <!-- Heading -->
    <div style="margin-bottom:28px;">
        <h1 style="font-size:26px;font-weight:800;color:#111;margin:0 0 6px;">Welcome back</h1>
        <p style="font-size:14px;color:#6b7280;margin:0;">Sign in to your account to continue</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;border-radius:10px;padding:12px 14px;font-size:13px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <!-- Validation errors summary -->
    @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;border-radius:10px;padding:12px 14px;font-size:13px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:18px;">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="form-label">Email address</label>
            <div class="input-wrap">
                <i class="fas fa-envelope input-icon"></i>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       placeholder="you@example.com"
                       class="form-input {{ $errors->get('email') ? 'error' : '' }}"
                       style="padding-left:38px;">
            </div>
            @if($errors->get('email'))
                <p class="err-msg"><i class="fas fa-circle-exclamation" style="font-size:11px;"></i> {{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                <label for="password" class="form-label" style="margin-bottom:0;">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       style="font-size:13px;color:#f97316;text-decoration:none;font-weight:500;">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="input-wrap">
                <i class="fas fa-lock input-icon"></i>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="Enter your password"
                       class="form-input {{ $errors->get('password') ? 'error' : '' }}"
                       style="padding-left:38px;padding-right:40px;">
                <button type="button" class="toggle-pw" onclick="togglePw()" id="pw-toggle" title="Show/hide password">
                    <i class="fas fa-eye" id="pw-icon"></i>
                </button>
            </div>
            @if($errors->get('password'))
                <p class="err-msg"><i class="fas fa-circle-exclamation" style="font-size:11px;"></i> {{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember me -->
        <div style="display:flex;align-items:center;gap:8px;">
            <input id="remember_me"
                   type="checkbox"
                   name="remember"
                   style="width:16px;height:16px;accent-color:#f97316;cursor:pointer;">
            <label for="remember_me" style="font-size:13px;color:#374151;cursor:pointer;user-select:none;">
                Keep me signed in for 30 days
            </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary" style="margin-top:4px;">
            Sign In &nbsp;<i class="fas fa-arrow-right" style="font-size:13px;"></i>
        </button>

    </form>

    <!-- Footer links -->
    <div style="margin-top:28px;text-align:center;">
        <p style="font-size:13px;color:#9ca3af;margin:0;">
            Don't have an account?
            @if(Route::has('register'))
                <a href="{{ route('register') }}" style="color:#f97316;font-weight:600;text-decoration:none;"> Create one</a>
            @endif
        </p>
        <a href="{{ route('home') }}"
           style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#9ca3af;text-decoration:none;margin-top:12px;">
            <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back to store
        </a>
    </div>

    <script>
        function togglePw() {
            var input = document.getElementById('password');
            var icon  = document.getElementById('pw-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>

</x-guest-layout>
