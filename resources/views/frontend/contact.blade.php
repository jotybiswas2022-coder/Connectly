@extends('frontend.app')

@section('content')

<div class="chatbox-contact-page">

    {{-- ===== Floating Particles Background ===== --}}
    <div class="chatbox-floating-bubbles">
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
        <div class="chatbox-bubble"></div>
    </div>

    {{-- ===== Toast Notification (auto-dismiss) ===== --}}
    <div class="chatbox-toast" id="successToast">
        <div class="chatbox-toast-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="chatbox-toast-content">
            <span class="chatbox-toast-title">Success!</span>
            <span class="chatbox-toast-message" id="toastMessage">Your message was sent successfully!</span>
        </div>
        <button class="chatbox-toast-close" onclick="dismissToast()">&times;</button>
    </div>



    {{-- ===== Main Contact Section ===== --}}
    <section class="chatbox-contact-section" id="contact">
        <div class="chatbox-container">

            {{-- Section Header --}}
            <div class="chatbox-section-header chatbox-fade-up">
                <div class="chatbox-section-subtitle">
                    <i class="bi bi-chat-dots-fill"></i> Contact Us
                </div>
                <h2 class="chatbox-section-title">Let's Start a Conversation</h2>
                <p class="chatbox-section-desc">
                    Fill out the form below and our team will reach out to you shortly. We're here to help with anything you need.
                </p>
            </div>

            <div class="chatbox-contact-grid">

                {{-- ===== Left: Form ===== --}}
                <div class="chatbox-form-wrapper chatbox-fade-up">
                    <form id="contactForm" action="{{ route('contact') }}" method="POST" novalidate>
                        @csrf

                        <div class="chatbox-form-row">
                            <div class="chatbox-form-group">
                                <label for="name">Your Name <span class="chatbox-required">*</span></label>
                                <div class="chatbox-input-wrap">
                                    <i class="bi bi-person-fill chatbox-input-icon"></i>
                                    <input type="text" id="name" name="name" placeholder="John Doe" required aria-describedby="nameError">
                                    <div class="chatbox-input-focus-ring"></div>
                                </div>
                                <span class="chatbox-error-msg" id="nameError" role="alert">Please enter your name</span>
                            </div>
                        </div>

                        <div class="chatbox-form-row">
                            <div class="chatbox-form-group">
                                <label for="email">Your Email <span class="chatbox-required">*</span></label>
                                <div class="chatbox-input-wrap">
                                    <i class="bi bi-envelope-fill chatbox-input-icon"></i>
                                    <input type="email" id="email" name="email" placeholder="john@example.com" required aria-describedby="emailError">
                                    <div class="chatbox-input-focus-ring"></div>
                                </div>
                                <span class="chatbox-error-msg" id="emailError" role="alert">Please enter a valid email</span>
                            </div>
                        </div>

                        <div class="chatbox-form-row">
                            <div class="chatbox-form-group">
                                <label for="subject">Subject <span class="chatbox-optional">(optional)</span></label>
                                <div class="chatbox-input-wrap">
                                    <i class="bi bi-tag-fill chatbox-input-icon"></i>
                                    <input type="text" id="subject" name="subject" placeholder="How can we help you?" aria-describedby="subjectError">
                                    <div class="chatbox-input-focus-ring"></div>
                                </div>
                            </div>
                        </div>

                        <div class="chatbox-form-row">
                            <div class="chatbox-form-group">
                                <label for="message">Message <span class="chatbox-required">*</span></label>
                                <div class="chatbox-input-wrap chatbox-input-wrap-textarea">
                                    <i class="bi bi-chat-dots-fill chatbox-input-icon chatbox-input-icon-top"></i>
                                    <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required aria-describedby="messageError"></textarea>
                                    <div class="chatbox-input-focus-ring"></div>
                                </div>
                                <span class="chatbox-error-msg" id="messageError" role="alert">Please enter your message</span>
                            </div>
                        </div>

                        <button type="submit" class="chatbox-submit-btn" id="contactSubmitBtn">                                    <span class="chatbox-submit-text">Send Message</span>
                            <span class="chatbox-submit-loader">
                                <i class="bi bi-arrow-repeat"></i>
                                <span class="chatbox-submit-loading-text">Sending...</span>
                            </span>
                            <div class="chatbox-btn-ripple"></div>
                        </button>
                    </form>
                </div>

                {{-- ===== Right: Info Cards + Social ===== --}}
                <div class="chatbox-info-wrapper">

                    {{-- Email Card --}}
                    <div class="chatbox-info-card chatbox-fade-up">
                        <div class="chatbox-info-icon-box" style="background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="chatbox-info-text">
                            <h5>Email Us</h5>
                            <p>{{ $account->email ?? 'N/A' }}</p>
                            <a href="mailto:{{ $account->email ?? '' }}" class="chatbox-info-action">
                                Send an email <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Phone Card --}}
                    <div class="chatbox-info-card chatbox-fade-up">
                        <div class="chatbox-info-icon-box" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="chatbox-info-text">
                            <h5>Call Us</h5>
                            <p>{{ $account->phone ?? '+1 (555) 123-4567' }}</p>
                            <a href="tel:{{ $account->phone ?? '' }}" class="chatbox-info-action">
                                Call now <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>



