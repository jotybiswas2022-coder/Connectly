@extends('frontend.app')

@section('content')

<div class="connectly-home" id="connectlyHome">

    {{-- ========== HERO SECTION ========== --}}
    <section class="cl-hero">
        {{-- Mesh Gradient Background --}}
        <div class="cl-hero-mesh">
            <div class="cl-mesh-orb cl-mesh-orb-1"></div>
            <div class="cl-mesh-orb cl-mesh-orb-2"></div>
            <div class="cl-mesh-orb cl-mesh-orb-3"></div>
            <div class="cl-mesh-orb cl-mesh-orb-4"></div>
        </div>

        {{-- Floating Particles --}}
        <div class="cl-particles" id="clParticles"></div>

        {{-- Hero Content --}}
        <div class="cl-hero-content">
            <div class="cl-hero-badge animate-in-top">
                <span class="cl-badge-dot"></span>
                Connect with the world
            </div>

            <h1 class="cl-hero-title animate-in-top">
                Where
                <span class="cl-gradient-text">Connections</span>
                Come to Life
            </h1>

            <p class="cl-hero-desc animate-in-top">
                Connectly is a modern social platform built for real conversations, 
                meaningful connections, and seamless communication — all in one place.
            </p>

            <div class="cl-hero-actions animate-in-top">
                <a href="{{ auth()->check() ? route('message', auth()->id()) : '/login' }}" class="cl-btn cl-btn-primary">
                    <span>Get Started Free</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ auth()->check() ? '/feed' : '/register' }}" class="cl-btn cl-btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                    <span>Explore Feed</span>
                </a>
            </div>

            {{-- Hero Stats --}}
            <div class="cl-hero-stats animate-in-top">
                <div class="cl-stat-item">
                    <span class="cl-stat-num" data-count="10" data-suffix="K+">0</span>
                    <span class="cl-stat-label">Users</span>
                </div>
                <div class="cl-stat-divider"></div>
                <div class="cl-stat-item">
                    <span class="cl-stat-num" data-count="50" data-suffix="K+">0</span>
                    <span class="cl-stat-label">Messages</span>
                </div>
                <div class="cl-stat-divider"></div>
                <div class="cl-stat-item">
                    <span class="cl-stat-num" data-count="99" data-suffix="%">0</span>
                    <span class="cl-stat-label">Uptime</span>
                </div>
            </div>
        </div>

        {{-- Hero Decorative Cards --}}
        <div class="cl-hero-cards">
            <div class="cl-hero-card cl-hero-card-1">
                <div class="cl-hc-avatar">
                    <img src="https://i.pravatar.cc/40?img=1" alt="User">
                </div>
                <div class="cl-hc-content">
                    <div class="cl-hc-name">Alex Rivera</div>
                    <div class="cl-hc-msg">Hey! Great to connect with you 🎉</div>
                </div>
                <div class="cl-hc-time">now</div>
            </div>
            <div class="cl-hero-card cl-hero-card-2">
                <div class="cl-hc-avatar">
                    <img src="https://i.pravatar.cc/40?img=5" alt="User">
                </div>
                <div class="cl-hc-content">
                    <div class="cl-hc-name">Sarah Kim</div>
                    <div class="cl-hc-msg">Love the new design! 🔥</div>
                </div>
                <div class="cl-hc-time">2m</div>
            </div>
            <div class="cl-hero-card cl-hero-card-3">
                <div class="cl-hc-avatar">
                    <img src="https://i.pravatar.cc/40?img=8" alt="User">
                </div>
                <div class="cl-hc-content">
                    <div class="cl-hc-name">Jordan Lee</div>
                    <div class="cl-hc-msg">This platform is amazing!</div>
                </div>
                <div class="cl-hc-time">5m</div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="cl-scroll-indicator">
            <span>Scroll to explore</span>
            <div class="cl-scroll-mouse">
                <div class="cl-scroll-wheel"></div>
            </div>
        </div>
    </section>

    {{-- ========== FEATURES SECTION ========== --}}
    <section class="cl-features" id="features">
        <div class="cl-section-header reveal">
            <span class="cl-section-tag">Features</span>
            <h2 class="cl-section-title">Everything You Need to <span class="cl-gradient-text">Stay Connected</span></h2>
            <p class="cl-section-desc">Powerful tools designed to make communication effortless, secure, and enjoyable.</p>
        </div>

        <div class="cl-features-grid">
            <div class="cl-feature-card reveal" style="transition-delay:0.1s">
                <div class="cl-feature-icon-wrap" style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(96,165,250,0.1))">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3 class="cl-feature-title">Real-Time Chat</h3>
                <p class="cl-feature-desc">Send messages instantly with real-time delivery. Chat with friends and see when they're typing.</p>
                <div class="cl-feature-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>

            <div class="cl-feature-card reveal" style="transition-delay:0.2s">
                <div class="cl-feature-icon-wrap" style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(96,165,250,0.1))">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="cl-feature-title">Secure & Private</h3>
                <p class="cl-feature-desc">Your conversations are protected with enterprise-grade encryption and security.</p>
                <div class="cl-feature-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>

            <div class="cl-feature-card reveal" style="transition-delay:0.3s">
                <div class="cl-feature-icon-wrap" style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(96,165,250,0.1))">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="cl-feature-title">Friend System</h3>
                <p class="cl-feature-desc">Build your network with friend requests, notifications, and an active community.</p>
                <div class="cl-feature-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>

            <div class="cl-feature-card reveal" style="transition-delay:0.4s">
                <div class="cl-feature-icon-wrap" style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(96,165,250,0.1))">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                </div>
                <h3 class="cl-feature-title">Social Feed</h3>
                <p class="cl-feature-desc">Share your thoughts, photos, and updates with your friends on your personal feed.</p>
                <div class="cl-feature-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>

            <div class="cl-feature-card reveal" style="transition-delay:0.5s">
                <div class="cl-feature-icon-wrap" style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(96,165,250,0.1))">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="cl-feature-title">Real-Time Updates</h3>
                <p class="cl-feature-desc">Get instant notifications for messages, friend requests, and social activity.</p>
                <div class="cl-feature-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>

            <div class="cl-feature-card reveal" style="transition-delay:0.6s">
                <div class="cl-feature-icon-wrap" style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(96,165,250,0.1))">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <h3 class="cl-feature-title">Modern Design</h3>
                <p class="cl-feature-desc">Clean, intuitive interface that makes navigation a breeze across all devices.</p>
                <div class="cl-feature-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== STATS / ABOUT SECTION ========== --}}
    <section class="cl-about" id="about">
        <div class="cl-about-bg">
            <div class="cl-about-orb"></div>
            <div class="cl-about-orb cl-about-orb-2"></div>
        </div>

        <div class="cl-about-content">
            <div class="cl-about-text reveal">
                <span class="cl-section-tag">About Connectly</span>
                <h2 class="cl-section-title" style="text-align:left">Built for <span class="cl-gradient-text">Meaningful</span> Connections</h2>
                <p class="cl-about-desc">
                    Connectly was created with a simple vision — to make online communication 
                    feel as natural and genuine as real-life conversations. We combine cutting-edge 
                    technology with thoughtful design to create a platform where everyone feels welcome.
                </p>
                <div class="cl-about-features-list">
                    <div class="cl-about-feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Lightning fast performance</span>
                    </div>
                    <div class="cl-about-feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>End-to-end encrypted messaging</span>
                    </div>
                    <div class="cl-about-feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>100% free & open community</span>
                    </div>
                </div>
            </div>

            <div class="cl-about-stats reveal">
                <div class="cl-about-stat-card">
                    <span class="cl-as-number" data-count="15" data-suffix="+">0</span>
                    <span class="cl-as-label">Active Users</span>
                </div>
                <div class="cl-about-stat-card">
                    <span class="cl-as-number" data-count="5" data-suffix="+">0</span>
                    <span class="cl-as-label">Countries</span>
                </div>
                <div class="cl-about-stat-card">
                    <span class="cl-as-number" data-count="99" data-suffix="%">0</span>
                    <span class="cl-as-label">Satisfaction</span>
                </div>
                <div class="cl-about-stat-card">
                    <span class="cl-as-number" data-count="24" data-suffix="/7">0</span>
                    <span class="cl-as-label">Support</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== CTA SECTION ========== --}}
    <section class="cl-cta reveal">
        <div class="cl-cta-card">
            <div class="cl-cta-glow"></div>
            <h2 class="cl-cta-title">Ready to <span class="cl-gradient-text">Connect</span>?</h2>
            <p class="cl-cta-desc">Join thousands of users already connecting on Connectly. Start your journey today.</p>
            <div class="cl-cta-actions">
                <a href="{{ auth()->check() ? route('message', auth()->id()) : '/register' }}" class="cl-btn cl-btn-primary cl-btn-lg">
                    <span>Join Now — It's Free</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ========== FOOTER ========== --}}
    <footer class="cl-footer">
        <div class="cl-footer-inner">
            <div class="cl-footer-brand">
                <div class="cl-footer-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span>Connectly</span>
            </div>
            <div class="cl-footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="/contact">Contact</a>
            </div>
            <p class="cl-footer-copy">&copy; {{ date('Y') }} Connectly. All rights reserved.</p>
        </div>
    </footer>
