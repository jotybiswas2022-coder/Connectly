@extends('backend.app')

@section('content')

@if (session('success'))
    <input type="hidden" id="sessionSuccess" value="{{ session('success') }}">
@endif

<div class="account-page">

    {{-- BG Orbs --}}
    <div class="acc-orb acc-orb-1"></div>
    <div class="acc-orb acc-orb-2"></div>
    <div class="acc-orb acc-orb-3"></div>

    {{-- Particles --}}
    <div class="acc-particles" id="accParticles"></div>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Account</h1>
            <div class="sub">Manage your admin profile</div>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="acc-card animate-in">
        <div class="acc-card-bg-shine"></div>

        <div class="acc-profile">
            {{-- Avatar Section --}}
            <div class="acc-avatar-section">
                <div class="acc-avatar-ring">
                    <div class="acc-avatar-inner">
                        @if(isset($account) && $account->image)
                            <img src="{{ config('app.storage_url') }}{{ $account->image }}"
                                 alt="{{ $account->name ?? 'User' }}"
                                 class="acc-avatar-img">
                        @else
                            <div class="acc-avatar-fallback">
                                {{ isset($account->name) ? strtoupper(substr($account->name, 0, 1)) : 'A' }}
                            </div>
                        @endif
                    </div>
                    <div class="acc-ring-spinner"></div>
                </div>
                <div class="acc-online-dot"></div>
            </div>

            {{-- Info Section --}}
            <div class="acc-info">
                <h2 class="acc-name">{{ $account->name ?? 'Not set' }}</h2>

                <div class="acc-detail-grid">
                    <div class="acc-detail-item">
                        <div class="acc-detail-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <span class="acc-detail-label">Phone</span>
                            <span class="acc-detail-value">{{ $account->phone ?? 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="acc-detail-item">
                        <div class="acc-detail-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div>
                            <span class="acc-detail-label">Email</span>
                            <span class="acc-detail-value">{{ $account->email ?? 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="acc-detail-item">
                        <div class="acc-detail-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <div>
                            <span class="acc-detail-label">Website</span>
                            <span class="acc-detail-value">
                                @if(!empty($account->website))
                                    <a href="{{ $account->website }}" target="_blank" class="acc-link">{{ $account->website }}</a>
                                @else
                                    Not set
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="acc-actions">
                    <a href="{{ route('account.edit') }}" class="acc-btn acc-btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.account-page {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #0f172a;
    --clr-card: rgba(255,255,255,0.06);
    --clr-border: rgba(255,255,255,0.08);
    --clr-text: #f1f5f9;
    --clr-text-secondary: #94a3b8;
    --clr-success: #10b981;
    --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    --radius: 16px;
    --radius-sm: 10px;

    font-family: var(--font);
    color: var(--clr-text);
    -webkit-font-smoothing: antialiased;
    position: relative;
    max-width: 900px;
    margin: 0 auto;
    padding: 32px 28px 48px;
    min-height: calc(100vh - 80px);
    overflow: hidden;
    background: var(--clr-bg);
}

/* ── Orbs ── */
.acc-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
}
.acc-orb-1 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(37,99,235,0.25), transparent 70%);
    top: -100px; right: -100px;
    animation: accOrbFloat 8s ease-in-out infinite;
}
.acc-orb-2 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(96,165,250,0.2), transparent 70%);
    bottom: -80px; left: -80px;
    animation: accOrbFloat 10s ease-in-out infinite reverse;
}
.acc-orb-3 {
    width: 250px; height: 250px;
    background: radial-gradient(circle, rgba(30,64,175,0.15), transparent 70%);
    top: 40%; left: 50%;
    animation: accOrbFloat 12s ease-in-out infinite 2s;
}
@keyframes accOrbFloat {
    0%,100%{ transform: translate(0,0) scale(1); }
    33%{ transform: translate(30px,-30px) scale(1.1); }
    66%{ transform: translate(-20px,20px) scale(0.95); }
}

.acc-particles {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

.page-header {
    position: relative;
    z-index: 2;
    margin-bottom: 32px;
}
.page-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--clr-text);
    letter-spacing: -.02em;
    display: flex;
    align-items: center;
    gap: 12px;
}
.page-header h1::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 28px;
    background: linear-gradient(180deg, var(--clr-primary), var(--clr-light));
    border-radius: 4px;
}
.page-header .sub {
    font-size: .875rem;
    color: var(--clr-text-secondary);
    margin-top: 4px;
    padding-left: 16px;
}

.acc-card {
    position: relative;
    z-index: 2;
    background: var(--clr-card);
    backdrop-filter: blur(24px) saturate(1.4);
    -webkit-backdrop-filter: blur(24px) saturate(1.4);
    border: 1px solid var(--clr-border);
    border-radius: var(--radius);
    padding: 40px 36px;
    overflow: hidden;
    transition: transform .3s ease, box-shadow .3s ease;
}
.acc-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(37,99,235,0.1);
}
.acc-card-bg-shine {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 20%, rgba(96,165,250,0.06), transparent 60%);
    pointer-events: none;
}

