<div class="chatbox-login-container">

    <!-- Animated Particles (FIXED: unified naming) -->
    <div class="chatbox-particles" id="particles">
        <span class="chatbox-particle" style="left:5%;  width:8px;  height:10px; animation-duration:9s;  animation-delay:0s;   bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:12%; width:5px;  height:7px;  animation-duration:12s; animation-delay:1.5s; bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:22%; width:11px; height:14px; animation-duration:8s;  animation-delay:3s;   bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:35%; width:6px;  height:8px;  animation-duration:14s; animation-delay:.8s;  bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:48%; width:9px;  height:12px; animation-duration:10s; animation-delay:2s;   bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:58%; width:5px;  height:7px;  animation-duration:11s; animation-delay:4s;   bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:70%; width:12px; height:15px; animation-duration:7s;  animation-delay:.3s;  bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:80%; width:7px;  height:9px;  animation-duration:13s; animation-delay:2.7s; bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:90%; width:10px; height:13px; animation-duration:9s;  animation-delay:1s;   bottom:-20px;"></span>
        <span class="chatbox-particle" style="left:96%; width:6px;  height:8px;  animation-duration:15s; animation-delay:3.5s; bottom:-20px;"></span>

        <!-- Cross particles FIXED -->
        <span class="chatbox-cross-particle" style="left:8%;  animation-duration:14s; animation-delay:1s;">+</span>
        <span class="chatbox-cross-particle" style="left:28%; animation-duration:11s; animation-delay:3s;">✚</span>
        <span class="chatbox-cross-particle" style="left:55%; animation-duration:16s; animation-delay:.5s;">+</span>
        <span class="chatbox-cross-particle" style="left:75%; animation-duration:10s; animation-delay:2s;">✚</span>
        <span class="chatbox-cross-particle" style="left:92%; animation-duration:13s; animation-delay:4s;">+</span>
    </div>

    <div class="chatbox-login-wrapper">

        <!-- Brand -->
        <div class="chatbox-brand-top chatbox-mb-4 chatbox-text-center">
            <div class="chatbox-brand-icon chatbox-mb-2">
                <i class="bi bi-chat-dots-fill"></i>
            </div>
            <div class="chatbox-brand-text">
                <span class="chatbox-brand-name chatbox-d-block">ChatBox</span>
                <span class="chatbox-brand-sub">Real-time Chat · Connect Instantly</span>
            </div>
        </div>

        <!-- Card -->
        <div class="chatbox-card">

            <!-- Header -->
            <div class="chatbox-header chatbox-d-flex chatbox-align-items-center chatbox-justify-content-between">
                <div class="chatbox-header-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <span>Create Your Account</span>
                <div class="chatbox-blood-drops chatbox-d-flex chatbox-gap-1">
                    <div class="chatbox-drop"></div>
                    <div class="chatbox-drop"></div>
                    <div class="chatbox-drop"></div>
                </div>
            </div>

            <!-- Step bar -->
            <div class="chatbox-step-bar chatbox-mb-3">
                <span class="chatbox-active"></span>
                <span class="chatbox-active"></span>
                <span></span>
                <span></span>
            </div>

            <!-- Body -->
            <div class="chatbox-body">
                <form id="chatboxRegisterForm" method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf

                    <!-- Name -->
                    <div class="chatbox-input-group chatbox-mb-3">
                        <label class="chatbox-label">Full Name</label>
                        <div class="chatbox-input-wrap">
                            <i class="bi bi-person-fill chatbox-field-icon"></i>
                            <input id="name" type="text" class="chatbox-input" placeholder="Enter Your Full Name" name="name" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="chatbox-input-group chatbox-mb-3">
                        <label class="chatbox-label">Email</label>
                        <div class="chatbox-input-wrap">
                            <i class="bi bi-envelope-fill chatbox-field-icon"></i>
                            <input id="email" type="email" class="chatbox-input" placeholder="Enter Your Email" name="email" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="chatbox-input-group chatbox-mb-3">
                        <label class="chatbox-label">Password</label>
                        <div class="chatbox-input-wrap">
                            <i class="bi bi-lock-fill chatbox-field-icon"></i>
                            <input id="password" type="password" class="chatbox-input" placeholder="Enter Your Password" name="password" required>
                        </div>

                        <div class="chatbox-password-checker">
                            <div class="chatbox-checker-dots" id="strength-dots">
                                <span class="chatbox-checker-dot"></span>
                                <span class="chatbox-checker-dot"></span>
                                <span class="chatbox-checker-dot"></span>
                                <span class="chatbox-checker-dot"></span>
                                <span class="chatbox-checker-dot"></span>
                                <span class="chatbox-checker-dot"></span>
                            </div>
                            <span class="chatbox-checker-text" id="strength-text">
                                Use 8+ characters with numbers, uppercase & symbols
                            </span>
                        </div>
                    </div>

                    <!-- Confirm -->
                    <div class="chatbox-input-group chatbox-mb-3">
                        <label class="chatbox-label">Confirm Password</label>
                        <div class="chatbox-input-wrap">
                            <i class="bi bi-shield-fill-check chatbox-field-icon"></i>
                            <input id="password-confirm" type="password" class="chatbox-input" placeholder="Confirm Password" name="password_confirmation" required>
                        </div>

                        <div class="chatbox-password-match" id="password-match">
                            Passwords do not match yet
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="chatbox-input-group chatbox-mt-4 chatbox-d-flex chatbox-flex-column chatbox-gap-3">
                        <button type="submit" class="chatbox-btn">Register Now</button>
                        <a href="{{ route('login') }}" class="chatbox-link">
                            Already have an account? Sign in
                        </a>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