</div>

<style>
/* ============================================================
   CONNECTLY HOME PAGE — MODERN DESIGN SYSTEM
   Color Palette: Primary #2563EB, Light #60A5FA, Dark #1E40AF
   ============================================================ */

.connectly-home {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #F0F5FF;
    --clr-surface: #FFFFFF;
    --clr-text: #0F172A;
    --clr-muted: #64748B;
    --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;

    font-family: var(--font);
    color: var(--clr-text);
    background: var(--clr-bg);
    overflow-x: hidden;
}

/* ===== UTILITY ===== */
.cl-gradient-text {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ===== SCROLL REVEAL ===== */
.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s cubic-bezier(.16,1,.3,1), transform 0.8s cubic-bezier(.16,1,.3,1);
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

.animate-in-top {
    opacity: 0;
    transform: translateY(30px);
    animation: clFadeUp 0.8s cubic-bezier(.16,1,.3,1) forwards;
}
.animate-in-top:nth-child(1) { animation-delay: 0.1s; }
.animate-in-top:nth-child(2) { animation-delay: 0.3s; }
.animate-in-top:nth-child(3) { animation-delay: 0.5s; }
.animate-in-top:nth-child(4) { animation-delay: 0.7s; }
.animate-in-top:nth-child(5) { animation-delay: 0.9s; }

@keyframes clFadeUp {
    to { opacity: 1; transform: translateY(0); }
}

/* ===== SECTION HEADER ===== */
.cl-section-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(37,99,235,0.08);
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--clr-primary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 16px;
}

