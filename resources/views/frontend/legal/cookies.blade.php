@extends('frontend.app')

@section('title', 'Cookie Policy — Connectly')

@section('content')
<div class="cl-legal-page">
    <div class="cl-legal-container">
        <div class="cl-legal-header">
            <a href="/" class="cl-legal-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Home
            </a>
            <div class="cl-legal-badge">Legal</div>
            <h1 class="cl-legal-title">Cookie Policy</h1>
            <p class="cl-legal-date">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="cl-legal-content">
            <section>
                <h2>1. What Are Cookies</h2>
                <p>Cookies are small text files that are stored on your device (computer, tablet, or mobile) when you visit a website. They help the website remember your preferences, recognize your device, and improve your browsing experience.</p>
                <p>This Cookie Policy explains what cookies we use, why we use them, and how you can control them.</p>
            </section>

            <section>
                <h2>2. Types of Cookies We Use</h2>

                <h3>Essential Cookies</h3>
                <p>These cookies are necessary for the Platform to function properly. They enable core features such as security, network management, and account authentication. Without these cookies, some services may not be available.</p>

                <h3>Functional Cookies</h3>
                <p>These cookies allow the Platform to remember choices you make (such as your username, language, or region) and provide enhanced, personalized features.</p>

                <h3>Analytics Cookies</h3>
                <p>These cookies help us understand how visitors interact with the Platform by collecting and reporting information anonymously. This helps us improve our services and user experience.</p>

                <h3>Preference Cookies</h3>
                <p>These cookies remember your settings and preferences to provide a customized experience tailored to you.</p>
            </section>

            <section>
                <h2>3. Third-Party Cookies</h2>
                <p>In addition to our own cookies, we may use various third-party cookies to help us analyze usage patterns, deliver relevant content, and provide social media features. These third parties may include:</p>
                <ul class="cl-legal-list">
                    <li>Analytics providers (to understand how users interact with our Platform)</li>
                    <li>Content delivery networks (to improve loading times)</li>
                    <li>Social media platforms (to enable sharing features)</li>
                </ul>
            </section>

            <section>
                <h2>4. How to Control Cookies</h2>
                <p>You have the right to choose whether to accept cookies. Most web browsers automatically accept cookies, but you can usually modify your browser settings to decline cookies if you prefer.</p>

                <h3>Browser Settings</h3>
                <p>You can control cookies through your browser settings:</p>
                <ul class="cl-legal-list">
                    <li><strong>Chrome:</strong> Settings → Privacy and security → Cookies and other site data</li>
                    <li><strong>Firefox:</strong> Options → Privacy & Security → Cookies and Site Data</li>
                    <li><strong>Safari:</strong> Preferences → Privacy → Cookies and website data</li>
                    <li><strong>Edge:</strong> Settings → Cookies and site permissions → Cookies</li>
                </ul>

                <h3>Opt-Out Tools</h3>
                <p>You can also use online tools such as <a href="https://optout.aboutads.info" target="_blank" rel="noopener">YourAdChoices</a> or <a href="https://www.youronlinechoices.com" target="_blank" rel="noopener">Your Online Choices</a> to manage your cookie preferences across multiple websites.</p>
            </section>

            <section>
                <h2>5. Consequences of Disabling Cookies</h2>
                <p>If you choose to disable cookies, some features of the Platform may not function properly. In particular, essential cookies are required for the login and messaging features to work.</p>
            </section>

            <section>
                <h2>6. Updates to This Policy</h2>
                <p>We may update this Cookie Policy from time to time. Changes will be posted on this page with an updated "Last updated" date. We encourage you to review this policy periodically.</p>
            </section>

            <section>
                <h2>7. Contact Us</h2>
                <p>If you have any questions about our Cookie Policy, please contact us:</p>
                <ul class="cl-legal-list">
                    <li>By email: privacy@connectly.com</li>
                    <li>Through our <a href="/contact">Contact page</a></li>
                </ul>
            </section>
        </div>
    </div>
</div>
@endsection