</div>

<script>
// ===== Intersection Observer for Scroll Animations =====
const chatboxObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('chatbox-visible');
            }, index * 100);
            chatboxObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.chatbox-fade-up').forEach(el => chatboxObserver.observe(el));

// ===== Toast Notification =====
function showToast(message, isError = false) {
    const toast = document.getElementById('successToast');
    const toastMsg = document.getElementById('toastMessage');
    const icon = toast.querySelector('.chatbox-toast-icon i');

    toastMsg.textContent = message;
    toast.classList.remove('chatbox-toast-error');
    icon.className = 'bi bi-check-circle-fill';

    if (isError) {
        toast.classList.add('chatbox-toast-error');
        icon.className = 'bi bi-exclamation-circle-fill';
    }

    toast.classList.add('chatbox-toast-show');

    setTimeout(() => {
        dismissToast();
    }, 5000);
}

function dismissToast() {
    const toast = document.getElementById('successToast');
    toast.classList.remove('chatbox-toast-show');
}

// ===== Real-time Form Validation =====
const form = document.getElementById('contactForm');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const messageInput = document.getElementById('message');
const nameError = document.getElementById('nameError');
const emailError = document.getElementById('emailError');
const messageError = document.getElementById('messageError');
const submitBtn = document.getElementById('contactSubmitBtn');

// Real-time validation on input
nameInput.addEventListener('input', function() {
    if (this.value.trim().length >= 2) {
        this.parentElement.classList.add('chatbox-valid');
        this.parentElement.classList.remove('chatbox-invalid');
        nameError.style.display = 'none';
    } else if (this.value.trim().length > 0) {
        this.parentElement.classList.remove('chatbox-valid');
        this.parentElement.classList.add('chatbox-invalid');
        nameError.style.display = 'block';
    } else {
        this.parentElement.classList.remove('chatbox-valid', 'chatbox-invalid');
        nameError.style.display = 'none';
    }
});

emailInput.addEventListener('input', function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailRegex.test(this.value.trim())) {
        this.parentElement.classList.add('chatbox-valid');
        this.parentElement.classList.remove('chatbox-invalid');
        emailError.style.display = 'none';
    } else if (this.value.trim().length > 0) {
        this.parentElement.classList.remove('chatbox-valid');
        this.parentElement.classList.add('chatbox-invalid');
        emailError.style.display = 'block';
    } else {
        this.parentElement.classList.remove('chatbox-valid', 'chatbox-invalid');
        emailError.style.display = 'none';
    }
});

messageInput.addEventListener('input', function() {
    if (this.value.trim().length >= 10) {
        this.parentElement.classList.add('chatbox-valid');
        this.parentElement.classList.remove('chatbox-invalid');
        messageError.style.display = 'none';
    } else if (this.value.trim().length > 0) {
        this.parentElement.classList.remove('chatbox-valid');
        this.parentElement.classList.add('chatbox-invalid');
        messageError.style.display = 'block';
    } else {
        this.parentElement.classList.remove('chatbox-valid', 'chatbox-invalid');
        messageError.style.display = 'none';
    }
});

// ===== AJAX Form Submit =====
form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Validate all fields
    let isValid = true;

    if (nameInput.value.trim().length < 2) {
        nameInput.parentElement.classList.add('chatbox-invalid');
        nameError.style.display = 'block';
        isValid = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value.trim())) {
        emailInput.parentElement.classList.add('chatbox-invalid');
        emailError.style.display = 'block';
        isValid = false;
    }

    if (messageInput.value.trim().length < 10) {
        messageInput.parentElement.classList.add('chatbox-invalid');
        messageError.style.display = 'block';
        isValid = false;
    }

    if (!isValid) return;

    // Submit state
    submitBtn.disabled = true;
    submitBtn.classList.add('chatbox-submit-loading');

    const formData = new FormData(form);

    fetch("{{ route('contact') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Request failed");
        return response.text();
    })
    .then(() => {
        showToast('Your message was sent successfully! We will get back to you soon.');
        form.reset();

        // Reset validation states
        document.querySelectorAll('.chatbox-input-wrap').forEach(wrap => {
            wrap.classList.remove('chatbox-valid', 'chatbox-invalid');
        });
        document.querySelectorAll('.chatbox-error-msg').forEach(msg => {
            msg.style.display = 'none';
        });
    })
    .catch(() => {
        showToast('Failed to send message. Please try again later.', true);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.classList.remove('chatbox-submit-loading');
    });
});

// ===== Smooth scroll for anchor links =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});


</script>

<style>
/* ============================================
   CONTACT PAGE — Premium Redesign
   Scoped to .chatbox-contact-page
   ============================================ */

