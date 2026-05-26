<div class="chatbox-login-container">

    <!-- Background Grid -->
    <div class="chatbox-grid-bg"></div>

    <!-- Glow Orb -->
    <div class="chatbox-glow-orb"></div>

    <div class="container">
        <div class="row justify-content-center w-100 m-0">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 d-flex justify-content-center">

                <div class="card chatbox-login-card rounded-4 shadow-lg">

                    <!-- HEADER -->
                    <div class="chatbox-login-header text-center">

                        <!-- Logo -->
                        <div class="chatbox-logo-area mb-2">
                            <div class="chatbox-logo-mark mb-2" aria-hidden="true">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>

                            <div class="chatbox-brand-name">ChatBox</div>
                            <div class="chatbox-brand-sub">Real-time Messaging · Stay Connected</div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span class="chatbox-icon-lock">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                </svg>
                            </span>
                            <span class="chatbox-header-title">Sign in to your account</span>
                        </div>

                    </div>

                    <!-- BODY -->
                    <div class="chatbox-login-body card-body">

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- EMAIL -->
                            <div class="chatbox-form-group-custom">
                                <label for="email" class="chatbox-login-label">Email Address</label>
                                <input id="email" type="email"
                                       class="chatbox-login-input @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="you@example.com"
                                       required autocomplete="off" autofocus>

                                @error('email')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- PASSWORD -->
                            <div class="chatbox-form-group-custom">
                                <label for="password" class="chatbox-login-label">Password</label>
                                <input id="password" type="password"
                                       class="chatbox-login-input @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="••••••••"
                                       required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- REMEMBER -->
                            <div class="form-check chatbox-custom-check mb-3">
                                <input class="form-check-input" type="checkbox"
                                       name="remember" id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label chatbox-login-remember" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <!-- BUTTON -->
                            <button type="submit" class="chatbox-login-btn mb-3">
                                Login
                            </button>

                            <!-- FORGOT PASSWORD -->
                            @if (Route::has('password.request'))
                                <div class="text-end mb-3">
                                    <a class="chatbox-login-link" href="{{ route('password.request') }}">
                                        Forgot your password?
                                    </a>
                                </div>
                            @endif

                        </form>

                        <!-- DIVIDER -->
                        <div class="chatbox-divider"><span>OR</span></div>

                        <!-- SIGN UP -->
                        <div class="text-center mt-2">
                            <span class="chatbox-signup-text me-2">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="chatbox-signup-btn">
                                Create account
                            </a>
                        </div>

                    </div>

                    <!-- INFO STRIP -->
                    <div class="chatbox-info-strip text-center mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                        </svg>
                        Your data is fully secure and end-to-end encrypted.
                    </div>

                </div>

            </div>
        </div>
    </div>

</div> 

