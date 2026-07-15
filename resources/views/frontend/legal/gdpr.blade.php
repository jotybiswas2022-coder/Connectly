@extends('frontend.app')

@section('title', 'GDPR Compliance — Connectly')

@section('content')
<div class="cl-legal-page">
    <div class="cl-legal-container">
        <div class="cl-legal-header">
            <a href="/" class="cl-legal-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Home
            </a>
            <div class="cl-legal-badge">GDPR</div>
            <h1 class="cl-legal-title">GDPR Compliance</h1>
            <p class="cl-legal-date">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="cl-legal-content">
            <section>
                <h2>1. Overview</h2>
                <p>The General Data Protection Regulation (GDPR) is a European Union regulation that governs the processing of personal data of individuals within the EU. Connectly is committed to full compliance with the GDPR requirements.</p>
                <p>This page explains your rights under the GDPR and how we ensure your data is protected.</p>
            </section>

            <section>
                <h2>2. Data Controller</h2>
                <p>Connectly acts as the data controller for the personal information collected through our Platform. As the data controller, we determine the purposes and means of processing your personal data.</p>
                <p>If you have any questions about our data protection practices, please contact our Data Protection Officer at dpo@connectly.com.</p>
            </section>

            <section>
                <h2>3. Legal Basis for Processing</h2>
                <p>Under the GDPR, we process your personal data based on the following legal grounds:</p>
                <ul class="cl-legal-list">
                    <li><strong>Consent:</strong> You have given explicit consent for specific processing purposes.</li>
                    <li><strong>Contract:</strong> Processing is necessary for the performance of a contract with you.</li>
                    <li><strong>Legal obligation:</strong> Processing is required to comply with legal obligations.</li>
                    <li><strong>Legitimate interests:</strong> Processing is necessary for our legitimate interests, provided these do not override your rights.</li>
                </ul>
            </section>

            <section>
                <h2>4. Your GDPR Rights</h2>
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

            <section>
                <h2>5. Exercising Your Rights</h2>
                <p>To exercise any of your GDPR rights, please contact us:</p>
                <ul class="cl-legal-list">
                    <li>By email: dpo@connectly.com</li>
                    <li>Through our <a href="/contact">Contact page</a></li>
                    <li>By updating your account settings directly on the Platform</li>
                </ul>
                <p>We will respond to your request within 30 days, as required by the GDPR.</p>
            </section>

            <section>
                <h2>6. Data Transfers</h2>
                <p>If we transfer your personal data outside the European Economic Area (EEA), we ensure that appropriate safeguards are in place, such as Standard Contractual Clauses (SCCs) or adequacy decisions by the European Commission.</p>
            </section>

            <section>
                <h2>7. Data Retention</h2>
                <p>We retain your personal data only for as long as necessary to fulfill the purposes for which it was collected, or as required by applicable law. When data is no longer needed, it is securely deleted or anonymized.</p>
            </section>

            <section>
                <h2>8. Data Security</h2>
                <p>We implement appropriate technical and organizational measures to ensure a level of security appropriate to the risk, including encryption, access controls, and regular security assessments.</p>
            </section>

            <section>
                <h2>9. Complaints</h2>
                <p>If you believe that our processing of your personal data violates the GDPR, you have the right to lodge a complaint with your local data protection supervisory authority.</p>
                <p>We encourage you to contact us first so we can address your concerns directly.</p>
            </section>

            <section>
                <h2>10. Data Protection Officer</h2>
                <p>Our Data Protection Officer (DPO) oversees our GDPR compliance and data protection strategy. You can reach our DPO at:</p>
                <ul class="cl-legal-list">
                    <li>Email: dpo@connectly.com</li>
                    <li>Subject: "GDPR Request"</li>
                </ul>
            </section>
        </div>
    </div>
</div>
@endsection
