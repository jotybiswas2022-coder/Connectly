@extends('frontend.app')

@section('title', 'GDPR Compliance — Connectly')

@section('content')
<div class="cl-legal-page">

    {{-- Background Effects --}}
    <div class="cl-legal-bg">
        <div class="cl-legal-bg-orb cl-legal-bg-orb-1"></div>
        <div class="cl-legal-bg-orb cl-legal-bg-orb-2"></div>
        <div class="cl-legal-bg-orb cl-legal-bg-orb-3"></div>
    </div>
    <div class="cl-legal-grid"></div>

    {{-- Scroll Progress Bar --}}
    <div class="cl-legal-progress" id="clLegalProgress"></div>

    <div class="cl-legal-wrapper">
        {{-- Main Content --}}
        <div class="cl-legal-card">
            <div class="cl-legal-header">
                <div class="cl-legal-header-top">
                    <a href="/" class="cl-legal-back">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Back to Home
                    </a>
                    <div class="cl-legal-badge">GDPR</div>
                </div>
                <h1 class="cl-legal-title"><span class="cl-legal-title-accent">GDPR</span> Compliance</h1>
                <p class="cl-legal-date">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="cl-legal-body">
                <section id="section-1">
                    <h2><span class="cl-legal-section-num">1</span> Overview</h2>
                    <p>The General Data Protection Regulation (GDPR) is a European Union regulation that governs the processing of personal data of individuals within the EU. Connectly is committed to full compliance with the GDPR requirements.</p>
                    <p>This page explains your rights under the GDPR and how we ensure your data is protected.</p>
                </section>

                <section id="section-2">
                    <h2><span class="cl-legal-section-num">2</span> Data Controller</h2>
                    <p>Connectly acts as the data controller for the personal information collected through our Platform. As the data controller, we determine the purposes and means of processing your personal data.</p>
                    <p>If you have any questions about our data protection practices, please contact our Data Protection Officer at <a href="mailto:dpo@connectly.com">dpo@connectly.com</a>.</p>
                </section>

                <section id="section-3">
                    <h2><span class="cl-legal-section-num">3</span> Legal Basis for Processing</h2>
                    <p>Under the GDPR, we process your personal data based on the following legal grounds:</p>
                    <ul class="cl-legal-list">
                        <li><strong>Consent:</strong> You have given explicit consent for specific processing purposes.</li>
                        <li><strong>Contract:</strong> Processing is necessary for the performance of a contract with you.</li>
                        <li><strong>Legal obligation:</strong> Processing is required to comply with legal obligations.</li>
                        <li><strong>Legitimate interests:</strong> Processing is necessary for our legitimate interests, provided these do not override your rights.</li>
                    </ul>
                </section>

                <section id="section-4">
                    <h2><span class="cl-legal-section-num">4</span> Your GDPR Rights</h2>
                    <p>As an individual within the EU, you have the following rights under the GDPR:</p>

                    <h3>Right to Access</h3>
                    <p>You have the right to request a copy of the personal data we hold about you.</p>

                    <h3>Right to Rectification</h3>
                    <p>You have the right to request correction of inaccurate or incomplete data.</p>

                    <h3>Right to Erasure ("Right to be Forgotten")</h3>
                    <p>You have the right to request deletion of your personal data when it is no longer necessary for the purposes for which it was collected.</p>

                    <h3>Right to Restrict Processing</h3>
                    <p>You have the right to request restriction of processing under certain circumstances.</p>

                    <h3>Right to Data Portability</h3>
                    <p>You have the right to receive your personal data in a structured, commonly used, and machine-readable format and to transmit it to another controller.</p>

                    <h3>Right to Object</h3>
                    <p>You have the right to object to processing of your personal data for direct marketing purposes or based on our legitimate interests.</p>

                    <h3>Rights Related to Automated Decision Making</h3>
                    <p>You have the right not to be subject to a decision based solely on automated processing that produces legal effects concerning you.</p>
                </section>

                <section id="section-5">
                    <h2><span class="cl-legal-section-num">5</span> Exercising Your Rights</h2>
                    <p>To exercise any of your GDPR rights, please contact us:</p>
                    <ul class="cl-legal-list">
                        <li>By email: <a href="mailto:dpo@connectly.com">dpo@connectly.com</a></li>
                        <li>Through our <a href="/contact">Contact page</a></li>
                        <li>By updating your account settings directly on the Platform</li>
                    </ul>
                    <p>We will respond to your request within 30 days, as required by the GDPR.</p>
                </section>

                <section id="section-6">
                    <h2><span class="cl-legal-section-num">6</span> Data Transfers</h2>
                    <p>If we transfer your personal data outside the European Economic Area (EEA), we ensure that appropriate safeguards are in place, such as Standard Contractual Clauses (SCCs) or adequacy decisions by the European Commission.</p>
                </section>

                <section id="section-7">
                    <h2><span class="cl-legal-section-num">7</span> Data Retention</h2>
                    <p>We retain your personal data only for as long as necessary to fulfill the purposes for which it was collected, or as required by applicable law. When data is no longer needed, it is securely deleted or anonymized.</p>
                </section>

                <section id="section-8">
                    <h2><span class="cl-legal-section-num">8</span> Data Security</h2>
                    <p>We implement appropriate technical and organizational measures to ensure a level of security appropriate to the risk, including encryption, access controls, and regular security assessments.</p>
                </section>

                <section id="section-9">
                    <h2><span class="cl-legal-section-num">9</span> Complaints</h2>
                    <p>If you believe that our processing of your personal data violates the GDPR, you have the right to lodge a complaint with your local data protection supervisory authority.</p>
                    <p>We encourage you to contact us first so we can address your concerns directly.</p>
                </section>

                <section id="section-10">
                    <h2><span class="cl-legal-section-num">10</span> Data Protection Officer</h2>
                    <p>Our Data Protection Officer (DPO) oversees our GDPR compliance and data protection strategy. You can reach our DPO at:</p>
                    <ul class="cl-legal-list">
                        <li>Email: <a href="mailto:dpo@connectly.com">dpo@connectly.com</a></li>
                        <li>Subject: "GDPR Request"</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>

    {{-- Back to Top --}}
    <button class="cl-legal-back-top" id="clLegalBackTop" aria-label="Back to top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
    </button>