/* ── Variables ── */
.chatbox-contact-page {
    --cp-primary: #2563EB;
    --cp-primary-dark: #1d4ed8;
    --cp-primary-light: #3b82f6;
    --cp-primary-glow: rgba(37, 99, 235, 0.25);
    --cp-bg: #f8fafc;
    --cp-card-bg: #ffffff;
    --cp-text: #0f172a;
    --cp-text-secondary: #475569;
    --cp-text-muted: #94a3b8;
    --cp-border: rgba(37, 99, 235, 0.12);
    --cp-shadow: 0 4px 24px rgba(37, 99, 235, 0.08);
    --cp-shadow-hover: 0 12px 48px rgba(37, 99, 235, 0.15);
    --cp-radius: 20px;
    --cp-radius-sm: 14px;
    --cp-radius-xs: 10px;
    --cp-transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    --cp-gradient-blue: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
    --cp-gradient-green: linear-gradient(135deg, #059669 0%, #047857 100%);
    --cp-gradient-amber: linear-gradient(135deg, #D97706 0%, #B45309 100%);
    --cp-gradient-purple: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);
    --cp-gradient-red: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);

    width: 100%;
    min-height: 100vh;
    position: relative;
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--cp-text);
    background: var(--cp-bg);
    overflow-x: hidden;
}

/* ── Floating Background Particles ── */
.chatbox-contact-page .chatbox-floating-bubbles {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

.chatbox-contact-page .chatbox-bubble {
    position: absolute;
    border-radius: 50%;
    animation: chatbox-float-up 20s infinite ease-in-out;
    opacity: 0;
}

.chatbox-contact-page .chatbox-bubble:nth-child(1) {
    width: 120px;
    height: 120px;
    left: 5%;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.08), transparent);
    animation-delay: 0s;
    animation-duration: 18s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(2) {
    width: 80px;
    height: 80px;
    left: 20%;
    background: radial-gradient(circle, rgba(5, 150, 105, 0.08), transparent);
    animation-delay: 2s;
    animation-duration: 22s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(3) {
    width: 160px;
    height: 160px;
    left: 40%;
    background: radial-gradient(circle, rgba(124, 58, 237, 0.06), transparent);
    animation-delay: 4s;
    animation-duration: 25s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(4) {
    width: 90px;
    height: 90px;
    left: 60%;
    background: radial-gradient(circle, rgba(217, 119, 6, 0.08), transparent);
    animation-delay: 6s;
    animation-duration: 20s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(5) {
    width: 140px;
    height: 140px;
    left: 78%;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.06), transparent);
    animation-delay: 8s;
    animation-duration: 24s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(6) {
    width: 60px;
    height: 60px;
    left: 90%;
    background: radial-gradient(circle, rgba(220, 38, 38, 0.06), transparent);
    animation-delay: 10s;
    animation-duration: 16s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(7) {
    width: 100px;
    height: 100px;
    left: 50%;
    background: radial-gradient(circle, rgba(5, 150, 105, 0.06), transparent);
    animation-delay: 3s;
    animation-duration: 19s;
}

.chatbox-contact-page .chatbox-bubble:nth-child(8) {
    width: 70px;
    height: 70px;
    left: 30%;
    background: radial-gradient(circle, rgba(124, 58, 237, 0.08), transparent);
    animation-delay: 7s;
    animation-duration: 21s;
}

@keyframes chatbox-float-up {
    0% {
        bottom: -160px;
        opacity: 0;
        transform: translateX(0) rotate(0deg) scale(0.5);
    }
    20% {
        opacity: 0.4;
    }
    50% {
        opacity: 0.2;
        transform: translateX(80px) rotate(180deg) scale(1);
    }
    80% {
        opacity: 0.3;
    }
    100% {
        bottom: 110%;
        opacity: 0;
        transform: translateX(-60px) rotate(360deg) scale(0.6);
    }
}

/* ── Toast Notification ── */
.chatbox-contact-page .chatbox-toast {
    position: fixed;
    top: -80px;
    left: 50%;
    transform: translateX(-50%) translateY(0);
    background: #ffffff;
    color: var(--cp-text);
    padding: 14px 22px;
    border-radius: var(--cp-radius-sm);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 2px 8px rgba(0, 0, 0, 0.06);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 14px;
    font-weight: 500;
    font-size: 14px;
    border-left: 4px solid #10b981;
    transition: top 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.4s ease;
    opacity: 0;
    max-width: 90vw;
    min-width: 320px;
}

.chatbox-contact-page .chatbox-toast.chatbox-toast-show {
    top: 24px;
    opacity: 1;
}

.chatbox-contact-page .chatbox-toast.chatbox-toast-error {
    border-left-color: #ef4444;
}

.chatbox-contact-page .chatbox-toast-icon {
    flex-shrink: 0;
}

.chatbox-contact-page .chatbox-toast-icon i {
    font-size: 24px;
    color: #10b981;
}

.chatbox-contact-page .chatbox-toast.chatbox-toast-error .chatbox-toast-icon i {
    color: #ef4444;
}

.chatbox-contact-page .chatbox-toast-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 1;
}

.chatbox-contact-page .chatbox-toast-title {
    font-weight: 700;
    font-size: 14px;
    color: var(--cp-text);
}

.chatbox-contact-page .chatbox-toast-message {
    font-weight: 400;
    font-size: 13px;
    color: var(--cp-text-secondary);
}

.chatbox-contact-page .chatbox-toast-close {
    background: none;
    border: none;
    color: var(--cp-text-muted);
    font-size: 20px;
    cursor: pointer;
    padding: 0 0 0 8px;
    line-height: 1;
    transition: color 0.2s ease;
}

.chatbox-contact-page .chatbox-toast-close:hover {
    color: var(--cp-text);
}

/* ── Hero Section ── */
.chatbox-contact-page .chatbox-hero {
    position: relative;
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 24px 80px;
    overflow: hidden;
    background: linear-gradient(165deg, #0f172a 0%, #1e293b 40%, #0f172a 100%);
    z-index: 1;
}

.chatbox-contact-page .chatbox-hero-bg {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.chatbox-contact-page .chatbox-hero-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.15;
}

.chatbox-contact-page .chatbox-hero-shape-1 {
    width: 500px;
    height: 500px;
    background: #2563EB;
    top: -150px;
    right: -100px;
    animation: chatbox-hero-float 8s ease-in-out infinite;
}

.chatbox-contact-page .chatbox-hero-shape-2 {
    width: 400px;
    height: 400px;
    background: #7C3AED;
    bottom: -120px;
    left: -80px;
    animation: chatbox-hero-float 10s ease-in-out infinite reverse;
}

.chatbox-contact-page .chatbox-hero-shape-3 {
    width: 300px;
    height: 300px;
    background: #059669;
    top: 40%;
    left: 60%;
    animation: chatbox-hero-float 12s ease-in-out infinite;
}

@keyframes chatbox-hero-float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(30px, -30px) scale(1.1); }
}

.chatbox-contact-page .chatbox-hero-content {
    position: relative;
    text-align: center;
    max-width: 820px;
    z-index: 2;
}

.chatbox-contact-page .chatbox-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(37, 99, 235, 0.15);
    color: #60A5FA;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 28px;
    border: 1px solid rgba(37, 99, 235, 0.25);
    backdrop-filter: blur(8px);
    letter-spacing: 0.3px;
}