.cl-section-title {
    font-size: 2.8rem;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.03em;
    margin-bottom: 16px;
    text-align: center;
}

.cl-section-desc {
    font-size: 1.1rem;
    color: var(--clr-muted);
    max-width: 580px;
    margin: 0 auto;
    line-height: 1.7;
    text-align: center;
}

/* ================================================================
   H E R O
   ================================================================ */
.cl-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 120px 24px 80px;
    overflow: hidden;
    background: #0B1120;
}

/* --- Mesh Gradient Orbs --- */
.cl-hero-mesh {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}
.cl-mesh-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.5;
}
.cl-mesh-orb-1 {
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(37,99,235,0.3), transparent 70%);
    top: -200px; right: -100px;
    animation: clOrbFloat1 12s ease-in-out infinite;
}
.cl-mesh-orb-2 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(96,165,250,0.2), transparent 70%);
    bottom: -150px; left: -150px;
    animation: clOrbFloat2 14s ease-in-out infinite reverse;
}
.cl-mesh-orb-3 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(30,64,175,0.25), transparent 70%);
    top: 20%; left: 10%;
    animation: clOrbFloat3 16s ease-in-out infinite 2s;
}
.cl-mesh-orb-4 {
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(37,99,235,0.15), transparent 70%);
    bottom: 20%; right: 15%;
    animation: clOrbFloat1 10s ease-in-out infinite 4s;
}

@keyframes clOrbFloat1 {
    0%,100%{ transform: translate(0,0) scale(1); }
    33%{ transform: translate(40px,-40px) scale(1.1); }
    66%{ transform: translate(-30px,20px) scale(0.95); }
}
@keyframes clOrbFloat2 {
    0%,100%{ transform: translate(0,0) scale(1); }
    33%{ transform: translate(-40px,30px) scale(1.08); }
    66%{ transform: translate(30px,-30px) scale(0.92); }
}
@keyframes clOrbFloat3 {
    0%,100%{ transform: translate(0,0) scale(1); }
    50%{ transform: translate(30px,30px) scale(1.12); }
}