<script>
const passwordInput = document.getElementById('password');
const passwordConfirm = document.getElementById('password-confirm');
const strengthDots = document.getElementById('strength-dots');
const strengthText = document.getElementById('strength-text');
const passwordMatch = document.getElementById('password-match');

passwordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    const strength = calculatePasswordStrength(password);

    const dots = strengthDots.querySelectorAll('.chatbox-checker-dot');

    dots.forEach((dot, i) => {
        dot.className = 'chatbox-checker-dot';
        if (i < strength.level) {
            dot.classList.add(strength.class);
        }
    });

    strengthText.textContent = strength.text;
    checkMatch();
});

passwordConfirm.addEventListener('input', checkMatch);

function calculatePasswordStrength(password) {
    let level = 0;

    if (password.length >= 8) level++;
    if (password.length >= 12) level++;
    if (/[A-Z]/.test(password)) level++;
    if (/[0-9]/.test(password)) level++;
    if (/[^A-Za-z0-9]/.test(password)) level++;

    let cls = 'chatbox-weak';
    let text = 'Weak password';

    if (level >= 4) {
        cls = 'chatbox-strong';
        text = 'Strong password';
    } else if (level >= 2) {
        cls = 'chatbox-medium';
        text = 'Medium strength';
    }

    return { level, class: cls, text };
}

function checkMatch() {
    if (!passwordConfirm.value) return;

    passwordMatch.classList.add('chatbox-show');

    if (passwordInput.value === passwordConfirm.value) {
        passwordMatch.classList.add('chatbox-match-success');
        passwordMatch.textContent = '✓ Passwords match';
    } else {
        passwordMatch.classList.remove('chatbox-match-success');
        passwordMatch.textContent = 'Passwords do not match yet';
    }
}