.acc-profile {
    display: flex;
    align-items: flex-start;
    gap: 40px;
    position: relative;
    z-index: 1;
}

.acc-avatar-section {
    position: relative;
    flex-shrink: 0;
}
.acc-avatar-ring {
    position: relative;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    padding: 4px;
    background: conic-gradient(var(--clr-primary), var(--clr-light), var(--clr-dark), var(--clr-primary));
    animation: accRingSpin 4s linear infinite;
}
@keyframes accRingSpin {
    to { transform: rotate(360deg); }
}
.acc-avatar-inner {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    background: var(--clr-bg);
    display: flex;
    align-items: center;
    justify-content: center;
}
.acc-avatar-img { width: 100%; height: 100%; object-fit: cover; }
.acc-avatar-fallback { font-size: 3rem; font-weight: 700; color: var(--clr-light); }
.acc-ring-spinner { display: none; }
.acc-online-dot {
    position: absolute;
    bottom: 6px; right: 6px;
    width: 18px; height: 18px;
    background: var(--clr-success);
    border: 3px solid var(--clr-bg);
    border-radius: 50%;
    animation: accPulse 2s ease-in-out infinite;
}
@keyframes accPulse {
    0%,100%{ box-shadow: 0 0 0 0 rgba(16,185,129,0.5); }
    50%{ box-shadow: 0 0 0 8px rgba(16,185,129,0); }
}

.acc-info { flex: 1; min-width: 0; }
.acc-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--clr-text);
    margin-bottom: 24px;
    letter-spacing: -.02em;
}

.acc-detail-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 28px;
}
.acc-detail-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px;
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--clr-border);
    border-radius: var(--radius-sm);
    transition: all .25s ease;
}
.acc-detail-item:hover {
    background: rgba(255,255,255,0.07);
    border-color: rgba(96,165,250,0.2);
    transform: translateX(4px);
}
.acc-detail-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(96,165,250,0.15));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--clr-light);
    flex-shrink: 0;
}
.acc-detail-icon svg { width: 18px; height: 18px; }
.acc-detail-label {
    display: block;
    font-size: .7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--clr-text-secondary);
    margin-bottom: 2px;
}
.acc-detail-value {
    display: block;
    font-size: .9rem;
    font-weight: 500;
    color: var(--clr-text);
    word-break: break-word;
}
.acc-link { color: var(--clr-light); text-decoration: none; transition: color .2s; }
.acc-link:hover { color: #93c5fd; text-decoration: underline; }

.acc-actions { display: flex; gap: 12px; }
.acc-btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 28px;
    border-radius: 50px;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .25s ease;
    cursor: pointer;
    border: none;
    font-family: var(--font);
}
.acc-btn-primary {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}
.acc-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(37,99,235,0.45);
    color: #fff;
}
.acc-btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(37,99,235,0.2);
}

.animate-in {
    animation: accFadeUp .6s cubic-bezier(.16,1,.3,1) forwards;
    opacity: 0;
}
@keyframes accFadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
    .account-page { padding: 20px 16px 36px; }
    .page-header h1 { font-size: 1.35rem; }
    .acc-card { padding: 28px 20px; }
    .acc-profile { flex-direction: column; align-items: center; gap: 24px; }
    .acc-avatar-ring { width: 100px; height: 100px; }
    .acc-avatar-fallback { font-size: 2.2rem; }
    .acc-name { text-align: center; font-size: 1.25rem; }
    .acc-detail-item:hover { transform: none; }
    .acc-actions { justify-content: center; }
}

::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.3); border-radius: 10px; }
::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,0.5); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var sessionSuccess = document.getElementById('sessionSuccess');
    if (sessionSuccess) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: sessionSuccess.value,
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#1e293b',
            color: '#4ade80',
            iconColor: '#22c55e',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }

    const container = document.getElementById('accParticles');
    if (container) {
        for (let i = 0; i < 20; i++) {
            const p = document.createElement('div');
            const size = Math.random() * 3 + 1;
            const x = Math.random() * 100;
            const y = Math.random() * 100;
            const duration = Math.random() * 6 + 4;
            const delay = Math.random() * 4;
            p.style.cssText = 'position:absolute;width:'+size+'px;height:'+size+'px;background:rgba(96,165,250,'+(Math.random()*0.3+0.1)+');border-radius:50%;left:'+x+'%;top:'+y+'%;animation:accPartFloat '+duration+'s ease-in-out '+delay+'s infinite;pointer-events:none;';
            container.appendChild(p);
        }
    }
});
</script>
<style>
@keyframes accPartFloat {
    0%,100%{ transform: translateY(0) scale(1); opacity:0.3; }
    50%{ transform: translateY(-30px) scale(1.2); opacity:0.8; }
}
</style>

@endsection
