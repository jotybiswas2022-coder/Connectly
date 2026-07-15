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
        {{-- Top accent line --}}
        <div class="cl-footer-accent"></div>

        <div class="cl-footer-inner">
            {{-- Column 1: Brand --}}
            <div class="cl-footer-col cl-footer-brand-col">
                <div class="cl-footer-brand">
                    <div class="cl-footer-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <span class="cl-footer-brand-text">Connectly</span>
                </div>
                <p class="cl-footer-desc">
                    A modern social platform for real conversations, meaningful connections, 
                    and seamless communication.
                </p>
                {{-- Social Icons --}}
                <div class="cl-footer-social">
                    <a href="#" class="cl-footer-social-link" aria-label="Twitter">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="cl-footer-social-link" aria-label="GitHub">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="#" class="cl-footer-social-link" aria-label="LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="#" class="cl-footer-social-link" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Column 2: Product --}}
            <div class="cl-footer-col">
                <h4 class="cl-footer-col-title">Product</h4>
                <ul class="cl-footer-col-links">
                    <li><a href="{{ auth()->check() ? route('message', auth()->id()) : '/login' }}">Messages</a></li>
                    <li><a href="/feed">Feed</a></li>
                    <li><a href="{{ auth()->check() ? route('profile.show', auth()->id()) : '/login' }}">Profile</a></li>
                    <li><a href="{{ route('friends') }}">Friends</a></li>
                </ul>
            </div>

            {{-- Column 3: Company --}}
            <div class="cl-footer-col">
                <h4 class="cl-footer-col-title">Company</h4>
                <ul class="cl-footer-col-links">
                    <li><a href="#about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            {{-- Column 4: Legal --}}
            <div class="cl-footer-col">
                <h4 class="cl-footer-col-title">Legal</h4>
                <ul class="cl-footer-col-links">
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Service</a></li>
                    <li><a href="/cookies">Cookie Policy</a></li>
                    <li><a href="/gdpr">GDPR</a></li>
                </ul>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="cl-footer-bottom">
            <div class="cl-footer-bottom-inner">
                <p class="cl-footer-copy">&copy; {{ date('Y') }} Connectly. All rights reserved.</p>
                <p class="cl-footer-made-with">
                    Made with 
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#ef4444" stroke="none"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    by Connectly Team
                </p>
            </div>
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
   F O O T E R  —  Modern Multi-Column Design
   ================================================================ */
.cl-footer {
    background: #0B1120;
    position: relative;
    overflow: hidden;
}

/* Accent gradient line at top */
.cl-footer-accent {
    height: 3px;
    background: linear-gradient(90deg, var(--clr-primary), var(--clr-light), var(--clr-dark), var(--clr-primary));
    background-size: 300% 100%;
    animation: clFooterAccentMove 6s ease-in-out infinite;
}
@keyframes clFooterAccentMove {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Main grid */
.cl-footer-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 56px 24px 40px;
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1fr;
    gap: 36px 28px;
    position: relative;
    z-index: 1;
}

/* Subtle background glow */
.cl-footer::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(37,99,235,0.06), transparent 70%);
    bottom: -300px;
    right: -200px;
    pointer-events: none;
}
.cl-footer::after {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(96,165,250,0.04), transparent 70%);
    top: -150px;
    left: -150px;
    pointer-events: none;
}

/* ===== COLUMNS ===== */
.cl-footer-col {
    min-width: 0;
}

/* Brand Column */
.cl-footer-brand-col {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.cl-footer-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}
.cl-footer-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(37,99,235,0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.cl-footer-brand:hover .cl-footer-icon {
    transform: rotate(-8deg) scale(1.08);
    box-shadow: 0 6px 20px rgba(37,99,235,0.45);
}
.cl-footer-icon svg { width: 20px; height: 20px; }
.cl-footer-brand-text {
    font-size: 1.3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #60A5FA, #2563EB);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.5px;
}
.cl-footer-desc {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.4);
    line-height: 1.7;
    margin: 0;
    max-width: 320px;
}

