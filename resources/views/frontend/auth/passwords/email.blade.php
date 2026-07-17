<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password — Connectly</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>

<div class="clp-page">

    {{-- Background Orbs --}}
    <div class="clp-orb clp-orb-1"></div>
    <div class="clp-orb clp-orb-2"></div>
    <div class="clp-orb clp-orb-3"></div>
    <div class="clp-orb clp-orb-4"></div>

    {{-- Grid Overlay --}}
    <div class="clp-grid"></div>

    {{-- Floating Particles --}}
    <div class="clp-particles" id="clpParticles"></div>

    {{-- Main Content --}}
    <div class="clp-wrap">

        {{-- Left: Brand --}}
        <div class="clp-brand">
            <div class="clp-brand-inner">
                <div class="clp-badge">Forgot Password</div>
                <a href="/" class="clp-logo">
                    <div class="clp-logo-icon"><i class="bi bi-diagram-3-fill"></i></div>
                    <span class="clp-logo-text">Connectly</span>
                </a>
                <p class="clp-tagline">We'll help you get back into your account.</p>

                <div class="clp-features">
                    <div class="clp-ft">
                        <i class="bi bi-shield-check"></i>
                        <span>Secure password reset</span>
                    </div>
                    <div class="clp-ft">
                        <i class="bi bi-envelope-fill"></i>
                        <span>Instant email delivery</span>
                    </div>
                    <div class="clp-ft">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Quick account recovery</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Card --}}
        <div class="clp-card-wrap">
            <div class="clp-card">

                {{-- Header --}}
                <div class="clp-card-hd">
                    <a href="/" class="clp-mobile-brand" aria-label="Connectly Home">
                        <div class="clp-mobile-brand-icon">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <span class="clp-mobile-brand-name">Connectly</span>
                    </a>
                    <div class="clp-card-ico">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <h2 class="clp-card-title">Reset Password</h2>
                    <p class="clp-card-sub">Enter your email to receive a reset link.</p>
                </div>

                {{-- Body --}}
                <div class="clp-card-body">

                    @if (session('status'))
                        <div class="clp-alert clp-alert-ok">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="clp-fg">
                            <label class="clp-label" for="email">Email</label>
                            <div class="clp-iw">
                                <i class="bi bi-envelope-fill clp-ico"></i>
                                <input id="email" type="email"
                                       class="clp-input @error('email') clp-err @enderror"
                                       name="email"
                                       placeholder="you@example.com"
                                       value="{{ old('email') }}"
                                       required autofocus>
                                <div class="clp-glow"></div>
                            </div>
                            @error('email')
                                <span class="clp-err-txt">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="clp-btn" id="clpBtn">
                            <span class="clp-btn-txt">Send Reset Link</span>
                            <span class="clp-btn-ldr"><i class="bi bi-arrow-right"></i></span>
                            <div class="clp-btn-shine"></div>
                        </button>
                    </form>

                    <div class="clp-back">
                        <a href="{{ route('login') }}" class="clp-back-link">
                            <i class="bi bi-arrow-left"></i> Back to Sign In
                        </a>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="clp-card-ft">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Your data is encrypted and secure.</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Particles
    const pc = document.getElementById('clpParticles');
    if (pc) {
        for (let i = 0; i < 25; i++) {
            const p = document.createElement('div');
            p.className = 'clp-p';
            const s = Math.random() * 4 + 2;
            p.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*100}%;animation-duration:${Math.random()*15+12}s;animation-delay:${Math.random()*6}s;bottom:-10px;opacity:${Math.random()*0.4+0.15}`;
            pc.appendChild(p);
        }
    }

    // Entrance animations
    setTimeout(() => { document.querySelector('.clp-card')?.classList.add('clp-card-vis'); }, 100);
    setTimeout(() => { document.querySelector('.clp-brand-inner')?.classList.add('clp-brand-vis'); }, 300);

    // Input focus
    document.querySelectorAll('.clp-iw').forEach(w => {
        const inp = w.querySelector('.clp-input');
        const ico = w.querySelector('.clp-ico');
        if (inp && ico) {
            inp.addEventListener('focus', () => { w.classList.add('clp-iw-focus'); ico.style.color = '#2563EB'; ico.style.transform = 'translateY(-50%) scale(1.15)'; });
            inp.addEventListener('blur', () => { w.classList.remove('clp-iw-focus'); ico.style.color = '#64748b'; ico.style.transform = 'translateY(-50%) scale(1)'; });
        }
    });

    // Submit
    const f = document.getElementById('clpBtn');
    if (f) {
        f.addEventListener('click', function() {
            this.disabled = true;
            this.querySelector('.clp-btn-txt').textContent = 'Sending...';
            this.querySelector('.clp-btn-ldr').innerHTML = '<div class="clp-spin"></div>';
        });
    }

    // Mouse glow
    const c = document.querySelector('.clp-card');
    if (c) {
        c.addEventListener('mousemove', function(e) {
            const r = this.getBoundingClientRect();
            this.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100) + '%');
            this.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100) + '%');
        });
    }
});
</script>

<style>
* { margin:0; padding:0; box-sizing:border-box; }

.clp-page {
    --p: #2563EB; --pl: #60A5FA; --pd: #1E40AF;
    --bg: #0b1121; --card: rgba(255,255,255,0.04);
    --bd: rgba(255,255,255,0.06);
    --txt: #f1f5f9; --mt: #94a3b8;
    --ibg: rgba(255,255,255,0.05); --ibd: rgba(255,255,255,0.08);
    --fc: rgba(37,99,235,0.25);
    font-family: 'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
    background: var(--bg); color: var(--txt);
    min-height:100vh; min-height:100dvh;
    display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden;
}

/* Orbs */
.clp-orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; }
.clp-orb-1 { width:500px; height:500px; background:radial-gradient(circle,rgba(37,99,235,0.1),transparent 70%); top:-180px; left:-120px; animation:clp-o1 14s ease-in-out infinite; }
.clp-orb-2 { width:400px; height:400px; background:radial-gradient(circle,rgba(96,165,250,0.07),transparent 70%); bottom:-120px; right:-80px; animation:clp-o2 16s ease-in-out infinite; }
.clp-orb-3 { width:300px; height:300px; background:radial-gradient(circle,rgba(30,64,175,0.08),transparent 70%); top:40%; left:50%; animation:clp-o3 18s ease-in-out infinite; }
.clp-orb-4 { width:250px; height:250px; background:radial-gradient(circle,rgba(37,99,235,0.05),transparent 70%); bottom:20%; left:25%; animation:clp-o1 20s ease-in-out infinite reverse; }
@keyframes clp-o1 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(60px,40px) scale(1.1); } }
@keyframes clp-o2 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(-40px,-60px) scale(1.08); } }
@keyframes clp-o3 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(30px,-30px) scale(1.12); } }

/* Grid */
.clp-grid { position:fixed; inset:0; background-image:linear-gradient(rgba(37,99,235,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(37,99,235,0.025) 1px,transparent 1px); background-size:50px 50px; pointer-events:none; z-index:1; mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); -webkit-mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); }

/* Particles */
.clp-particles { position:fixed; inset:0; overflow:hidden; pointer-events:none; z-index:1; }
.clp-p { position:absolute; background:linear-gradient(135deg,var(--p),var(--pl)); border-radius:50%; animation:clp-rise linear infinite; }
@keyframes clp-rise { 0% { transform:translateY(0) rotate(0deg); opacity:0; } 10% { opacity:0.35; } 90% { opacity:0.1; } 100% { transform:translateY(-100vh) rotate(360deg); opacity:0; } }

/* Layout */
.clp-wrap { position:relative; z-index:10; display:flex; align-items:center; justify-content:center; gap:50px; width:100%; max-width:1050px; padding:32px 20px; min-height:100vh; min-height:100dvh; }

/* Brand */
.clp-brand { flex:1; max-width:400px; display:flex; align-items:center; justify-content:center; }
.clp-brand-inner { opacity:0; transform:translateX(-30px); transition:all 0.8s cubic-bezier(.16,1,.3,1); }
.clp-brand-inner.clp-brand-vis { opacity:1; transform:translateX(0); }
.clp-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.15); border-radius:999px; font-size:0.78rem; font-weight:600; color:var(--pl); margin-bottom:20px; letter-spacing:0.3px; }
.clp-badge::before { content:''; width:5px; height:5px; border-radius:50%; background:#22c55e; animation:clp-pulse 2s ease-in-out infinite; }
@keyframes clp-pulse { 0%,100% { box-shadow:0 0 0 0 rgba(34,197,94,0.6); } 50% { box-shadow:0 0 0 5px rgba(34,197,94,0); } }
.clp-logo { display:flex; align-items:center; gap:10px; text-decoration:none; margin-bottom:12px; }
.clp-logo-icon { width:44px; height:44px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--p),var(--pd)); border-radius:12px; font-size:1.35rem; color:#fff; box-shadow:0 6px 20px rgba(37,99,235,0.3); }
.clp-logo-text { font-size:1.8rem; font-weight:800; background:linear-gradient(135deg,var(--pl),var(--p)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.5px; }
.clp-tagline { font-size:1.05rem; color:var(--mt); margin-bottom:28px; line-height:1.6; }
.clp-features { display:flex; flex-direction:column; gap:12px; }
.clp-ft { display:flex; align-items:center; gap:12px; font-size:0.9rem; color:var(--mt); transition:all 0.3s ease; cursor:default; }
.clp-ft:hover { color:var(--txt); transform:translateX(4px); }
.clp-ft i { font-size:1.1rem; color:var(--p); width:24px; text-align:center; }

/* Card */
.clp-card-wrap { flex:1; max-width:420px; display:flex; align-items:center; justify-content:center; }
.clp-card {
    --mx:50%; --my:50%;
    width:100%; background:var(--card);
    backdrop-filter:blur(24px) saturate(180%); -webkit-backdrop-filter:blur(24px) saturate(180%);
    border:1px solid var(--bd); border-radius:24px;
    padding:36px 32px; position:relative; overflow:hidden;
    transition:all 0.6s cubic-bezier(.16,1,.3,1);
    opacity:0; transform:translateY(30px) scale(0.97);
}
.clp-card.clp-card-vis { opacity:1; transform:translateY(0) scale(1); }

/* Animated gradient border */
.clp-card::before {
    content:''; position:absolute; inset:-1px; border-radius:24px; padding:1px;
    background:linear-gradient(135deg,rgba(37,99,235,0.3),rgba(96,165,250,0.1),rgba(37,99,235,0.05),rgba(96,165,250,0.2));
    background-size:300% 300%;
    -webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);
    -webkit-mask-composite:xor; mask-composite:exclude;
    animation:clp-border 6s ease-in-out infinite;
    pointer-events:none; z-index:0; opacity:0.6; transition:opacity 0.4s ease;
}
.clp-card:hover::before { opacity:1; }
@keyframes clp-border { 0%,100% { background-position:0% 50%; } 50% { background-position:100% 50%; } }

.clp-card::after {
    content:''; position:absolute; top:var(--my); left:var(--mx);
    transform:translate(-50%,-50%); width:400px; height:400px;
    background:radial-gradient(circle,rgba(37,99,235,0.06),transparent 70%);
    border-radius:50%; pointer-events:none; z-index:0; transition:all 0.3s ease;
}
.clp-card:hover { border-color:rgba(37,99,235,0.15); box-shadow:0 20px 60px rgba(0,0,0,0.3); transform:translateY(-2px); }

/* Header */
.clp-card-hd { text-align:center; margin-bottom:28px; position:relative; z-index:1; }
.clp-card-ico { width:52px; height:52px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(37,99,235,0.05)); border:1px solid rgba(37,99,235,0.15); border-radius:16px; margin:0 auto 14px; font-size:1.4rem; color:var(--pl); animation:clp-ico-pulse 3s ease-in-out infinite; }
@keyframes clp-ico-pulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.05); } }
.clp-card-title { font-size:1.5rem; font-weight:800; color:var(--txt); margin-bottom:6px; letter-spacing:-0.3px; }
.clp-card-sub { font-size:0.88rem; color:var(--mt); }

/* Body */
.clp-card-body { position:relative; z-index:1; }

/* Alert */
.clp-alert { padding:12px 14px; border-radius:12px; font-size:0.85rem; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
.clp-alert-ok { background:rgba(16,185,129,0.1); color:#10b981; border:1px solid rgba(16,185,129,0.15); }

/* Form */
.clp-fg { margin-bottom:20px; }
.clp-label { display:block; font-size:0.82rem; font-weight:600; color:var(--txt); margin-bottom:7px; letter-spacing:0.2px; }
.clp-iw { position:relative; border-radius:12px; overflow:hidden; }
.clp-ico { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748b; z-index:2; font-size:1rem; transition:all 0.3s cubic-bezier(.16,1,.3,1); }
.clp-input { width:100%; padding:13px 42px 13px 44px; background:var(--ibg); border:1.5px solid var(--ibd); border-radius:12px; font-family:'Inter',sans-serif; font-size:0.92rem; color:var(--txt); outline:none; transition:all 0.3s cubic-bezier(.16,1,.3,1); position:relative; z-index:1; }
.clp-input::placeholder { color:#475569; }
.clp-input:focus { border-color:var(--p); background:rgba(37,99,235,0.05); box-shadow:0 0 0 4px var(--fc); }
.clp-err { border-color:#ef4444 !important; }
.clp-glow { position:absolute; inset:0; border-radius:12px; background:radial-gradient(circle at var(--mx,50%) var(--my,50%),rgba(37,99,235,0.08),transparent 60%); pointer-events:none; opacity:0; transition:opacity 0.3s ease; z-index:0; }
.clp-iw-focus .clp-glow { opacity:1; }
.clp-err-txt { display:block; color:#ef4444; font-size:0.78rem; margin-top:5px; font-weight:500; }

/* Button */
.clp-btn { width:100%; padding:14px 20px; background:linear-gradient(135deg,var(--p),var(--pd)); border:none; border-radius:12px; font-family:'Inter',sans-serif; font-size:0.95rem; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; position:relative; overflow:hidden; transition:all 0.4s cubic-bezier(.16,1,.3,1); box-shadow:0 4px 16px rgba(37,99,235,0.3); }
.clp-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(37,99,235,0.4); }
.clp-btn:active { transform:translateY(0); }
.clp-btn:disabled { opacity:0.7; cursor:not-allowed; transform:none; }
.clp-btn-shine { position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.15),transparent); transform:skewX(-20deg); transition:left 0.8s ease; }
.clp-btn:hover .clp-btn-shine { left:150%; }
.clp-btn-ldr { font-size:1.05rem; display:flex; align-items:center; }
.clp-btn:hover .clp-btn-ldr i { animation:clp-ba 1s ease infinite; }
@keyframes clp-ba { 0%,100% { transform:translateX(0); } 50% { transform:translateX(4px); } }
.clp-spin { width:16px; height:16px; border:2.5px solid rgba(255,255,255,0.3); border-top-color:#fff; border-radius:50%; animation:clp-sp 0.7s linear infinite; }
@keyframes clp-sp { to { transform:rotate(360deg); } }
@keyframes clp-icon-breathe {
    0%,100% { box-shadow:0 0 0 0 rgba(37,99,235,0.15), 0 4px 16px rgba(37,99,235,0.1); transform:scale(1); }
    50% { box-shadow:0 0 0 8px rgba(37,99,235,0.05), 0 4px 24px rgba(37,99,235,0.15); transform:scale(1.03); }
}
@keyframes clp-btn-glow-pulse {
    0%,100% { box-shadow:0 4px 16px rgba(37,99,235,0.3); }
    50% { box-shadow:0 4px 28px rgba(37,99,235,0.5), 0 0 40px rgba(37,99,235,0.1); }
}

.clp-mobile-brand { display:none; }

/* Back link */
.clp-back { text-align:center; margin-top:20px; }
.clp-back-link { display:inline-flex; align-items:center; gap:6px; font-size:0.85rem; font-weight:600; color:var(--mt); text-decoration:none; transition:all 0.3s ease; }
.clp-back-link:hover { color:var(--pl); gap:10px; }
.clp-back-link i { font-size:0.9rem; transition:transform 0.3s ease; }
.clp-back-link:hover i { transform:translateX(-3px); }

/* Footer */
.clp-card-ft { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:22px; padding-top:18px; border-top:1px solid rgba(255,255,255,0.05); position:relative; z-index:1; }
.clp-card-ft i { font-size:0.82rem; color:var(--p); }
.clp-card-ft span { font-size:0.75rem; color:var(--mt); }

/* ===== RESPONSIVE ===== */
@media (max-width: 920px) {
    .clp-wrap { flex-direction:column; gap:28px; padding:20px 16px; min-height:auto; }
    .clp-brand { display:none; }
    .clp-card-wrap { max-width:100%; width:100%; max-width:440px; }
    .clp-card { padding:28px 22px; }
    .clp-mobile-brand {
        display:flex; align-items:center; justify-content:center; gap:8px;
        text-decoration:none; margin-bottom:20px; padding-bottom:20px;
        border-bottom:1px solid rgba(255,255,255,0.06);
    }
    .clp-mobile-brand-icon {
        width:32px; height:32px; display:flex; align-items:center; justify-content:center;
        background:linear-gradient(135deg,var(--p),var(--pd));
        border-radius:9px; font-size:1rem; color:#fff;
    }
    .clp-mobile-brand-name {
        font-size:1.1rem; font-weight:700;
        background:linear-gradient(135deg,var(--pl),var(--p));
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        background-clip:text; letter-spacing:-0.3px;
    }
}
@media (max-width: 480px) {
    .clp-page { min-height:100vh; min-height:100dvh; padding:0; display:flex; align-items:center; justify-content:center; }
    .clp-wrap { padding:20px 12px; gap:0; min-height:auto; }
    .clp-card { padding:28px 20px 24px; border-radius:22px; transform-origin:bottom center; }
    .clp-card::before { border-radius:22px; }
    .clp-mobile-brand { margin-bottom:16px; padding-bottom:16px; }
    .clp-mobile-brand-icon { width:28px; height:28px; font-size:0.85rem; border-radius:8px; }
    .clp-mobile-brand-name { font-size:1rem; }
    .clp-card-ico { width:50px; height:50px; font-size:1.25rem; border-radius:14px; margin-bottom:16px; animation:clp-icon-breathe 3s ease-in-out infinite; }
    .clp-card-title { font-size:1.35rem; margin-bottom:6px; }
    .clp-card-sub { font-size:0.85rem; }
    .clp-card-hd { margin-bottom:28px; }
    .clp-alert { font-size:0.82rem; padding:10px 12px; margin-bottom:18px; }
    .clp-fg { margin-bottom:18px; }
    .clp-label { font-size:0.82rem; margin-bottom:7px; }
    .clp-input { padding:13px 42px 13px 44px; font-size:0.9rem; border-radius:12px; }
    .clp-input:focus { border-color:var(--p); background:rgba(37,99,235,0.06); box-shadow:0 0 0 3px var(--fc), 0 0 20px rgba(37,99,235,0.08); }
    .clp-ico { left:14px; font-size:1rem; }
    .clp-btn { padding:14px 22px; font-size:0.95rem; border-radius:12px; animation:clp-btn-glow-pulse 3s ease-in-out infinite; }
    .clp-back { margin-top:18px; }
    .clp-back-link { font-size:0.85rem; }
    .clp-card-ft { flex-direction:column; text-align:center; gap:6px; margin-top:24px; padding-top:18px; }
    .clp-card-ft span { font-size:0.75rem; }
    .clp-orb-1 { width:300px; height:300px; top:-120px; left:-100px; }
    .clp-orb-2 { width:250px; height:250px; bottom:-100px; right:-80px; }
    .clp-orb-3,.clp-orb-4 { display:none; }
    .clp-particles { display:none; }
    .clp-grid { background-size:40px 40px; mask-image:none; -webkit-mask-image:none; }
}
@media (max-width: 375px) {
    .clp-wrap { padding:16px 12px; }
    .clp-card { padding:24px 16px 20px; border-radius:20px; }
    .clp-card::before { border-radius:20px; }
    .clp-mobile-brand { margin-bottom:14px; padding-bottom:14px; }
    .clp-mobile-brand-icon { width:26px; height:26px; font-size:0.8rem; border-radius:7px; }
    .clp-mobile-brand-name { font-size:0.95rem; }
    .clp-card-ico { width:44px; height:44px; font-size:1.1rem; border-radius:12px; margin-bottom:14px; }
    .clp-card-title { font-size:1.2rem; }
    .clp-card-sub { font-size:0.8rem; }
    .clp-card-hd { margin-bottom:24px; }
    .clp-fg { margin-bottom:16px; }
    .clp-label { font-size:0.8rem; }
    .clp-input { padding:11px 36px 11px 38px; font-size:0.86rem; border-radius:11px; }
    .clp-ico { left:10px; font-size:0.88rem; }
    .clp-btn { padding:12px 18px; font-size:0.9rem; border-radius:11px; }
    .clp-card-ft { margin-top:20px; padding-top:16px; }
    .clp-card-ft span { font-size:0.72rem; }
}
@media (max-width: 320px) {
    .clp-wrap { padding:12px 8px; }
    .clp-card { padding:20px 12px 16px; border-radius:18px; }
    .clp-card::before { border-radius:18px; }
    .clp-mobile-brand { margin-bottom:12px; padding-bottom:12px; }
    .clp-mobile-brand-icon { width:24px; height:24px; font-size:0.75rem; border-radius:6px; }
    .clp-mobile-brand-name { font-size:0.85rem; }
    .clp-card-ico { width:40px; height:40px; font-size:1rem; border-radius:11px; margin-bottom:12px; }
    .clp-card-title { font-size:1.05rem; }
    .clp-card-sub { font-size:0.76rem; }
    .clp-card-hd { margin-bottom:20px; }
    .clp-fg { margin-bottom:14px; }
    .clp-label { font-size:0.76rem; }
    .clp-input { padding:10px 32px 10px 34px; font-size:0.82rem; border-radius:10px; }
    .clp-ico { left:8px; font-size:0.82rem; }
    .clp-btn { padding:11px 16px; font-size:0.86rem; border-radius:10px; }
    .clp-card-ft { margin-top:16px; padding-top:14px; }
    .clp-card-ft span { font-size:0.68rem; }
}
@media (max-height: 600px) and (orientation: landscape) {
    .clp-wrap { padding:12px; gap:16px; }
    .clp-brand { display:none; }
    .clp-card { padding:16px 16px; border-radius:18px; }
    .clp-card::before { border-radius:18px; }
    .clp-card-hd { margin-bottom:14px; }
    .clp-card-ico { width:36px; height:36px; font-size:1rem; margin-bottom:8px; }
    .clp-card-title { font-size:1.1rem; }
    .clp-orb-1 { width:160px; height:160px; }
    .clp-orb-2 { width:140px; height:140px; }
    .clp-orb-3,.clp-orb-4 { display:none; }
    .clp-particles { display:none; }
}
@media (prefers-reduced-motion: reduce) {
    .clp-page *,.clp-page *::before,.clp-page *::after { animation-duration:0.01ms !important; animation-iteration-count:1 !important; transition-duration:0.01ms !important; }
    .clp-particles { display:none; }
    .clp-card { opacity:1; transform:none; }
    .clp-card::before { animation:none; opacity:0.3; }
    .clp-brand-inner { opacity:1; transform:none; }
}

/* Scrollbar */
::-webkit-scrollbar { width:6px; }
::-webkit-scrollbar-track { background:var(--bg); }
::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.08); border-radius:3px; }
::-webkit-scrollbar-thumb:hover { background:rgba(255,255,255,0.12); }
</style>
</body>
</html>