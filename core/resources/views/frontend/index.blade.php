@extends('frontend.app')

@section('content')

 <div class="chatbox-landing-page" id="landingPage">
        
        <!-- Hero Section -->
        <section class="chatbox-hero-section">
            <!-- Floating Message Bubbles -->
            <div class="chatbox-message-bubble"></div>
            <div class="chatbox-message-bubble"></div>
            <div class="chatbox-message-bubble"></div>
            <div class="chatbox-message-bubble"></div>
            <div class="chatbox-message-bubble"></div>

            <div class="chatbox-hero-container">
                <h1 class="chatbox-hero-title">Welcome to ChatBox</h1>
                <p class="chatbox-hero-description">
                    ChatBox is a modern social messaging platform designed to connect people instantly.
                    Fast, secure, and simple communication for everyone.
                </p>

                <a href="{{ auth()->check() ? route('message', auth()->id()) : "/login" }}" class="chatbox-btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Get Started
                </a>
            </div>
        </section>

        <!-- Features -->
        <section class="chatbox-features-section">
            <div class="chatbox-container">
                <div class="chatbox-features-grid">

                    <div class="chatbox-feature-card chatbox-scroll-reveal">
                        <i class="bi bi-lightning-charge chatbox-feature-icon"></i>
                        <h5 class="chatbox-feature-title">Fast Messaging</h5>
                        <p class="chatbox-feature-text">Send and receive messages instantly with high speed performance.</p>
                        <div class="chatbox-typing-indicator">
                            <span class="chatbox-typing-dot"></span>
                            <span class="chatbox-typing-dot"></span>
                            <span class="chatbox-typing-dot"></span>
                        </div>
                    </div>

                    <div class="chatbox-feature-card chatbox-scroll-reveal">
                        <i class="bi bi-shield-lock chatbox-feature-icon"></i>
                        <h5 class="chatbox-feature-title">Secure Chat</h5>
                        <p class="chatbox-feature-text">Your messages are protected with modern security standards.</p>
                        <div class="chatbox-typing-indicator">
                            <span class="chatbox-typing-dot"></span>
                            <span class="chatbox-typing-dot"></span>
                            <span class="chatbox-typing-dot"></span>
                        </div>
                    </div>

                    <div class="chatbox-feature-card chatbox-scroll-reveal">
                        <i class="bi bi-people chatbox-feature-icon"></i>
                        <h5 class="chatbox-feature-title">Connect People</h5>
                        <p class="chatbox-feature-text">Build connections and stay in touch with friends easily.</p>
                        <div class="chatbox-typing-indicator">
                            <span class="chatbox-typing-dot"></span>
                            <span class="chatbox-typing-dot"></span>
                            <span class="chatbox-typing-dot"></span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- About -->
        <section class="chatbox-about-section">
            <div class="chatbox-container">
                <h2 class="chatbox-about-title">About ChatBox</h2>
                <p class="chatbox-about-text">
                    ChatBox is a lightweight and modern messaging platform focused on simplicity and speed.
                    It helps users communicate in real-time with a clean and distraction-free interface.
                </p>
            </div>
        </section>

    </div>

   <!-- Floating Message Send Button -->
    <a href="{{ auth()->check() ? route('message', auth()->id()) : "/login" }}" class="chatbox-message-send-animation">
        <i class="bi bi-chat-dots-fill"></i>
    </a>

    <script>
        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('chatbox-active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.chatbox-scroll-reveal').forEach(element => {
            observer.observe(element);
        });

        // Get Started Button Click Animation
        document.getElementById('getStartedBtn').addEventListener('click', function(e) {
            e.preventDefault();
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });

        // Floating Message Send Button Click
        document.querySelector('.chatbox-message-send-animation').addEventListener('click', function() {
            this.style.animation = 'none';
            setTimeout(() => {
                this.style.animation = 'chatbox-send-pulse 2s ease-in-out infinite';
            }, 10);
        });
    </script>

    <style>
        /* Landing Page Container — scoped so global resets do not break the top navbar */
        .chatbox-landing-page {
            width: 100%;
            min-height: calc(100vh - var(--chatbox-navbar-height, 64px));
        }

        /* Hero Section Styles */
        .chatbox-landing-page .chatbox-hero-section {
            position: relative;
            min-height: calc(100vh - var(--chatbox-navbar-height, 64px));
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            overflow: hidden;
            padding: 2rem 1rem;
        }

        /* Animated Background Bubbles */
        .chatbox-landing-page .chatbox-hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -150px;
            animation: chatbox-float-bubble 8s ease-in-out infinite;
        }

        .chatbox-landing-page .chatbox-hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: chatbox-float-bubble 6s ease-in-out infinite reverse;
        }

        @keyframes chatbox-float-bubble {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        /* Message Bubbles Floating Animation */
        .chatbox-landing-page .chatbox-message-bubble {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50% 50% 50% 0;
            animation: chatbox-bubble-rise 10s linear infinite;
            opacity: 0;
        }

        .chatbox-landing-page .chatbox-message-bubble:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 12s;
        }

        .chatbox-landing-page .chatbox-message-bubble:nth-child(2) {
            left: 30%;
            animation-delay: 2s;
            animation-duration: 10s;
        }

        .chatbox-landing-page .chatbox-message-bubble:nth-child(3) {
            left: 50%;
            animation-delay: 4s;
            animation-duration: 14s;
        }

        .chatbox-landing-page .chatbox-message-bubble:nth-child(4) {
            left: 70%;
            animation-delay: 6s;
            animation-duration: 11s;
        }

        .chatbox-landing-page .chatbox-message-bubble:nth-child(5) {
            left: 85%;
            animation-delay: 8s;
            animation-duration: 13s;
        }

        @keyframes chatbox-bubble-rise {
            0% {
                bottom: -100px;
                opacity: 0;
                transform: scale(0.5) rotate(0deg);
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
            }
            100% {
                bottom: 100vh;
                opacity: 0;
                transform: scale(1) rotate(180deg);
            }
        }

        .chatbox-landing-page .chatbox-hero-container {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .chatbox-landing-page .chatbox-hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 1.5rem;
            animation: chatbox-slide-down 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .chatbox-landing-page .chatbox-hero-description {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.95);
            max-width: 700px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
            animation: chatbox-fade-in 1s ease-out 0.3s backwards;
        }

        @keyframes chatbox-slide-down {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes chatbox-fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .chatbox-landing-page .chatbox-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #FFFFFF;
            color: #2563EB;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: chatbox-pulse-button 2s ease-in-out infinite;
        }

        .chatbox-landing-page .chatbox-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            background: #f8fafc;
        }

        @keyframes chatbox-pulse-button {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .chatbox-landing-page .chatbox-btn-primary i {
            font-size: 1.5rem;
            animation: chatbox-arrow-bounce 1.5s ease-in-out infinite;
        }

        @keyframes chatbox-arrow-bounce {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(5px);
            }
        }

        /* Features Section */
        .chatbox-landing-page .chatbox-features-section {
            padding: 6rem 1rem;
            background: #f8fafc;
            position: relative;
        }

        .chatbox-landing-page .chatbox-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .chatbox-landing-page .chatbox-features-section .chatbox-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .chatbox-landing-page .chatbox-features-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            gap: 2rem;
            margin: 3rem auto 0;
            max-width: 1200px;
            width: 100%;
        }

        .chatbox-landing-page .chatbox-features-grid .chatbox-feature-card {
            flex: 0 1 320px;
            width: 100%;
            max-width: 360px;
        }

        .chatbox-landing-page .chatbox-feature-card {
            background: #FFFFFF;
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.4s ease;
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.08);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .chatbox-landing-page .chatbox-feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .chatbox-landing-page .chatbox-feature-card:hover::before {
            left: 100%;
        }

        .chatbox-landing-page .chatbox-feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.15);
            border-color: #2563EB;
        }

        .chatbox-landing-page .chatbox-feature-icon {
            font-size: 4rem;
            color: #2563EB;
            margin-bottom: 1.5rem;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .chatbox-landing-page .chatbox-feature-card:hover .chatbox-feature-icon {
            transform: scale(1.2) rotate(5deg);
            animation: chatbox-icon-shake 0.5s ease;
        }

        @keyframes chatbox-icon-shake {
            0%, 100% { transform: scale(1.2) rotate(5deg); }
            25% { transform: scale(1.2) rotate(-5deg); }
            75% { transform: scale(1.2) rotate(5deg); }
        }

        .chatbox-landing-page .chatbox-feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .chatbox-landing-page .chatbox-feature-text {
            color: #6b7280;
            line-height: 1.7;
            font-size: 1rem;
        }

        /* Typing Indicator Animation */
        .chatbox-landing-page .chatbox-typing-indicator {
            display: inline-flex;
            gap: 0.3rem;
            margin-top: 1rem;
        }

        .chatbox-landing-page .chatbox-typing-dot {
            width: 8px;
            height: 8px;
            background: #2563EB;
            border-radius: 50%;
            animation: chatbox-typing-animation 1.4s infinite;
        }

        .chatbox-landing-page .chatbox-typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chatbox-landing-page .chatbox-typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes chatbox-typing-animation {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.7;
            }
            30% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }

        /* About Section */
        .chatbox-landing-page .chatbox-about-section {
            padding: 6rem 1rem;
            background: linear-gradient(135deg, #FFFFFF 0%, #f8fafc 100%);
            text-align: center;
            position: relative;
        }

        .chatbox-landing-page .chatbox-about-section::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, transparent 70%);
            top: 50px;
            right: 100px;
            border-radius: 50%;
            animation: chatbox-glow-pulse 3s ease-in-out infinite;
        }

        @keyframes chatbox-glow-pulse {
            0%, 100% {
                opacity: 0.5;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        .chatbox-landing-page .chatbox-about-title {
            font-size: 3rem;
            font-weight: 800;
            color: #2563EB;
            margin-bottom: 2rem;
            animation: chatbox-fade-in-up 1s ease-out;
        }

        @keyframes chatbox-fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-landing-page .chatbox-about-text {
            font-size: 1.25rem;
            color: #4b5563;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.9;
            animation: chatbox-fade-in 1.2s ease-out 0.3s backwards;
        }

        /* Message Send Animation */
        .chatbox-message-send-animation {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #2563EB;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
            animation: chatbox-send-pulse 2s ease-in-out infinite;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1040;
        }

        .chatbox-message-send-animation:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.6);
        }

        @keyframes chatbox-send-pulse {
            0%, 100% {
                box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
            }
            50% {
                box-shadow: 0 5px 40px rgba(37, 99, 235, 0.7);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chatbox-landing-page .chatbox-hero-title {
                font-size: 2.5rem;
            }

            .chatbox-landing-page .chatbox-hero-description {
                font-size: 1rem;
            }

            .chatbox-landing-page .chatbox-about-title {
                font-size: 2rem;
            }

            .chatbox-landing-page .chatbox-about-text {
                font-size: 1rem;
            }

            .chatbox-landing-page .chatbox-features-grid .chatbox-feature-card {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }

        /* Scroll Animation */
        .chatbox-landing-page .chatbox-scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .chatbox-landing-page .chatbox-scroll-reveal.chatbox-active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    

@endsection