<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Login Container */
        .chatbox-login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 50%, #e0ebff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Grid Background */
        .chatbox-grid-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(37, 99, 235, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 1;
            animation: chatbox-grid-move 20s linear infinite;
        }

        @keyframes chatbox-grid-move {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Glow Orb */
        .chatbox-glow-orb {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15), transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            z-index: 1;
            animation: chatbox-orb-float 8s ease-in-out infinite;
        }

        @keyframes chatbox-orb-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-50px, 50px) scale(1.1); }
        }

        /* Main Container */
        .chatbox-login-container .container {
            position: relative;
            z-index: 10;
        }

        /* Login Card */
        .chatbox-login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(37, 99, 235, 0.1);
            padding: 2.5rem;
            max-width: 480px;
            width: 100%;
            transition: all 0.3s ease;
            animation: chatbox-card-entrance 0.6s ease-out;
        }

        @keyframes chatbox-card-entrance {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-login-card:hover {
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15) !important;
            transform: translateY(-2px);
        }

        /* Logo Area */
        .chatbox-logo-area {
            margin-bottom: 1.5rem;
        }

        .chatbox-logo-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6b9bff 0%, #1e3a8a 100%);
            color: #fff;
            font-size: 2rem;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
            animation: chatbox-logo-pulse 3s ease-in-out infinite;
        }

        @keyframes chatbox-logo-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .chatbox-brand-name {
            font-size: 2rem;
            font-weight: 700;
            color: #2563EB;
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }

        .chatbox-brand-sub {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Header */
        .chatbox-login-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        }

        .chatbox-icon-lock {
            width: 24px;
            height: 24px;
            color: #2563EB;
            animation: chatbox-lock-shake 2s ease-in-out infinite;
        }

        @keyframes chatbox-lock-shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }

        .chatbox-header-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }

        /* Form Groups */
        .chatbox-form-group-custom {
            margin-bottom: 1.5rem;
        }

        .chatbox-login-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #334155;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .chatbox-login-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            background: white;
        }

        .chatbox-login-input:focus {
            outline: none;
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            transform: translateY(-1px);
        }

        .chatbox-login-input.is-invalid {
            border-color: #ef4444;
        }

        .chatbox-login-input::placeholder {
            color: #94a3b8;
        }

        /* Custom Checkbox */
        .chatbox-custom-check {
            margin-bottom: 1.5rem;
        }

        .chatbox-custom-check .form-check-input {
            width: 1.125rem;
            height: 1.125rem;
            border: 2px solid #cbd5e1;
            cursor: pointer;
        }

        .chatbox-custom-check .form-check-input:checked {
            background-color: #2563EB;
            border-color: #2563EB;
        }

        .chatbox-custom-check .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .chatbox-login-remember {
            color: #475569;
            font-size: 0.9375rem;
            cursor: pointer;
        }

        /* Login Button */
        .chatbox-login-btn {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .chatbox-login-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .chatbox-login-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .chatbox-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        .chatbox-login-btn:active {
            transform: translateY(0);
        }

        /* Links */
        .chatbox-login-link {
            color: #2563EB;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .chatbox-login-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Divider */
        .chatbox-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .chatbox-divider::before,
        .chatbox-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .chatbox-divider span {
            padding: 0 1rem;
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Sign Up Section */
        .chatbox-signup-text {
            color: #64748b;
            font-size: 0.9375rem;
        }

        .chatbox-signup-btn {
            color: #2563EB;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .chatbox-signup-btn:hover {
            background: rgba(37, 99, 235, 0.1);
            color: #1d4ed8;
        }

        /* Info Strip */
        .chatbox-info-strip {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(37, 99, 235, 0.1) 100%);
            padding: 0.875rem 1.5rem;
            border-radius: 0.5rem;
            color: #475569;
            font-size: 0.8125rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .chatbox-info-strip svg {
            width: 18px;
            height: 18px;
            color: #2563EB;
            flex-shrink: 0;
        }

        /* Typing Indicator */
        .chatbox-typing-indicator {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: white;
            border-radius: 20px;
            padding: 12px 18px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 100;
            animation: chatbox-typing-bounce 2s ease-in-out infinite;
        }

        @keyframes chatbox-typing-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .chatbox-typing-indicator i {
            color: #2563EB;
            font-size: 18px;
        }

        .chatbox-typing-dots {
            display: flex;
            gap: 4px;
        }

        .chatbox-typing-dot {
            width: 6px;
            height: 6px;
            background: #2563EB;
            border-radius: 50%;
            animation: chatbox-dot-pulse 1.4s ease-in-out infinite;
        }

        .chatbox-typing-dot:nth-child(1) {
            animation-delay: 0s;
        }

        .chatbox-typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chatbox-typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes chatbox-dot-pulse {
            0%, 60%, 100% {
                transform: scale(1);
                opacity: 0.7;
            }
            30% {
                transform: scale(1.3);
                opacity: 1;
            }
        }

        /* Online Users Indicator */
        .chatbox-online-indicator {
            position: fixed;
            top: 30px;
            right: 30px;
            background: white;
            border-radius: 30px;
            padding: 10px 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
            animation: chatbox-slide-in 0.6s ease-out;
        }

        @keyframes chatbox-slide-in {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .chatbox-online-pulse {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            position: relative;
            animation: chatbox-pulse-ring 2s ease-out infinite;
        }

        @keyframes chatbox-pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .chatbox-online-text {
            color: #334155;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .chatbox-online-count {
            color: #2563EB;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .chatbox-login-card {
                padding: 1.5rem;
                margin: 1rem;
            }

            .chatbox-brand-name {
                font-size: 1.5rem;
            }

            .chatbox-logo-mark {
                width: 56px;
                height: 56px;
                font-size: 1.5rem;
            }

            .chatbox-typing-indicator,
            .chatbox-online-indicator {
                display: none;
            }
        }

        /* Invalid Feedback */
        .invalid-feedback {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
    <style>
    /* Modern Overrides */
    :root {
      --primary: hsl(220,60%,55%);
      --primary-dark: hsl(220,60%,45%);
      --bg: hsl(210,30%,96%);
      --bg-dark: hsl(210,30%,12%);
      --text: hsl(210,15%,20%);
      --text-dark: hsl(210,15%,90%);
    }
    [data-theme="dark"] {
      --bg: var(--bg-dark);
      --text: var(--text-dark);
      --primary: var(--primary-dark);
    }
    body { background: var(--bg); color: var(--text); }
    .chatbox-login-card { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px) saturate(180%); border: 1px solid rgba(255,255,255,0.2); }
    .chatbox-login-input { background: rgba(255,255,255,0.6); border-color: var(--primary); }
    .chatbox-login-input:focus { border-color: var(--primary-dark); box-shadow: 0 0 0 3px hsla(220,60%,50%,0.2); }
    .chatbox-login-btn { background: var(--primary); }
    .chatbox-login-btn:hover { background: var(--primary-dark); }
    </style>