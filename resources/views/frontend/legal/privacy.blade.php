@extends('frontend.app')

@section('title', 'Privacy Policy — Connectly')

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
                <li><a href="#section-1">Introduction</a></li>
                <li><a href="#section-2">Information We Collect</a></li>
                <li><a href="#section-3">How We Use Your Information</a></li>
                <li><a href="#section-4">Data Sharing</a></li>
                <li><a href="#section-5">Data Security</a></li>
                <li><a href="#section-6">Data Retention</a></li>
                <li><a href="#section-7">Your Rights</a></li>
                <li><a href="#section-8">Cookies</a></li>
                <li><a href="#section-9">Third-Party Links</a></li>
                <li><a href="#section-10">Children's Privacy</a></li>
                <li><a href="#section-11">Changes</a></li>
                <li><a href="#section-12">Contact Us</a></li>
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
                    <div class="cl-legal-badge">Privacy Policy</div>
                </div>
                <h1 class="cl-legal-title">Your <span class="cl-legal-title-accent">Privacy</span> Matters</h1>
                <p class="cl-legal-date">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="cl-legal-body">
                <section id="section-1">
                    <h2><span class="cl-legal-section-num">1</span> Introduction</h2>
                    <p>Connectly ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our social platform and related services.</p>
                    <p>By accessing or using Connectly, you agree to the terms of this Privacy Policy. If you do not agree, please do not use our services.</p>
                </section>

                <section id="section-2">
                    <h2><span class="cl-legal-section-num">2</span> Information We Collect</h2>
                    <h3>Personal Information</h3>
                    <p>We may collect personally identifiable information such as your name, email address, profile picture, and any other information you voluntarily provide when creating an account or using our services.</p>
                    <h3>Usage Data</h3>
                    <p>We automatically collect certain information when you access Connectly, including your IP address, browser type, operating system, referring URLs, device information, and pages visited.</p>
                    <h3>Communications</h3>
                    <p>We collect information from your messages, posts, comments, and other communications made through the platform to facilitate social interactions and improve our services.</p>
                </section>

                <section id="section-3">
                    <h2><span class="cl-legal-section-num">3</span> How We Use Your Information</h2>
                    <p>We use the collected information for the following purposes:</p>
                    <ul class="cl-legal-list">
                        <li>To provide, maintain, and improve our services</li>
                        <li>To facilitate communication between users</li>
                        <li>To personalize your experience on the platform</li>
                        <li>To send administrative information, such as updates and security alerts</li>
                        <li>To detect, prevent, and address technical issues and fraud</li>
                        <li>To comply with legal obligations</li>
                    </ul>
                </section>

                <section id="section-4">
                    <h2><span class="cl-legal-section-num">4</span> Data Sharing and Disclosure</h2>
                    <p>We do not sell your personal information. We may share your data in the following circumstances:</p>
                    <ul class="cl-legal-list">
                        <li><strong>With other users:</strong> Your profile information and communications are visible to other users as you intend through the platform.</li>
                        <li><strong>Service providers:</strong> We may share data with third-party vendors who perform services on our behalf.</li>
                        <li><strong>Legal requirements:</strong> We may disclose information if required to do so by law or in response to valid legal requests.</li>
                        <li><strong>Business transfers:</strong> In the event of a merger, acquisition, or sale of assets, your data may be transferred.</li>
                    </ul>
                </section>

                <section id="section-5">
                    <h2><span class="cl-legal-section-num">5</span> Data Security</h2>
                    <p>We implement appropriate technical and organizational measures to protect your personal information, including encryption at rest and in transit, regular security audits, and access controls. However, no method of transmission over the Internet is 100% secure.</p>
                </section>

                <section id="section-6">
                    <h2><span class="cl-legal-section-num">6</span> Data Retention</h2>
                    <p>We retain your personal information for as long as your account is active or as needed to provide you services. You may request deletion of your data at any time by contacting us.</p>
                </section>

                <section id="section-7">
                    <h2><span class="cl-legal-section-num">7</span> Your Rights</h2>
                    <p>Depending on your jurisdiction, you may have the right to:</p>
                    <ul class="cl-legal-list">
                        <li>Access your personal data</li>
                        <li>Correct inaccurate data</li>
                        <li>Delete your data ("right to be forgotten")</li>
                        <li>Restrict or object to processing</li>
                        <li>Data portability</li>
                        <li>Withdraw consent at any time</li>
                    </ul>
                </section>

                <section id="section-8">
                    <h2><span class="cl-legal-section-num">8</span> Cookies</h2>
                    <p>We use cookies and similar tracking technologies to enhance your browsing experience, analyze site traffic, and understand where our audience comes from. For more information, please see our <a href="/cookies">Cookie Policy</a>.</p>
                </section>

                <section id="section-9">
                    <h2><span class="cl-legal-section-num">9</span> Third-Party Links</h2>
                    <p>Connectly may contain links to third-party websites or services. We are not responsible for the privacy practices of these third parties. We encourage you to review their privacy policies before providing any personal information.</p>
                </section>

                <section id="section-10">
                    <h2><span class="cl-legal-section-num">10</span> Children's Privacy</h2>
                    <p>Our services are not directed to individuals under the age of 16. We do not knowingly collect personal information from children. If we become aware that a child has provided us with personal data, we will take steps to delete such information.</p>
                </section>

                <section id="section-11">
                    <h2><span class="cl-legal-section-num">11</span> Changes to This Policy</h2>
                    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date. We encourage you to review this policy periodically.</p>
                </section>

                <section id="section-12">
                    <h2><span class="cl-legal-section-num">12</span> Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy, please contact us:</p>
                    <ul class="cl-legal-list">
                        <li>By email: <a href="mailto:privacy@connectly.com">privacy@connectly.com</a></li>
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
