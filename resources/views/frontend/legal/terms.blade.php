@extends('frontend.app')

@section('title', 'Terms of Service — Connectly')

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
        {{-- Table of Contents --}}
        <aside class="cl-legal-toc" id="clLegalToc">
            <div class="cl-legal-toc-title">On this page</div>
            <ul class="cl-legal-toc-list">
                <li><a href="#section-1">Acceptance of Terms</a></li>
                <li><a href="#section-2">Account Registration</a></li>
                <li><a href="#section-3">User Conduct</a></li>
                <li><a href="#section-4">Content & License</a></li>
                <li><a href="#section-5">Privacy</a></li>
                <li><a href="#section-6">Termination</a></li>
                <li><a href="#section-7">Limitation of Liability</a></li>
                <li><a href="#section-8">Disclaimer</a></li>
                <li><a href="#section-9">Changes to Terms</a></li>
                <li><a href="#section-10">Governing Law</a></li>
                <li><a href="#section-11">Contact</a></li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="cl-legal-card">
            <div class="cl-legal-header">
                <div class="cl-legal-header-top">
                    <a href="/" class="cl-legal-back">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Back to Home
                    </a>
                    <div class="cl-legal-badge">Terms of Service</div>
                </div>
                <h1 class="cl-legal-title">Our <span class="cl-legal-title-accent">Terms</span> of Service</h1>
                <p class="cl-legal-date">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="cl-legal-body">
                <section id="section-1">
                    <h2><span class="cl-legal-section-num">1</span> Acceptance of Terms</h2>
                    <p>By accessing or using Connectly ("the Platform"), you agree to be bound by these Terms of Service ("Terms"). If you do not agree to all the terms, you may not access or use the Platform.</p>
                    <p>These Terms apply to all visitors, users, and others who access or use the Platform.</p>
                </section>

                <section id="section-2">
                    <h2><span class="cl-legal-section-num">2</span> Account Registration</h2>
                    <p>To use certain features of the Platform, you must register for an account. You agree to:</p>
                    <ul class="cl-legal-list">
                        <li>Provide accurate, current, and complete registration information</li>
                        <li>Maintain and update your account information promptly</li>
                        <li>Keep your password secure and confidential</li>
                        <li>Be responsible for all activities under your account</li>
                        <li>Notify us immediately of any unauthorized use</li>
                    </ul>
                </section>

                <section id="section-3">
                    <h2><span class="cl-legal-section-num">3</span> User Conduct</h2>
                    <p>You agree not to use the Platform for any unlawful purpose or in violation of these Terms. Prohibited activities include:</p>
                    <ul class="cl-legal-list">
                        <li>Harassing, abusing, or harming others</li>
                        <li>Impersonating any person or entity</li>
                        <li>Posting inappropriate, defamatory, or obscene content</li>
                        <li>Uploading viruses or malicious code</li>
                        <li>Attempting to access unauthorized areas of the Platform</li>
                        <li>Spamming or soliciting other users</li>
                        <li>Violating any applicable laws or regulations</li>
                    </ul>
                </section>

                <section id="section-4">
                    <h2><span class="cl-legal-section-num">4</span> Content Ownership and License</h2>
                    <h3>Your Content</h3>
                    <p>You retain ownership of any content you post on the Platform, including messages, photos, and comments. By posting content, you grant Connectly a non-exclusive, royalty-free, worldwide license to use, display, and distribute your content on the Platform for the purpose of operating and improving our services.</p>
                    <h3>Platform Content</h3>
                    <p>All content provided by Connectly, including but not limited to logos, trademarks, design elements, and software, is owned by Connectly and protected by intellectual property laws.</p>
                </section>

                <section id="section-5">
                    <h2><span class="cl-legal-section-num">5</span> Privacy</h2>
                    <p>Your privacy is important to us. Please review our <a href="/privacy">Privacy Policy</a> to understand how we collect, use, and protect your personal information. By using the Platform, you consent to the collection and use of your information as described in the Privacy Policy.</p>
                </section>

                <section id="section-6">
                    <h2><span class="cl-legal-section-num">6</span> Termination</h2>
                    <p>We reserve the right to suspend or terminate your account at any time, without prior notice, for conduct that we believe violates these Terms or is harmful to other users, the Platform, or third parties.</p>
                    <p>Upon termination, your right to use the Platform will immediately cease. You may request deletion of your data by contacting us.</p>
                </section>

                <section id="section-7">
                    <h2><span class="cl-legal-section-num">7</span> Limitation of Liability</h2>
                    <p>To the fullest extent permitted by applicable law, Connectly shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or goodwill, resulting from your use of the Platform.</p>
                </section>

                <section id="section-8">
                    <h2><span class="cl-legal-section-num">8</span> Disclaimer of Warranties</h2>
                    <p>The Platform is provided on an "as is" and "as available" basis. Connectly makes no warranties, expressed or implied, regarding the operation or availability of the Platform, including but not limited to implied warranties of merchantability or fitness for a particular purpose.</p>
                </section>

                <section id="section-9">
                    <h2><span class="cl-legal-section-num">9</span> Changes to Terms</h2>
                    <p>We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting. Your continued use of the Platform after any changes indicates your acceptance of the new Terms. We encourage you to review these Terms periodically.</p>
                </section>

                <section id="section-10">
                    <h2><span class="cl-legal-section-num">10</span> Governing Law</h2>
                    <p>These Terms shall be governed by and construed in accordance with the applicable laws, without regard to its conflict of law provisions. Any disputes arising from these Terms shall be resolved in the competent courts.</p>
                </section>

                <section id="section-11">
                    <h2><span class="cl-legal-section-num">11</span> Contact</h2>
                    <p>If you have any questions about these Terms, please contact us:</p>
                    <ul class="cl-legal-list">
                        <li>By email: <a href="mailto:legal@connectly.com">legal@connectly.com</a></li>
                        <li>Through our <a href="/contact">Contact page</a></li>
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

@include('frontend.partials.legal-styles')
@include('frontend.partials.legal-scripts')
@endsection