/* --- Particles --- */
.cl-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 1;
}
.cl-particle {
    position: absolute;
    width: 3px;
    height: 3px;
    background: rgba(96,165,250,0.5);
    border-radius: 50%;
    animation: clParticleFloat linear infinite;
}
@keyframes clParticleFloat {
    0% { transform: translateY(100vh) scale(0); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-10vh) scale(1); opacity: 0; }
}

/* --- Hero Content --- */
.cl-hero-content {
    position: relative;
    z-index: 3;
    max-width: 800px;
    text-align: center;
}

.cl-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
    color: rgba(255,255,255,0.8);
    margin-bottom: 28px;
}
.cl-badge-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22c55e;
    animation: clBadgePulse 2s ease-in-out infinite;
}
@keyframes clBadgePulse {
    0%,100%{ box-shadow: 0 0 0 0 rgba(34,197,94,0.5); }
    50%{ box-shadow: 0 0 0 8px rgba(34,197,94,0); }
}

.cl-hero-title {
    font-size: 4.2rem;
    font-weight: 900;
    line-height: 1.1;
    color: #FFFFFF;
    letter-spacing: -0.03em;
    margin-bottom: 20px;
}

.cl-hero-desc {
    font-size: 1.2rem;
    color: rgba(255,255,255,0.65);
    max-width: 600px;
    margin: 0 auto 36px;
    line-height: 1.7;
}

/* --- Hero Actions --- */
.cl-hero-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 48px;
}

.cl-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 32px;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.35s cubic-bezier(.16,1,.3,1);
    cursor: pointer;
    border: none;
    font-family: var(--font);
    white-space: nowrap;
}
.cl-btn-primary {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff;
    box-shadow: 0 6px 24px rgba(37,99,235,0.35);
    position: relative;
    overflow: hidden;
}
.cl-btn-primary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--clr-dark), #1E3A8A);
    opacity: 0;
    transition: opacity 0.35s ease;
    border-radius: inherit;
}
.cl-btn-primary span, .cl-btn-primary svg {
    position: relative;
    z-index: 1;
}
.cl-btn-primary:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 10px 36px rgba(37,99,235,0.5);
}
.cl-btn-primary:hover::before {
    opacity: 1;
}
.cl-btn-primary:active {
    transform: translateY(-1px) scale(1.01);
}

.cl-btn-outline {
    background: rgba(255,255,255,0.06);
    border: 1.5px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.85);
}
.cl-btn-outline:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.3);
    color: #fff;
    transform: translateY(-2px);
}

.cl-btn-lg {
    padding: 18px 40px;
    font-size: 1.05rem;
}

/* --- Hero Stats --- */
.cl-hero-stats {
    display: inline-flex;
    align-items: center;
    gap: 28px;
    padding: 20px 36px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 20px;
    backdrop-filter: blur(12px);
}
.cl-stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}
.cl-stat-num {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
}
.cl-stat-label {
    font-size: 0.72rem;
    font-weight: 500;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.cl-stat-divider {
    width: 1px;
    height: 36px;
    background: rgba(255,255,255,0.08);
}

/* --- Hero Decorative Cards --- */
.cl-hero-cards {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 2;
}
.cl-hero-card {
    position: absolute;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    animation: clCardFloat 6s ease-in-out infinite;
}
.cl-hero-card-1 {
    top: 20%; left: 5%;
    animation-delay: 0s;
}
.cl-hero-card-2 {
    top: 45%; right: 5%;
    animation-delay: 2s;
}
.cl-hero-card-3 {
    bottom: 25%; left: 8%;
    animation-delay: 4s;
}
@keyframes clCardFloat {
    0%,100%{ transform: translateY(0); }
    50%{ transform: translateY(-12px); }
}

.cl-hc-avatar img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.2);
}
.cl-hc-content {
    flex: 1;
    min-width: 0;
}
.cl-hc-name {
    font-size: 0.72rem;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
}
.cl-hc-msg {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.5);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 120px;
}
.cl-hc-time {
    font-size: 0.6rem;
    color: rgba(255,255,255,0.35);
    flex-shrink: 0;
}