.chatbox-contact-page .chatbox-hero-badge i {
    font-size: 16px;
}

.chatbox-contact-page .chatbox-hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 900;
    color: #ffffff;
    margin: 0 0 24px;
    line-height: 1.1;
    letter-spacing: -1px;
}

.chatbox-contact-page .chatbox-hero-gradient-text {
    background: linear-gradient(135deg, #60A5FA 0%, #A78BFA 50%, #34D399 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.chatbox-contact-page .chatbox-hero-desc {
    font-size: clamp(1rem, 1.5vw, 1.15rem);
    color: rgba(255, 255, 255, 0.65);
    max-width: 640px;
    margin: 0 auto 40px;
    line-height: 1.7;
}

.chatbox-contact-page .chatbox-hero-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--cp-radius);
    padding: 24px 32px;
    backdrop-filter: blur(12px);
    max-width: 640px;
    margin: 0 auto;
}

.chatbox-contact-page .chatbox-hero-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 8px 24px;
}

.chatbox-contact-page .chatbox-hero-stat-num {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    background: linear-gradient(135deg, #60A5FA, #A78BFA);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.chatbox-contact-page .chatbox-hero-stat-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    font-weight: 500;
    white-space: nowrap;
}

.chatbox-contact-page .chatbox-hero-stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
}

/* ── Contact Section ── */
.chatbox-contact-page .chatbox-contact-section {
    position: relative;
    padding: 80px 24px 100px;
    z-index: 1;
}

.chatbox-contact-page .chatbox-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

/* ── Section Header ── */
.chatbox-contact-page .chatbox-section-header {
    text-align: center;
    margin-bottom: 56px;
}

.chatbox-contact-page .chatbox-section-subtitle {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--cp-gradient-blue);
    color: white;
    padding: 10px 25px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
    box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
    animation: chatbox-pulse-glow 3s infinite;
}

@keyframes chatbox-pulse-glow {
    0%, 100% { box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3); }
    50% { box-shadow: 0 4px 35px rgba(37, 99, 235, 0.5); }
}

.chatbox-contact-page .chatbox-section-title {
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    font-weight: 800;
    margin: 0 0 16px;
    line-height: 1.2;
    background: linear-gradient(135deg, #0f172a 0%, #2563EB 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.chatbox-contact-page .chatbox-section-desc {
    font-size: 1.05rem;
    color: var(--cp-text-secondary);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── Contact Grid ── */
.chatbox-contact-page .chatbox-contact-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 40px;
    align-items: start;
}

/* ── Form Wrapper ── */
.chatbox-contact-page .chatbox-form-wrapper {
    background: var(--cp-card-bg);
    padding: 48px;
    border-radius: var(--cp-radius);
    box-shadow: var(--cp-shadow);
    border: 1px solid var(--cp-border);
    position: relative;
    overflow: hidden;
}

.chatbox-contact-page .chatbox-form-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #2563EB, #7C3AED, #059669);
    background-size: 200% 100%;
    animation: chatbox-gradient-slide 3s ease infinite;
}