/* Social Icons */
.cl-footer-social {
    display: flex;
    gap: 10px;
    margin-top: 4px;
}
.cl-footer-social-link {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    transition: all 0.3s cubic-bezier(.16,1,.3,1);
}
.cl-footer-social-link:hover {
    background: rgba(37,99,235,0.15);
    border-color: rgba(37,99,235,0.25);
    color: var(--clr-light);
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 6px 16px rgba(37,99,235,0.15);
}
.cl-footer-social-link svg {
    display: block;
}

/* Column Titles */
.cl-footer-col-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 18px;
    position: relative;
    padding-bottom: 10px;
}
.cl-footer-col-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 24px;
    height: 2px;
    background: linear-gradient(90deg, var(--clr-primary), var(--clr-light));
    border-radius: 2px;
    transition: width 0.3s ease;
}
.cl-footer-col:hover .cl-footer-col-title::after {
    width: 36px;
}

/* Column Link Lists */
.cl-footer-col-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.cl-footer-col-links li {
    line-height: 1;
}
.cl-footer-col-links a {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.cl-footer-col-links a::before {
    content: '›';
    font-size: 1.05rem;
    color: var(--clr-primary);
    opacity: 0;
    transform: translateX(-6px);
    transition: all 0.25s ease;
}
.cl-footer-col-links a:hover {
    color: var(--clr-light);
    transform: translateX(4px);
}
.cl-footer-col-links a:hover::before {
    opacity: 1;
    transform: translateX(0);
}

/* ===== NEWSLETTER ===== */
.cl-footer-newsletter-col {
    grid-column: auto;
}
.cl-footer-newsletter-desc {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.4);
    line-height: 1.6;
    margin: 0 0 14px;
}
.cl-footer-newsletter-form {
    margin: 0;
}
.cl-footer-newsletter-wrap {
    display: flex;
    gap: 6px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    padding: 4px;
    transition: all 0.3s ease;
}
.cl-footer-newsletter-wrap:focus-within {
    border-color: rgba(37,99,235,0.35);
    background: rgba(37,99,235,0.04);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
}
.cl-footer-newsletter-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 10px 14px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.85);
    min-width: 0;
}
.cl-footer-newsletter-input::placeholder {
    color: rgba(255,255,255,0.25);
}
.cl-footer-newsletter-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    border: none;
    border-radius: 9px;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(.16,1,.3,1);
    flex-shrink: 0;
}
.cl-footer-newsletter-btn:hover {
    transform: scale(1.06);
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
}
.cl-footer-newsletter-btn:active {
    transform: scale(0.95);
}
.cl-footer-newsletter-btn svg {
    display: block;
}

/* ===== BOTTOM BAR ===== */
.cl-footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.04);
    padding: 20px 24px;
}
.cl-footer-bottom-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.cl-footer-copy {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.25);
    margin: 0;
}
.cl-footer-made-with {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.25);
    margin: 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.cl-footer-made-with svg {
    display: block;
    animation: clHeartBeat 1.5s ease-in-out infinite;
}
@keyframes clHeartBeat {
    0%, 100% { transform: scale(1); }
    15% { transform: scale(1.25); }
    30% { transform: scale(1); }
    45% { transform: scale(1.15); }
    60% { transform: scale(1); }
}

/* ================================================================
   R E S P O N S I V E
   ================================================================ */

/* --- Larger Tablets (<= 1024px) --- */
@media (max-width: 1024px) {
    .cl-features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .cl-about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .cl-hero-cards { display: none; }
    .cl-hero-title { font-size: 3.2rem; }
}