/* --- Scroll Indicator --- */
.cl-scroll-indicator {
    position: absolute;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    z-index: 3;
    opacity: 0.5;
    animation: clScrollBounce 2s ease-in-out infinite;
}
.cl-scroll-indicator span {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.cl-scroll-mouse {
    width: 22px;
    height: 34px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    display: flex;
    justify-content: center;
    padding-top: 6px;
}
.cl-scroll-wheel {
    width: 3px;
    height: 8px;
    background: rgba(255,255,255,0.5);
    border-radius: 3px;
    animation: clWheelScroll 1.5s ease-in-out infinite;
}
@keyframes clWheelScroll {
    0%{ transform: translateY(0); opacity: 1; }
    100%{ transform: translateY(10px); opacity: 0; }
}
@keyframes clScrollBounce {
    0%,100%{ transform: translateX(-50%) translateY(0); }
    50%{ transform: translateX(-50%) translateY(-6px); }
}

/* ================================================================
   F E A T U R E S
   ================================================================ */
.cl-features {
    padding: 100px 24px;
    background: var(--clr-bg);
    position: relative;
}

.cl-section-header {
    text-align: center;
    margin-bottom: 60px;
}

.cl-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    max-width: 1100px;
    margin: 0 auto;
}

.cl-feature-card {
    background: var(--clr-surface);
    border: 1px solid rgba(37,99,235,0.06);
    border-radius: 20px;
    padding: 36px 28px;
    transition: all 0.4s cubic-bezier(.16,1,.3,1);
    position: relative;
    overflow: hidden;
}
.cl-feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--clr-primary), var(--clr-light));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.5s cubic-bezier(.16,1,.3,1);
}
.cl-feature-card:hover::before {
    transform: scaleX(1);
}
.cl-feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(37,99,235,0.1);
    border-color: rgba(37,99,235,0.12);
}

.cl-feature-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    transition: transform 0.4s ease;
}
.cl-feature-card:hover .cl-feature-icon-wrap {
    transform: scale(1.1) rotate(-6deg);
}

.cl-feature-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--clr-text);
    margin-bottom: 10px;
    letter-spacing: -0.02em;
}
.cl-feature-desc {
    font-size: 0.9rem;
    color: var(--clr-muted);
    line-height: 1.6;
}
.cl-feature-dots {
    display: flex;
    gap: 5px;
    margin-top: 18px;
}
.cl-feature-dots span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--clr-light);
    opacity: 0.2;
    animation: clDotPulse 1.5s ease-in-out infinite;
}
.cl-feature-dots span:nth-child(2) { animation-delay: 0.3s; }
.cl-feature-dots span:nth-child(3) { animation-delay: 0.6s; }
@keyframes clDotPulse {
    0%,100%{ opacity: 0.2; }
    50%{ opacity: 0.6; }
}

/* ================================================================
   A B O U T
   ================================================================ */
.cl-about {
    padding: 100px 24px;
    background: #0B1120;
    position: relative;
    overflow: hidden;
}
.cl-about-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
}
.cl-about-orb {
    position: absolute;
    width: 450px;
    height: 450px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(37,99,235,0.12), transparent 70%);
    top: -150px;
    right: -100px;
    filter: blur(80px);
    animation: clOrbFloat1 12s ease-in-out infinite;
}
.cl-about-orb-2 {
    width: 350px;
    height: 350px;
    bottom: -100px;
    left: -100px;
    top: auto;
    right: auto;
    background: radial-gradient(circle, rgba(96,165,250,0.1), transparent 70%);
    animation: clOrbFloat2 14s ease-in-out infinite reverse;
}

.cl-about-content {
    position: relative;
    z-index: 1;
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.cl-about-text .cl-section-title {
    margin-bottom: 20px;
}
.cl-about-desc {
    font-size: 1rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.8;
    margin-bottom: 28px;
}

.cl-about-features-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.cl-about-feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.75);
    padding: 10px 16px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px;
    transition: all 0.3s ease;
}
.cl-about-feature-item:hover {
    background: rgba(255,255,255,0.07);
    transform: translateX(6px);
}