@keyframes chatbox-gradient-slide {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.chatbox-contact-page .chatbox-form-row {
    margin-bottom: 24px;
}

.chatbox-contact-page .chatbox-form-group label {
    display: block;
    color: var(--cp-text);
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 14px;
}

.chatbox-contact-page .chatbox-required {
    color: #ef4444;
}

.chatbox-contact-page .chatbox-optional {
    color: var(--cp-text-muted);
    font-weight: 400;
    font-size: 12px;
}

.chatbox-contact-page .chatbox-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.chatbox-contact-page .chatbox-input-wrap-textarea {
    align-items: flex-start;
}

.chatbox-contact-page .chatbox-input-icon {
    position: absolute;
    left: 16px;
    color: var(--cp-text-muted);
    font-size: 16px;
    z-index: 2;
    transition: color var(--cp-transition);
    pointer-events: none;
}

.chatbox-contact-page .chatbox-input-icon-top {
    top: 18px;
}

.chatbox-contact-page .chatbox-input-wrap:focus-within .chatbox-input-icon {
    color: var(--cp-primary);
}

.chatbox-contact-page .chatbox-input-wrap input,
.chatbox-contact-page .chatbox-input-wrap textarea {
    width: 100%;
    padding: 14px 18px 14px 46px;
    border: 2px solid #e2e8f0;
    border-radius: var(--cp-radius-xs);
    font-size: 15px;
    transition: border-color var(--cp-transition), box-shadow var(--cp-transition), background var(--cp-transition);
    background: #f8fafc;
    color: var(--cp-text);
    box-sizing: border-box;
    position: relative;
    z-index: 1;
    font-family: inherit;
}

.chatbox-contact-page .chatbox-input-wrap textarea {
    padding-left: 46px;
    resize: vertical;
    min-height: 130px;
    line-height: 1.6;
}

.chatbox-contact-page .chatbox-input-wrap input:focus,
.chatbox-contact-page .chatbox-input-wrap textarea:focus {
    outline: none;
    border-color: var(--cp-primary);
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.chatbox-contact-page .chatbox-input-wrap.chatbox-valid input,
.chatbox-contact-page .chatbox-input-wrap.chatbox-valid textarea {
    border-color: #10b981;
    background: #f0fdf4;
}

.chatbox-contact-page .chatbox-input-wrap.chatbox-valid .chatbox-input-icon {
    color: #10b981;
}

.chatbox-contact-page .chatbox-input-wrap.chatbox-invalid input,
.chatbox-contact-page .chatbox-input-wrap.chatbox-invalid textarea {
    border-color: #ef4444;
    background: #fef2f2;
}

.chatbox-contact-page .chatbox-input-wrap.chatbox-invalid .chatbox-input-icon {
    color: #ef4444;
}

.chatbox-contact-page .chatbox-input-wrap.chatbox-valid input:focus,
.chatbox-contact-page .chatbox-input-wrap.chatbox-valid textarea:focus {
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
}

.chatbox-contact-page .chatbox-input-wrap.chatbox-invalid input:focus,
.chatbox-contact-page .chatbox-input-wrap.chatbox-invalid textarea:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
}

.chatbox-contact-page .chatbox-focus-ring {
    display: none;
}

.chatbox-contact-page .chatbox-error-msg {
    display: none;
    color: #ef4444;
    font-size: 12px;
    font-weight: 500;
    margin-top: 6px;
    padding-left: 4px;
}

.chatbox-contact-page .chatbox-submit-btn {
    width: 100%;
    padding: 16px 28px;
    background: var(--cp-gradient-blue);
    color: white;
    border: none;
    border-radius: var(--cp-radius-xs);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all var(--cp-transition);
    box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
    position: relative;
    overflow: hidden;
}

.chatbox-contact-page .chatbox-submit-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(37, 99, 235, 0.4);
}

.chatbox-contact-page .chatbox-submit-btn:active:not(:disabled) {
    transform: translateY(0);
}

.chatbox-contact-page .chatbox-submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.chatbox-contact-page .chatbox-submit-loader {
    display: none;
    animation: chatbox-spin 0.8s linear infinite;
}

.chatbox-contact-page .chatbox-submit-loading .chatbox-submit-text {
    display: none;
}

.chatbox-contact-page .chatbox-submit-loader {
    display: none;
    align-items: center;
    gap: 8px;
    font-size: 15px;
}

.chatbox-contact-page .chatbox-submit-loading .chatbox-submit-loader {
    display: inline-flex;
}

.chatbox-contact-page .chatbox-submit-loading-text {
    font-weight: 500;
}

@keyframes chatbox-spin {
    to { transform: rotate(360deg); }
}

.chatbox-contact-page .chatbox-btn-ripple {
    display: none;
}

/* ── Info Cards ── */
.chatbox-contact-page .chatbox-info-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.chatbox-contact-page .chatbox-info-card {
    background: var(--cp-card-bg);
    padding: 24px;
    border-radius: var(--cp-radius-sm);
    box-shadow: var(--cp-shadow);
    border: 1px solid var(--cp-border);
    display: flex;
    gap: 18px;
    align-items: flex-start;
    transition: transform var(--cp-transition), box-shadow var(--cp-transition);
    position: relative;
    overflow: hidden;
}

.chatbox-contact-page .chatbox-info-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.02), transparent);
    opacity: 0;
    transition: opacity var(--cp-transition);
    pointer-events: none;
}