document.getElementById('chatboxRegisterForm').addEventListener('submit', function(e) {
    if (passwordInput.value !== passwordConfirm.value) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script>

<!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        .chatbox-login-container {
            position: relative;
            width: 100%;
            max-width: 420px; /* reduced width for better fit */
            z-index: 1;
            padding-top: 40px; /* Added top padding to prevent cut-off */
            padding-bottom: 20px; /* extra bottom padding */
        }

        /* Animated Particles */
        .chatbox-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .chatbox-particle {
            position: absolute;
            background: linear-gradient(135deg, #2563EB, #3b82f6);
            border-radius: 50%;
            opacity: 0.6;
            animation: chatbox-float-up linear infinite;
        }

        .chatbox-cross-particle {
            position: absolute;
            color: #2563EB;
            font-size: 20px;
            opacity: 0.5;
            animation: chatbox-float-up linear infinite;
            font-weight: bold;
        }

        @keyframes chatbox-float-up {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Message Bubble Animations */
        .chatbox-message-bubble {
            position: fixed;
            background: #2563EB;
            color: white;
            padding: 12px 18px;
            border-radius: 18px 18px 18px 4px;
            font-size: 14px;
            opacity: 0;
            animation: chatbox-message-appear 8s ease-in-out infinite;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            max-width: 200px;
            z-index: 0;
        }

        .chatbox-message-bubble:nth-child(1) {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .chatbox-message-bubble:nth-child(2) {
            top: 25%;
            right: 8%;
            animation-delay: 2s;
            background: #3b82f6;
            border-radius: 18px 18px 4px 18px;
        }

        .chatbox-message-bubble:nth-child(3) {
            bottom: 15%;
            left: 10%;
            animation-delay: 4s;
        }

        .chatbox-message-bubble:nth-child(4) {
            top: 60%;
            right: 5%;
            animation-delay: 6s;
            background: #3b82f6;
            border-radius: 18px 18px 4px 18px;
        }

        @keyframes chatbox-message-appear {
            0%, 100% {
                opacity: 0;
                transform: translateY(20px) scale(0.8);
            }
            10%, 90% {
                opacity: 0.7;
                transform: translateY(0) scale(1);
            }
        }

        .chatbox-login-wrapper {
            position: relative;
            z-index: 1;
        }

        /* Brand Section */
        .chatbox-brand-top {
            text-align: center;
            margin-bottom: 1.5rem;
            animation: chatbox-brand-entrance 0.8s ease-out;
        }

        @keyframes chatbox-brand-entrance {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #2563EB, #3b82f6);
            border-radius: 20px;
            margin-bottom: 12px;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
            animation: chatbox-icon-pulse 2s ease-in-out infinite;
        }

        @keyframes chatbox-icon-pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 12px 32px rgba(37, 99, 235, 0.4);
            }
        }

        .chatbox-brand-icon i {
            font-size: 36px;
            color: white;
        }

        .chatbox-brand-name {
            font-size: 28px;
            font-weight: 700;
            color: #2563EB;
            display: block;
            margin-bottom: 4px;
        }

        .chatbox-brand-sub {
            font-size: 13px;
            color: #64748b;
        }

        /* Main Card */
        .chatbox-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: chatbox-card-entrance 0.8s ease-out 0.2s backwards;
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

        /* Header */
        .chatbox-header {
            background: linear-gradient(135deg, #2563EB 0%, #3b82f6 100%);
            color: white;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .chatbox-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: chatbox-header-glow 3s ease-in-out infinite;
        }

        @keyframes chatbox-header-glow {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(20px, 20px);
            }
        }

        .chatbox-header-icon {
            width: 24px;
            height: 24px;
            z-index: 1;
        }

        .chatbox-header-icon i {
            font-size: 24px;
            color: white;
        }

        .chatbox-header > span {
            z-index: 1;
        }

        .chatbox-blood-drops {
            display: flex;
            gap: 6px;
            z-index: 1;
        }

        .chatbox-drop {
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: chatbox-drop-pulse 1.5s ease-in-out infinite;
        }

        .chatbox-drop:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chatbox-drop:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes chatbox-drop-pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.3);
                opacity: 1;
            }
        }

        /* Step Progress Bar */
        .chatbox-step-bar {
            display: flex;
            gap: 8px;
            padding: 16px 24px 0;
        }

        .chatbox-step-bar span {
            flex: 1;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            transition: all 0.4s ease;
        }

        .chatbox-step-bar span.chatbox-active {
            background: linear-gradient(90deg, #2563EB, #3b82f6);
            animation: chatbox-step-fill 0.6s ease-out;
        }

        @keyframes chatbox-step-fill {
            from {
                transform: scaleX(0);
            }
            to {
                transform: scaleX(1);
            }
        }

        /* Body */
        .chatbox-body {
            padding: 16px; /* reduced padding for compact box */
        }

        /* Input Groups */
        .chatbox-input-group {
            margin-bottom: 20px;
            animation: chatbox-input-entrance 0.6s ease-out backwards;
        }

        .chatbox-input-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .chatbox-input-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chatbox-input-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .chatbox-input-group:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes chatbox-input-entrance {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .chatbox-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .chatbox-input-wrap {
            position: relative;
        }

        .chatbox-field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #64748b;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .chatbox-input {
            width: 100%;
            padding: 14px 14px 14px 44px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            background: white;
        }

        .chatbox-input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .chatbox-input:focus + .chatbox-field-icon,
        .chatbox-input-wrap:focus-within .chatbox-field-icon {
            color: #2563EB;
            transform: translateY(-50%) scale(1.1);
        }

        /* Password Checker */
        .chatbox-password-checker {
            margin-top: 10px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid #cbd5e1;
        }

        .chatbox-checker-dots {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
        }

        .chatbox-checker-dot {
            flex: 1;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .chatbox-checker-dot.chatbox-weak {
            background: #ef4444;
        }

        .chatbox-checker-dot.chatbox-medium {
            background: #f59e0b;
        }

        .chatbox-checker-dot.chatbox-strong {
            background: #10b981;
        }

        .chatbox-checker-text {
            font-size: 12px;
            color: #64748b;
            display: block;
        }

        .chatbox-checker-text.chatbox-weak-text {
            color: #ef4444;
        }

        .chatbox-checker-text.chatbox-medium-text {
            color: #f59e0b;
        }

        .chatbox-checker-text.chatbox-strong-text {
            color: #10b981;
        }

        /* Password Match */
        .chatbox-password-match {
            margin-top: 10px;
            padding: 10px 12px;
            background: #fef2f2;
            border-radius: 8px;
            font-size: 13px;
            color: #dc2626;
            border-left: 3px solid #ef4444;
            display: none;
        }

        .chatbox-password-match.chatbox-match-success {
            background: #f0fdf4;
            color: #16a34a;
            border-left-color: #10b981;
        }

        .chatbox-password-match.chatbox-show {
            display: block;
            animation: chatbox-match-slide 0.3s ease-out;
        }

        @keyframes chatbox-match-slide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button */
        .chatbox-btn {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #2563EB 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            position: relative;
            overflow: hidden;
        }

        .chatbox-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .chatbox-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .chatbox-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        .chatbox-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .chatbox-divider {
            text-align: center;
            position: relative;
            margin: 20px 0;
        }

        .chatbox-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .chatbox-divider span {
            background: white;
            padding: 0 16px;
            color: #94a3b8;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        /* Link */
        .chatbox-link {
            display: block;
            text-align: center;
            color: #2563EB;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .chatbox-link:hover {
            background: #eff6ff;
            color: #1d4ed8;
        }

        /* Footer Strip */
        .chatbox-card-footer-strip {
            height: 6px;
            background: linear-gradient(90deg, #2563EB 0%, #3b82f6 50%, #2563EB 100%);
            background-size: 200% 100%;
            animation: chatbox-strip-slide 3s linear infinite;
        }

        @keyframes chatbox-strip-slide {
            0% {
                background-position: 0% 0%;
            }
            100% {
                background-position: 200% 0%;
            }
        }

        /* Page Footer */
        .chatbox-page-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
        }

        /* Typing Indicator Animation */
        .chatbox-typing-indicator {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: white;
            padding: 12px 18px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            animation: chatbox-typing-appear 4s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes chatbox-typing-appear {
            0%, 100% {
                opacity: 0;
                transform: translateY(20px);
            }
            25%, 75% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-typing-dot {
            width: 8px;
            height: 8px;
            background: #2563EB;
            border-radius: 50%;
            animation: chatbox-typing-bounce 1.4s ease-in-out infinite;
        }

        .chatbox-typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chatbox-typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes chatbox-typing-bounce {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-8px);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .chatbox-brand-name {
                font-size: 24px;
            }

            .chatbox-body {
                padding: 20px;
            }

            .chatbox-message-bubble {
                font-size: 12px;
                padding: 10px 14px;
            }
        }

        /* Utility Classes */
        .chatbox-mb-2 { margin-bottom: 8px; }
        .chatbox-mb-3 { margin-bottom: 16px; }
        .chatbox-mb-4 { margin-bottom: 24px; }
        .chatbox-mt-3 { margin-top: 16px; }
        .chatbox-mt-4 { margin-top: 24px; }
        .chatbox-d-block { display: block; }
        .chatbox-d-flex { display: flex; }
        .chatbox-flex-column { flex-direction: column; }
        .chatbox-gap-1 { gap: 4px; }
        .chatbox-gap-3 { gap: 16px; }
        .chatbox-text-center { text-align: center; }
        .chatbox-align-items-center { align-items: center; }
        .chatbox-justify-content-between { justify-content: space-between; }
    </style>