.cl-about-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.cl-about-stat-card {
    padding: 28px 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 16px;
    text-align: center;
    transition: all 0.3s ease;
}
.cl-about-stat-card:hover {
    background: rgba(255,255,255,0.06);
    border-color: rgba(37,99,235,0.2);
    transform: translateY(-4px);
}
.cl-as-number {
    display: block;
    font-size: 2.4rem;
    font-weight: 900;
    background: linear-gradient(135deg, var(--clr-light), var(--clr-primary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 4px;
    letter-spacing: -0.03em;
}
.cl-as-label {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 500;
}

/* ================================================================
   C T A
   ================================================================ */
.cl-cta {
    padding: 80px 24px;
    background: var(--clr-bg);
}
.cl-cta-card {
    max-width: 640px;
    margin: 0 auto;
    padding: 56px 40px;
    background: var(--clr-surface);
    border: 1px solid rgba(37,99,235,0.08);
    border-radius: 28px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(37,99,235,0.06);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.cl-cta-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 30px 80px rgba(37,99,235,0.1);
}
.cl-cta-glow {
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(37,99,235,0.06), transparent 70%);
    top: -100px;
    right: -100px;
    pointer-events: none;
}
.cl-cta-title {
    font-size: 2.4rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    margin-bottom: 14px;
    color: var(--clr-text);
}
.cl-cta-desc {
    font-size: 1rem;
    color: var(--clr-muted);
    line-height: 1.7;
    max-width: 460px;
    margin: 0 auto 32px;
}
.cl-cta-actions {
    display: flex;
    justify-content: center;
}

/* ================================================================
   F O O T E R
   ================================================================ */
.cl-footer {
    padding: 32px 24px;
    background: #0B1120;
    border-top: 1px solid rgba(255,255,255,0.04);
}
.cl-footer-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}
.cl-footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
}
.cl-footer-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.cl-footer-icon svg { width: 18px; height: 18px; }
.cl-footer-links {
    display: flex;
    gap: 24px;
}
.cl-footer-links a {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    transition: color 0.25s;
}
.cl-footer-links a:hover {
    color: var(--clr-light);
}
.cl-footer-copy {
    width: 100%;
    text-align: center;
    font-size: 0.78rem;
    color: rgba(255,255,255,0.25);
    margin: 0;
}

/* ================================================================
   R E S P O N S I V E
   ================================================================ */
@media (max-width: 1024px) {
    .cl-features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .cl-about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .cl-hero-cards { display: none; }
}

@media (max-width: 768px) {
    .cl-hero-title {
        font-size: 2.6rem;
    }
    .cl-hero-desc {
        font-size: 1rem;
    }
    .cl-hero-stats {
        gap: 16px;
        padding: 16px 24px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .cl-stat-num { font-size: 1.2rem; }
    .cl-section-title {
        font-size: 2rem;
    }
    .cl-features-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }
    .cl-about-stats {
        grid-template-columns: 1fr 1fr;
    }
    .cl-cta-card {
        padding: 36px 24px;
    }
    .cl-cta-title {
        font-size: 1.8rem;
    }
    .cl-scroll-indicator { display: none; }
    .cl-footer-inner {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .cl-hero {
        padding: 100px 16px 60px;
    }
    .cl-hero-title {
        font-size: 2rem;
    }
    .cl-hero-actions {
        flex-direction: column;
        width: 100%;
    }
    .cl-hero-actions .cl-btn {
        width: 100%;
        justify-content: center;
    }
    .cl-features {
        padding: 60px 16px;
    }
    .cl-about {
        padding: 60px 16px;
    }
    .cl-about-stats {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .cl-as-number { font-size: 1.8rem; }
    .cl-cta { padding: 40px 16px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== PARTICLES =====
    const particleContainer = document.getElementById('clParticles');
    if (particleContainer) {
        for (let i = 0; i < 40; i++) {
            const p = document.createElement('div');
            p.className = 'cl-particle';
            const size = Math.random() * 3 + 1;
            const x = Math.random() * 100;
            const duration = Math.random() * 15 + 10;
            const delay = Math.random() * 10;
            const opacity = Math.random() * 0.4 + 0.1;
            p.style.cssText = 'left:'+x+'%;width:'+size+'px;height:'+size+'px;animation-duration:'+duration+'s;animation-delay:'+delay+'s;opacity:'+opacity;
            particleContainer.appendChild(p);
        }
    }

    // ===== SCROLL REVEAL =====
    const revealEls = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });
    revealEls.forEach(el => revealObserver.observe(el));

    // ===== COUNTER ANIMATION =====
    const counterEls = document.querySelectorAll('.cl-stat-num, .cl-as-number');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-count'));
                animateCounter(el, target);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    function animateCounter(el, target) {
        const suffix = el.getAttribute('data-suffix') || (el.classList.contains('cl-as-number') ? '%' : '+');
        let current = 0;
        const increment = Math.max(1, Math.floor(target / 40));
        const duration = 1500;
        const stepTime = Math.floor(duration / (target / increment));
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = current + suffix;
        }, stepTime);
    }

    counterEls.forEach(el => counterObserver.observe(el));
});
</script>

@endsection