.chatbox-contact-page .chatbox-info-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--cp-shadow-hover);
}

.chatbox-contact-page .chatbox-info-card:hover::after {
    opacity: 1;
}

.chatbox-contact-page .chatbox-info-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    transition: transform var(--cp-transition);
}

.chatbox-contact-page .chatbox-info-card:hover .chatbox-info-icon-box {
    transform: scale(1.08) rotate(-3deg);
}

.chatbox-contact-page .chatbox-info-icon-box i {
    font-size: 24px;
    color: white;
}

.chatbox-contact-page .chatbox-info-text {
    flex: 1;
    min-width: 0;
}

.chatbox-contact-page .chatbox-info-text h5 {
    font-size: 15px;
    font-weight: 700;
    color: var(--cp-text);
    margin: 0 0 6px;
}

.chatbox-contact-page .chatbox-info-text p {
    color: var(--cp-text-secondary);
    line-height: 1.5;
    font-size: 14px;
    margin: 0 0 10px;
    word-break: break-word;
}

.chatbox-contact-page .chatbox-info-action {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: var(--cp-primary);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: gap var(--cp-transition);
}

.chatbox-contact-page .chatbox-info-action:hover {
    gap: 8px;
    color: var(--cp-primary-dark);
}

.chatbox-contact-page .chatbox-info-action i {
    font-size: 16px;
    transition: transform var(--cp-transition);
}

.chatbox-contact-page .chatbox-info-action:hover i {
    transform: translateX(2px);
}

/* ── Hours Card ── */
.chatbox-contact-page .chatbox-info-card-hours .chatbox-info-text {
    width: 100%;
}

.chatbox-contact-page .chatbox-hours-grid {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 8px;
}

.chatbox-contact-page .chatbox-hours-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: var(--cp-text-secondary);
    padding: 4px 0;
    border-bottom: 1px solid rgba(0,0,0,0.04);
}

.chatbox-contact-page .chatbox-hours-row:last-child {
    border-bottom: none;
}

.chatbox-contact-page .chatbox-hours-value {
    font-weight: 600;
    color: var(--cp-text);
}

.chatbox-contact-page .chatbox-hours-closed {
    color: #ef4444 !important;
}

/* ── Social Card ── */
.chatbox-contact-page .chatbox-social-card {
    background: var(--cp-card-bg);
    padding: 24px;
    border-radius: var(--cp-radius-sm);
    box-shadow: var(--cp-shadow);
    border: 1px solid var(--cp-border);
    text-align: center;
}

.chatbox-contact-page .chatbox-social-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--cp-text);
    margin: 0 0 16px;
}

.chatbox-contact-page .chatbox-social-links {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.chatbox-contact-page .chatbox-social-link {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.04);
    color: var(--cp-text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 18px;
    transition: all var(--cp-transition);
    border: 1px solid transparent;
}

.chatbox-contact-page .chatbox-social-link:hover {
    background: var(--social-color, #2563EB);
    color: #ffffff;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    border-color: var(--social-color, #2563EB);
}

/* ── CTA Section ── */
.chatbox-contact-page .chatbox-cta-section {
    position: relative;
    padding: 80px 24px;
    overflow: hidden;
    z-index: 1;
    background: linear-gradient(165deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
}

.chatbox-contact-page .chatbox-cta-bg {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.chatbox-contact-page .chatbox-cta-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
}

.chatbox-contact-page .chatbox-cta-shape-1 {
    width: 400px;
    height: 400px;
    background: #2563EB;
    top: -150px;
    right: -80px;
    opacity: 0.12;
    animation: chatbox-hero-float 10s ease-in-out infinite;
}

.chatbox-contact-page .chatbox-cta-shape-2 {
    width: 300px;
    height: 300px;
    background: #7C3AED;
    bottom: -100px;
    left: -60px;
    opacity: 0.1;
    animation: chatbox-hero-float 12s ease-in-out infinite reverse;
}

.chatbox-contact-page .chatbox-cta-content {
    position: relative;
    text-align: center;
    max-width: 640px;
    margin: 0 auto;
    z-index: 2;
}

.chatbox-contact-page .chatbox-cta-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(16, 185, 129, 0.15);
    color: #34D399;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 24px;
    border: 1px solid rgba(16, 185, 129, 0.2);
    backdrop-filter: blur(8px);
}

.chatbox-contact-page .chatbox-cta-title {
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 16px;
    line-height: 1.2;
}

.chatbox-contact-page .chatbox-cta-desc {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.6);
    line-height: 1.7;
    margin: 0 0 32px;
}

.chatbox-contact-page .chatbox-cta-buttons {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
}

.chatbox-contact-page .chatbox-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 32px;
    border-radius: var(--cp-radius-xs);
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--cp-transition);
    cursor: pointer;
}

.chatbox-contact-page .chatbox-cta-btn-primary {
    background: var(--cp-gradient-blue);
    color: white;
    box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
}

.chatbox-contact-page .chatbox-cta-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(37, 99, 235, 0.4);
}

.chatbox-contact-page .chatbox-cta-btn-secondary {
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.chatbox-contact-page .chatbox-cta-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.14);
    color: #ffffff;
    transform: translateY(-2px);
}

