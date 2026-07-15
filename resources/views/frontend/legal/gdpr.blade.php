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
        {{-- Table of Contents --}}
        <aside class="cl-legal-toc" id="clLegalToc">
            <div class="cl-legal-toc-title">On this page</div>
            <ul class="cl-legal-toc-list">
                <li><a href="#section-1">Overview</a></li>
                <li><a href="#section-2">Data Controller</a></li>
                <li><a href="#section-3">Legal Basis</a></li>
                <li><a href="#section-4">Your GDPR Rights</a></li>
                <li><a href="#section-5">Exercising Rights</a></li>
                <li><a href="#section-6">Data Transfers</a></li>
                <li><a href="#section-7">Data Retention</a></li>
                <li><a href="#section-8">Data Security</a></li>
                <li><a href="#section-9">Complaints</a></li>
                <li><a href="#section-10">Data Protection Officer</a></li>
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

@include('frontend.partials.legal-styles')
@include('frontend.partials.legal-scripts')
@endsection
