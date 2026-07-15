@extends('frontend.app')

@section('title', 'Privacy Policy — Connectly')

@section('content')
<div class="cl-legal-page">
    <div class="cl-legal-container">
        <div class="cl-legal-header">
            <a href="/" class="cl-legal-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Home
            </a>
            <div class="cl-legal-badge">Legal</div>
            <h1 class="cl-legal-title">Privacy Policy</h1>
            <p class="cl-legal-date">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="cl-legal-content">
            <section>
                <h2>1. Introduction</h2>
                <p>Connectly ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our social platform and related services.</p>
                <p>By accessing or using Connectly, you agree to the terms of this Privacy Policy. If you do not agree, please do not use our services.</p>
            </section>

            <section>
                <h2>2. Information We Collect</h2>
                <h3>Personal Information</h3>
                <p>We may collect personally identifiable information such as your name, email address, profile picture, and any other information you voluntarily provide when creating an account or using our services.</p>

                <h3>Usage Data</h3>
                <p>We automatically collect certain information when you access Connectly, including your IP address, browser type, operating system, referring URLs, device information, and pages visited.</p>

                <h3>Communications</h3>
                <p>We collect information from your messages, posts, comments, and other communications made through the platform to facilitate social interactions and improve our services.</p>
            </section>

            <section>
                <h2>3. How We Use Your Information</h2>
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

            <section>
                <h2>4. Data Sharing and Disclosure</h2>
                <p>We do not sell your personal information. We may share your data in the following circumstances:</p>
                <ul class="cl-legal-list">
                    <li><strong>With other users:</strong> Your profile information and communications are visible to other users as you intend through the platform.</li>
                    <li><strong>Service providers:</strong> We may share data with third-party vendors who perform services on our behalf.</li>
                    <li><strong>Legal requirements:</strong> We may disclose information if required to do so by law or in response to valid legal requests.</li>
                    <li><strong>Business transfers:</strong> In the event of a merger, acquisition, or sale of assets, your data may be transferred.</li>
                </ul>
            </section>

            <section>
                <h2>5. Data Security</h2>
                <p>We implement appropriate technical and organizational measures to protect your personal information, including encryption at rest and in transit, regular security audits, and access controls. However, no method of transmission over the Internet is 100% secure.</p>
            </section>

            <section>
                <h2>6. Data Retention</h2>
                <p>We retain your personal information for as long as your account is active or as needed to provide you services. You may request deletion of your data at any time by contacting us.</p>
            </section>

            <section>
                <h2>7. Your Rights</h2>
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

            <section>
                <h2>8. Cookies</h2>
                <p>We use cookies and similar tracking technologies to enhance your browsing experience, analyze site traffic, and understand where our audience comes from. For more information, please see our <a href="/cookies">Cookie Policy</a>.</p>
            </section>

            <section>
                <h2>9. Third-Party Links</h2>
                <p>Connectly may contain links to third-party websites or services. We are not responsible for the privacy practices of these third parties. We encourage you to review their privacy policies before providing any personal information.</p>
            </section>

            <section>
                <h2>10. Children's Privacy</h2>
                <p>Our services are not directed to individuals under the age of 16. We do not knowingly collect personal information from children. If we become aware that a child has provided us with personal data, we will take steps to delete such information.</p>
            </section>

            <section>
                <h2>11. Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date. We encourage you to review this policy periodically.</p>
            </section>

            <section>
                <h2>12. Contact Us</h2>
                <p>If you have any questions about this Privacy Policy, please contact us:</p>
                <ul class="cl-legal-list">
                    <li>By email: privacy@connectly.com</li>
                    <li>Through our <a href="/contact">Contact page</a></li>
                </ul>
            </section>
        </div>
    </div>
</div>

<style>
/* ===== LEGAL PAGES – Global Styles ===== */
.cl-legal-page {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #F0F5FF;
    --clr-surface: #FFFFFF;
    --clr-text: #0F172A;
    --clr-muted: #64748B;

    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--clr-bg);
    color: var(--clr-text);
    min-height: 100vh;
    padding: 120px 24px 60px;
}

.cl-legal-container {
    max-width: 800px;
    margin: 0 auto;
    background: var(--clr-surface);
    border: 1px solid rgba(37,99,235,0.06);
    border-radius: 24px;
    padding: 48px 44px;
    box-shadow: 0 8px 30px rgba(15,23,42,0.04);
    animation: clLegalFadeIn 0.5s ease-out;
}

@keyframes clLegalFadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.cl-legal-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--clr-muted);
    text-decoration: none;
    transition: all 0.25s ease;
    margin-bottom: 20px;
}
.cl-legal-back:hover {
    color: var(--clr-primary);
    gap: 12px;
}

.cl-legal-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    background: rgba(37,99,235,0.08);
    border: 1px solid rgba(37,99,235,0.12);
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--clr-primary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 16px;
}

.cl-legal-header {
    margin-bottom: 36px;
    padding-bottom: 28px;
    border-bottom: 1px solid #eef2f8;
}

.cl-legal-title {
    font-size: 2.4rem;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.03em;
    color: var(--clr-text);
    margin-bottom: 8px;
}

.cl-legal-date {
    font-size: 0.85rem;
    color: var(--clr-muted);
    margin: 0;
}

/* Content */
.cl-legal-content section {
    margin-bottom: 32px;
}
.cl-legal-content section:last-child {
    margin-bottom: 0;
}

.cl-legal-content h2 {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--clr-text);
    margin-bottom: 14px;
    letter-spacing: -0.02em;
}

.cl-legal-content h3 {
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--clr-text);
    margin: 20px 0 10px;
}

.cl-legal-content p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--clr-muted);
    margin-bottom: 12px;
}

.cl-legal-list {
    list-style: none;
    padding: 0;
    margin: 12px 0;
}
.cl-legal-list li {
    font-size: 0.92rem;
    line-height: 1.7;
    color: var(--clr-muted);
    padding: 6px 0 6px 24px;
    position: relative;
}
.cl-legal-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 14px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--clr-primary);
    opacity: 0.4;
}

.cl-legal-content a {
    color: var(--clr-primary);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s ease;
}
.cl-legal-content a:hover {
    color: var(--clr-dark);
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .cl-legal-page {
        padding: 100px 16px 40px;
    }
    .cl-legal-container {
        padding: 32px 24px;
        border-radius: 18px;
    }
    .cl-legal-title {
        font-size: 1.8rem;
    }
    .cl-legal-content h2 {
        font-size: 1.2rem;
    }
    .cl-legal-content p {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .cl-legal-page {
        padding: 90px 12px 30px;
    }
    .cl-legal-container {
        padding: 24px 16px;
        border-radius: 14px;
    }
    .cl-legal-title {
        font-size: 1.5rem;
    }
    .cl-legal-content h2 {
        font-size: 1.05rem;
    }
    .cl-legal-content p,
    .cl-legal-list li {
        font-size: 0.85rem;
    }
    .cl-legal-list li {
        padding-left: 18px;
    }
    .cl-legal-list li::before {
        width: 5px;
        height: 5px;
        top: 12px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .cl-legal-container {
        animation: none;
    }
}
</style>
@endsection