/* --- Small Tablets / Large Phones (<= 768px) --- */
@media (max-width: 768px) {
    .cl-hero {
        padding: 100px 20px 60px;
        min-height: 90vh;
        min-height: 90dvh;
    }
    .cl-hero-title {
        font-size: 2.6rem;
    }
    .cl-hero-desc {
        font-size: 1rem;
    }
    .cl-hero-stats {
        gap: 12px;
        padding: 16px 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .cl-stat-num { font-size: 1.2rem; }
    .cl-stat-label { font-size: 0.65rem; }
    .cl-section-title {
        font-size: 2rem;
    }
    .cl-section-desc {
        font-size: 0.95rem;
    }
    .cl-features-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }
    .cl-feature-card {
        padding: 28px 22px;
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
    
    /* Footer responsive */
    .cl-footer-inner {
        grid-template-columns: 1fr 1fr;
        gap: 32px 24px;
        padding: 40px 24px 32px;
    }
    .cl-footer-newsletter-col {
        grid-column: 1 / -1;
    }
    .cl-footer-newsletter-wrap {
        max-width: 380px;
    }
    .cl-footer-brand-col {
        grid-column: 1 / -1;
    }
    .cl-footer-desc {
        max-width: 100%;
    }
    .cl-footer-bottom-inner {
        flex-direction: column;
        text-align: center;
    }

    .cl-about {
        padding: 80px 20px;
    }
    .cl-cta {
        padding: 60px 20px;
    }
    .cl-section-header {
        margin-bottom: 40px;
    }
}

/* --- Small Phones (<= 480px) --- */
@media (max-width: 480px) {
    .cl-hero {
        padding: 90px 16px 50px;
        min-height: 85vh;
        min-height: 85dvh;
    }
    .cl-hero-title {
        font-size: 2rem;
    }
    .cl-hero-badge {
        font-size: 0.75rem;
        padding: 6px 14px;
    }
    .cl-hero-desc {
        font-size: 0.92rem;
        margin-bottom: 28px;
    }
    .cl-hero-actions {
        flex-direction: column;
        width: 100%;
        gap: 12px;
        margin-bottom: 36px;
    }
    .cl-hero-actions .cl-btn {
        width: 100%;
        justify-content: center;
        padding: 14px 24px;
        font-size: 0.9rem;
    }
    .cl-hero-stats {
        width: 100%;
        padding: 14px 16px;
        border-radius: 16px;
        gap: 8px;
    }
    .cl-stat-item { gap: 0; }
    .cl-stat-num { font-size: 1.1rem; }
    .cl-stat-label { font-size: 0.6rem; }
    .cl-stat-divider { height: 28px; }
    
    .cl-features {
        padding: 50px 16px;
    }
    .cl-section-title {
        font-size: 1.6rem;
    }
    .cl-section-desc {
        font-size: 0.88rem;
    }
    .cl-features-grid {
        gap: 14px;
    }
    .cl-feature-card {
        padding: 24px 18px;
        border-radius: 16px;
    }
    .cl-feature-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        margin-bottom: 16px;
    }
    .cl-feature-icon-wrap svg {
        width: 22px;
        height: 22px;
    }
    .cl-feature-title {
        font-size: 1.05rem;
    }
    .cl-feature-desc {
        font-size: 0.82rem;
    }

    .cl-about {
        padding: 50px 16px;
    }
    .cl-about-content {
        gap: 28px;
    }
    .cl-about-desc {
        font-size: 0.9rem;
    }
    .cl-about-features-list {
        gap: 8px;
    }
    .cl-about-feature-item {
        font-size: 0.82rem;
        padding: 8px 14px;
    }
    .cl-about-stats {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .cl-about-stat-card {
        padding: 20px 14px;
    }
    .cl-as-number { font-size: 1.8rem; }
    .cl-as-label { font-size: 0.7rem; }

    .cl-cta { padding: 40px 16px; }
    .cl-cta-card {
        padding: 32px 20px;
        border-radius: 20px;
    }
    .cl-cta-title {
        font-size: 1.5rem;
    }
    .cl-cta-desc {
        font-size: 0.9rem;
        margin-bottom: 24px;
    }
    .cl-btn-lg {
        padding: 16px 28px;
        font-size: 0.95rem;
    }

    .cl-footer-inner {
        grid-template-columns: 1fr;
        gap: 28px;
        padding: 32px 18px 24px;
    }
    .cl-footer-brand-col {
        text-align: center;
        gap: 14px;
    }
    .cl-footer-brand {
        justify-content: center;
    }
    .cl-footer-desc {
        max-width: 100%;
        margin: 0 auto;
        font-size: 0.82rem;
    }
    .cl-footer-social {
        justify-content: center;
    }
    .cl-footer-social-link {
        width: 40px;
        height: 40px;
    }
    .cl-footer-col-title {
        text-align: center;
    }
    .cl-footer-col-links {
        align-items: center;
    }
    .cl-footer-col-links a::before {
        display: none;
    }
    .cl-footer-newsletter-wrap {
        max-width: 100%;
    }
    .cl-footer-newsletter-btn {
        width: 44px;
        height: 44px;
    }
    .cl-footer-bottom {
        padding: 16px 18px;
    }
    .cl-footer-bottom-inner {
        flex-direction: column;
        text-align: center;
        gap: 6px;
    }
    .cl-footer-copy {
        font-size: 0.72rem;
    }
    .cl-footer-made-with {
        font-size: 0.72rem;
    }
}

/* --- Very Small Phones (<= 375px) --- */
@media (max-width: 375px) {
    .cl-hero {
        padding: 80px 12px 40px;
    }
    .cl-hero-title {
        font-size: 1.7rem;
    }
    .cl-hero-desc {
        font-size: 0.85rem;
    }
    .cl-hero-stats {
        padding: 12px;
        gap: 6px;
    }
    .cl-stat-num { font-size: 1rem; }
    .cl-section-title {
        font-size: 1.35rem;
    }
    .cl-section-tag {
        font-size: 0.72rem;
        padding: 4px 12px;
    }
    .cl-feature-card {
        padding: 20px 16px;
    }
    .cl-feature-icon-wrap {
        width: 42px;
        height: 42px;
        margin-bottom: 12px;
    }
    .cl-feature-title {
        font-size: 0.95rem;
    }
    .cl-about-stat-card {
        padding: 16px 10px;
    }
    .cl-as-number { font-size: 1.5rem; }
    .cl-cta-card {
        padding: 28px 16px;
    }
    .cl-cta-title {
        font-size: 1.3rem;
    }

    /* Footer responsive */
    .cl-footer-inner {
        grid-template-columns: 1fr;
        gap: 22px;
        padding: 24px 14px 20px;
    }
    .cl-footer-brand-text {
        font-size: 1.1rem;
    }
    .cl-footer-icon {
        width: 34px;
        height: 34px;
    }
    .cl-footer-icon svg {
        width: 17px;
        height: 17px;
    }
    .cl-footer-desc {
        font-size: 0.78rem;
    }
    .cl-footer-social-link {
        width: 36px;
        height: 36px;
    }
    .cl-footer-col {
        text-align: center;
    }
    .cl-footer-col-title {
        font-size: 0.75rem;
        margin-bottom: 14px;
    }
    .cl-footer-col-title::after {
        left: 50% !important;
        transform: translateX(-50%);
    }
    .cl-footer-col-links {
        align-items: center;
        gap: 8px;
    }
    .cl-footer-col-links a {
        font-size: 0.78rem;
    }
    .cl-footer-col-links a::before {
        display: none;
    }
    .cl-footer-newsletter-input {
        font-size: 0.8rem;
        padding: 8px 12px;
    }
    .cl-footer-newsletter-btn {
        width: 38px;
        height: 38px;
    }
    .cl-footer-bottom {
        padding: 12px 14px;
    }
    .cl-footer-copy {
        font-size: 0.68rem;
    }
    .cl-footer-made-with {
        font-size: 0.68rem;
    }
        height: 36px;
    }
    .cl-footer-bottom {
        padding: 14px 12px;
    }
}

/* --- Landscape Mode on Small Devices --- */
@media (max-height: 500px) and (orientation: landscape) {
    .cl-hero {
        min-height: 110vh;
        min-height: 110dvh;
        padding: 80px 20px 40px;
    }
    .cl-hero-title {
        font-size: 1.8rem;
    }
    .cl-hero-desc {
        font-size: 0.85rem;
        margin-bottom: 20px;
    }
    .cl-hero-actions {
        margin-bottom: 24px;
    }
    .cl-hero-stats {
        padding: 10px 16px;
    }
    .cl-scroll-indicator { display: none; }
    .cl-mesh-orb-1 { width: 300px; height: 300px; }
    .cl-mesh-orb-2 { width: 250px; height: 250px; }
    .cl-mesh-orb-3 { display: none; }
    .cl-mesh-orb-4 { display: none; }
}

/* --- Prefers Reduced Motion --- */
@media (prefers-reduced-motion: reduce) {
    .connectly-home *,
    .connectly-home *::before,
    .connectly-home *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    .cl-hero-card,
    .cl-scroll-indicator,
    .cl-feature-card {
        animation: none !important;
        transform: none !important;
    }
    .cl-particles { display: none; }
    .reveal {
        opacity: 1;
        transform: none;
    }
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