/* ── Fade Up Animation ── */
.chatbox-contact-page .chatbox-fade-up {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

.chatbox-contact-page .chatbox-fade-up.chatbox-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ── Responsive: Tablet (max 991px) ── */
@media (max-width: 991.98px) {
    .chatbox-contact-page .chatbox-contact-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .chatbox-contact-page .chatbox-form-wrapper {
        padding: 36px;
    }

    .chatbox-contact-page .chatbox-hero {
        min-height: 60vh;
        padding: 100px 24px 60px;
    }

    .chatbox-contact-page .chatbox-hero-stats {
        padding: 20px 16px;
    }

    .chatbox-contact-page .chatbox-hero-stat {
        padding: 6px 16px;
    }

    .chatbox-contact-page .chatbox-contact-section {
        padding: 60px 24px 80px;
    }

    .chatbox-contact-page .chatbox-section-header {
        margin-bottom: 40px;
    }

    .chatbox-contact-page .chatbox-cta-section {
        padding: 60px 24px;
    }
}

/* ── Responsive: Mobile Landscape (max 767px) ── */
@media (max-width: 767.98px) {
    .chatbox-contact-page .chatbox-hero {
        min-height: auto;
        padding: 90px 20px 50px;
    }

    .chatbox-contact-page .chatbox-hero-title {
        font-size: clamp(2rem, 6vw, 2.75rem);
    }

    .chatbox-contact-page .chatbox-hero-desc {
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .chatbox-contact-page .chatbox-hero-stats {
        flex-direction: column;
        gap: 12px;
        padding: 16px;
        border-radius: var(--cp-radius-sm);
    }

    .chatbox-contact-page .chatbox-hero-stat {
        padding: 4px 0;
        width: 100%;
    }

    .chatbox-contact-page .chatbox-hero-stat-divider {
        width: 60%;
        height: 1px;
    }

    .chatbox-contact-page .chatbox-contact-section {
        padding: 50px 20px 60px;
    }

    .chatbox-contact-page .chatbox-form-wrapper {
        padding: 28px;
        border-radius: var(--cp-radius-sm);
    }

    .chatbox-contact-page .chatbox-form-row {
        margin-bottom: 18px;
    }

    .chatbox-contact-page .chatbox-input-wrap input,
    .chatbox-contact-page .chatbox-input-wrap textarea {
        padding: 12px 14px 12px 42px;
        font-size: 14px;
    }

    .chatbox-contact-page .chatbox-input-icon {
        left: 14px;
        font-size: 14px;
    }

    .chatbox-contact-page .chatbox-info-wrapper {
        gap: 16px;
    }

    .chatbox-contact-page .chatbox-info-card {
        padding: 18px;
        border-radius: var(--cp-radius-xs);
    }

    .chatbox-contact-page .chatbox-info-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
    }

    .chatbox-contact-page .chatbox-info-icon-box i {
        font-size: 20px;
    }

    .chatbox-contact-page .chatbox-social-card {
        padding: 18px;
    }

    .chatbox-contact-page .chatbox-social-link {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .chatbox-contact-page .chatbox-cta-section {
        padding: 50px 20px;
    }

    .chatbox-contact-page .chatbox-cta-btn {
        padding: 14px 24px;
        font-size: 14px;
    }

    .chatbox-contact-page .chatbox-toast {
        min-width: auto;
        max-width: calc(100vw - 24px);
        padding: 12px 16px;
        font-size: 13px;
    }

    .chatbox-contact-page .chatbox-toast-icon i {
        font-size: 20px;
    }

    /* Hide floating bubbles on mobile for better performance */
    .chatbox-contact-page .chatbox-floating-bubbles {
        display: none;
    }
}

/* ── Responsive: Small Mobile (max 480px) ── */
@media (max-width: 480px) {
    .chatbox-contact-page .chatbox-hero {
        padding: 80px 16px 40px;
    }

    .chatbox-contact-page .chatbox-hero-badge {
        font-size: 12px;
        padding: 8px 18px;
    }

    .chatbox-contact-page .chatbox-contact-section {
        padding: 40px 16px 50px;
    }

    .chatbox-contact-page .chatbox-form-wrapper {
        padding: 22px;
        border-radius: 12px;
    }

    .chatbox-contact-page .chatbox-section-header {
        margin-bottom: 30px;
    }

    .chatbox-contact-page .chatbox-section-subtitle {
        font-size: 12px;
        padding: 8px 18px;
    }

    .chatbox-contact-page .chatbox-section-desc {
        font-size: 0.9rem;
    }

    .chatbox-contact-page .chatbox-submit-btn {
        padding: 14px 20px;
        font-size: 15px;
    }

    .chatbox-contact-page .chatbox-hours-row {
        font-size: 12px;
    }

    .chatbox-contact-page .chatbox-cta-section {
        padding: 40px 16px;
    }

    .chatbox-contact-page .chatbox-cta-buttons {
        flex-direction: column;
        gap: 12px;
    }

    .chatbox-contact-page .chatbox-cta-btn {
        width: 100%;
        justify-content: center;
        padding: 14px 20px;
    }

    .chatbox-contact-page .chatbox-info-card {
        padding: 16px;
        gap: 14px;
    }

    .chatbox-contact-page .chatbox-info-text h5 {
        font-size: 14px;
    }

    .chatbox-contact-page .chatbox-info-text p {
        font-size: 13px;
    }

    .chatbox-contact-page .chatbox-social-links {
        gap: 8px;
    }

    .chatbox-contact-page .chatbox-social-link {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }

    .chatbox-contact-page .chatbox-toast {
        padding: 10px 14px;
        font-size: 12px;
        left: 12px;
        right: 12px;
        transform: none;
        max-width: none;
    }

    .chatbox-contact-page .chatbox-toast.chatbox-toast-show {
        top: 16px;
    }
}

/* ── Responsive: Very Small (max 360px) ── */
@media (max-width: 360px) {
    .chatbox-contact-page .chatbox-hero-title {
        font-size: 1.6rem;
    }

    .chatbox-contact-page .chatbox-section-title {
        font-size: 1.3rem;
    }

    .chatbox-contact-page .chatbox-form-wrapper {
        padding: 16px;
    }

    .chatbox-contact-page .chatbox-input-wrap input,
    .chatbox-contact-page .chatbox-input-wrap textarea {
        padding: 10px 12px 10px 36px;
        font-size: 13px;
    }

    .chatbox-contact-page .chatbox-input-icon {
        left: 12px;
        font-size: 12px;
    }

    .chatbox-contact-page .chatbox-info-card {
        padding: 14px;
        gap: 12px;
    }

    .chatbox-contact-page .chatbox-info-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
    }

    .chatbox-contact-page .chatbox-info-icon-box i {
        font-size: 17px;
    }
}

/* ── Reduced Motion ── */
@media (prefers-reduced-motion: reduce) {
    .chatbox-contact-page .chatbox-bubble,
    .chatbox-contact-page .chatbox-hero-shape,
    .chatbox-contact-page .chatbox-cta-shape {
        animation: none;
        display: none;
    }

    .chatbox-contact-page .chatbox-fade-up {
        opacity: 1;
        transform: none;
        transition: none;
    }

    .chatbox-contact-page .chatbox-submit-btn:hover:not(:disabled) {
        transform: none;
    }

    .chatbox-contact-page .chatbox-info-card:hover {
        transform: none;
    }

    .chatbox-contact-page .chatbox-social-link:hover {
        transform: none;
    }
}

/* ── Dark mode support via prefers-color-scheme ── */
@media (prefers-color-scheme: dark) {
    .chatbox-contact-page {
        --cp-bg: #0b1120;
        --cp-card-bg: #131d33;
        --cp-text: #f1f5f9;
        --cp-text-secondary: #94a3b8;
        --cp-text-muted: #64748b;
        --cp-border: rgba(255, 255, 255, 0.06);
        --cp-shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
        --cp-shadow-hover: 0 12px 48px rgba(0, 0, 0, 0.4);
    }

    .chatbox-contact-page .chatbox-section-title {
        background: linear-gradient(135deg, #f1f5f9 0%, #60A5FA 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .chatbox-contact-page .chatbox-input-wrap input,
    .chatbox-contact-page .chatbox-input-wrap textarea {
        background: #0f1a2e;
        border-color: rgba(255, 255, 255, 0.08);
        color: #f1f5f9;
    }

    .chatbox-contact-page .chatbox-input-wrap input:focus,
    .chatbox-contact-page .chatbox-input-wrap textarea:focus {
        background: #131d33;
        border-color: #2563EB;
    }

    .chatbox-contact-page .chatbox-input-wrap.chatbox-valid input,
    .chatbox-contact-page .chatbox-input-wrap.chatbox-valid textarea {
        background: rgba(16, 185, 129, 0.08);
        border-color: #10b981;
    }

    .chatbox-contact-page .chatbox-input-wrap.chatbox-invalid input,
    .chatbox-contact-page .chatbox-input-wrap.chatbox-invalid textarea {
        background: rgba(239, 68, 68, 0.08);
        border-color: #ef4444;
    }

    .chatbox-contact-page .chatbox-form-group label {
        color: #e2e8f0;
    }

    .chatbox-contact-page .chatbox-info-text h5 {
        color: #f1f5f9;
    }

    .chatbox-contact-page .chatbox-info-text p {
        color: #94a3b8;
    }

    .chatbox-contact-page .chatbox-social-link {
        background: rgba(255, 255, 255, 0.06);
        color: #94a3b8;
    }

    .chatbox-contact-page .chatbox-hours-row {
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .chatbox-contact-page .chatbox-hours-value {
        color: #e2e8f0;
    }

    .chatbox-contact-page .chatbox-toast {
        background: #131d33;
        color: #f1f5f9;
        border-color: rgba(255, 255, 255, 0.08);
    }

    .chatbox-contact-page .chatbox-toast-title {
        color: #f1f5f9;
    }

    .chatbox-contact-page .chatbox-toast-message {
        color: #94a3b8;
    }

    .chatbox-contact-page .chatbox-form-wrapper::before {
        background: linear-gradient(90deg, #2563EB, #7C3AED, #059669);
    }
}
</style>

@endsection