</div>

{{-- ========== FOOTER ========== --}}
<footer class="cl-footer">
    <div class="cl-footer-accent"></div>
    <div class="cl-footer-inner">
        <div class="cl-footer-col cl-footer-brand-col">
            <div class="cl-footer-brand">
                <div class="cl-footer-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span class="cl-footer-brand-text">Connectly</span>
            </div>
            <p class="cl-footer-desc">A modern social platform for real conversations, meaningful connections, and seamless communication.</p>
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
        <div class="cl-footer-col">
            <h4 class="cl-footer-col-title">Product</h4>
            <ul class="cl-footer-col-links">
                <li><a href="{{ auth()->check() ? route('message', auth()->id()) : '/login' }}">Messages</a></li>
                <li><a href="/feed">Feed</a></li>
                <li><a href="{{ auth()->check() ? route('profile.show', auth()->id()) : '/login' }}">Profile</a></li>
                <li><a href="{{ route('friends') }}">Friends</a></li>
            </ul>
        </div>
        <div class="cl-footer-col">
            <h4 class="cl-footer-col-title">Company</h4>
            <ul class="cl-footer-col-links">
                <li><a href="/#about">About</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/#features">Features</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
        <div class="cl-footer-col">
            <h4 class="cl-footer-col-title">Legal</h4>
            <ul class="cl-footer-col-links">
                <li><a href="/privacy">Privacy Policy</a></li>
                <li><a href="/terms">Terms of Service</a></li>
                <li><a href="/cookies">Cookie Policy</a></li>
                <li><a href="/gdpr">GDPR</a></li>
            </ul>
        </div>
        <div class="cl-footer-col cl-footer-newsletter-col">
            <h4 class="cl-footer-col-title">Stay Updated</h4>
            <p class="cl-footer-newsletter-desc">Get the latest updates and news delivered to your inbox.</p>
            <form class="cl-footer-newsletter-form" onsubmit="event.preventDefault(); alert('Newsletter coming soon!');">
                <div class="cl-footer-newsletter-wrap">
                    <input type="email" placeholder="Enter your email" class="cl-footer-newsletter-input" required>
                    <button type="submit" class="cl-footer-newsletter-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
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

@include('frontend.partials.legal-styles')
@include('frontend.partials.legal-scripts')
@endsection
