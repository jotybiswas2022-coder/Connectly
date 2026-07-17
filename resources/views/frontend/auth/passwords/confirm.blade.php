<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirm Password — Connectly</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>

<div class="clc-page">

    {{-- Orbs --}}
    <div class="clc-orb clc-orb-1"></div>
    <div class="clc-orb clc-orb-2"></div>
    <div class="clc-orb clc-orb-3"></div>
    <div class="clc-orb clc-orb-4"></div>

    {{-- Grid --}}
    <div class="clc-grid"></div>

    {{-- Particles --}}
    <div class="clc-particles" id="clcParticles"></div>

    {{-- Main --}}
    <div class="clc-wrap">

        {{-- Left: Brand --}}
        <div class="clc-brand">
            <div class="clc-brand-inner">
                <div class="clc-badge">Security Check</div>
                <a href="/" class="clc-logo">
                    <div class="clc-logo-icon"><i class="bi bi-diagram-3-fill"></i></div>
                    <span class="clc-logo-text">Connectly</span>
                </a>
                <p class="clc-tagline">One more step to keep your account secure.</p>
                <div class="clc-features">
                    <div class="clc-ft"><i class="bi bi-shield-check"></i><span>Two-factor protection</span></div>
                    <div class="clc-ft"><i class="bi bi-lock-fill"></i><span>Encrypted session</span></div>
                    <div class="clc-ft"><i class="bi bi-clock-fill"></i><span>Session timeout: 15 min</span></div>
                </div>
            </div>
        </div>

        {{-- Right: Card --}}
        <div class="clc-card-wrap">
            <div class="clc-card">

                {{-- Header --}}
                <div class="clc-card-hd">
                    <a href="/" class="clc-mobile-brand" aria-label="Connectly Home">
                        <div class="clc-mobile-brand-icon">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <span class="clc-mobile-brand-name">Connectly</span>
                    </a>
                    <div class="clc-card-ico">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h2 class="clc-card-title">{{ __('Confirm Password') }}</h2>
                    <p class="clc-card-sub">{{ __('Please confirm your password before continuing.') }}</p>
                </div>

                {{-- Body --}}
                <div class="clc-card-body">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="clc-fg">
                            <label class="clc-label" for="password">{{ __('Password') }}</label>
                            <div class="clc-iw">
                                <i class="bi bi-lock-fill clc-ico"></i>
                                <input id="password" type="password"
                                       class="clc-input @error('password') clc-err @enderror"
                                       name="password" required autocomplete="current-password"
                                       placeholder="Enter your password">
                                <div class="clc-glow"></div>
                            </div>
                            @error('password')
                                <span class="clc-err-txt">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="clc-btn">
                            <span class="clc-btn-txt">{{ __('Confirm Password') }}</span>
                            <span class="clc-btn-ldr"><i class="bi bi-arrow-right"></i></span>
                            <div class="clc-btn-shine"></div>
                        </button>

                        @if (Route::has('password.request'))
                            <div class="clc-back">
                                <a href="{{ route('password.request') }}" class="clc-back-link">
                                    <i class="bi bi-question-circle"></i> {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                {{-- Footer --}}
                <div class="clc-card-ft">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>{{ __('Your data is encrypted and secure.') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pc = document.getElementById('clcParticles');
    if (pc) {
        for (let i = 0; i < 25; i++) {
            const p = document.createElement('div');
            p.className = 'clc-p';
            const s = Math.random() * 4 + 2;
            p.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*100}%;animation-duration:${Math.random()*15+12}s;animation-delay:${Math.random()*6}s;bottom:-10px;opacity:${Math.random()*0.4+0.15}`;
            pc.appendChild(p);
        }
    }
    setTimeout(() => { document.querySelector('.clc-card')?.classList.add('clc-card-vis'); }, 100);
    setTimeout(() => { document.querySelector('.clc-brand-inner')?.classList.add('clc-brand-vis'); }, 300);

    document.querySelectorAll('.clc-iw').forEach(w => {
        const inp = w.querySelector('.clc-input');
        const ico = w.querySelector('.clc-ico');
        if (inp && ico) {
            inp.addEventListener('focus', () => { w.classList.add('clc-iw-focus'); ico.style.color = '#2563EB'; ico.style.transform = 'translateY(-50%) scale(1.15)'; });
            inp.addEventListener('blur', () => { w.classList.remove('clc-iw-focus'); ico.style.color = '#64748b'; ico.style.transform = 'translateY(-50%) scale(1)'; });
        }
    });

    const c = document.querySelector('.clc-card');
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
.clc-page {
    --p:#2563EB; --pl:#60A5FA; --pd:#1E40AF;
    --bg:#0b1121; --card:rgba(255,255,255,0.04); --bd:rgba(255,255,255,0.06);
    --txt:#f1f5f9; --mt:#94a3b8;
    --ibg:rgba(255,255,255,0.05); --ibd:rgba(255,255,255,0.08);
    --fc:rgba(37,99,235,0.25);
    font-family: 'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
    background:var(--bg); color:var(--txt);
    min-height:100vh; min-height:100dvh;
    display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden;
}
.clc-orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; }
.clc-orb-1 { width:500px;height:500px;background:radial-gradient(circle,rgba(37,99,235,0.1),transparent 70%);top:-180px;left:-120px;animation:clc-o1 14s ease-in-out infinite; }
.clc-orb-2 { width:400px;height:400px;background:radial-gradient(circle,rgba(96,165,250,0.07),transparent 70%);bottom:-120px;right:-80px;animation:clc-o2 16s ease-in-out infinite; }
.clc-orb-3 { width:300px;height:300px;background:radial-gradient(circle,rgba(30,64,175,0.08),transparent 70%);top:40%;left:50%;animation:clc-o3 18s ease-in-out infinite; }
.clc-orb-4 { width:250px;height:250px;background:radial-gradient(circle,rgba(37,99,235,0.05),transparent 70%);bottom:20%;left:25%;animation:clc-o1 20s ease-in-out infinite reverse; }
@keyframes clc-o1 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(60px,40px) scale(1.1); } }
@keyframes clc-o2 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(-40px,-60px) scale(1.08); } }
@keyframes clc-o3 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(30px,-30px) scale(1.12); } }
.clc-grid { position:fixed; inset:0; background-image:linear-gradient(rgba(37,99,235,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(37,99,235,0.025) 1px,transparent 1px); background-size:50px 50px; pointer-events:none; z-index:1; mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); -webkit-mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); }
.clc-particles { position:fixed; inset:0; overflow:hidden; pointer-events:none; z-index:1; }
.clc-p { position:absolute; background:linear-gradient(135deg,var(--p),var(--pl)); border-radius:50%; animation:clc-rise linear infinite; }
@keyframes clc-rise { 0% { transform:translateY(0) rotate(0deg); opacity:0; } 10% { opacity:0.35; } 90% { opacity:0.1; } 100% { transform:translateY(-100vh) rotate(360deg); opacity:0; } }
.clc-wrap { position:relative; z-index:10; display:flex; align-items:center; justify-content:center; gap:50px; width:100%; max-width:1050px; padding:32px 20px; min-height:100vh; min-height:100dvh; }

/* Brand */
.clc-brand { flex:1; max-width:400px; display:flex; align-items:center; justify-content:center; }
.clc-brand-inner { opacity:0; transform:translateX(-30px); transition:all 0.8s cubic-bezier(.16,1,.3,1); }
.clc-brand-inner.clc-brand-vis { opacity:1; transform:translateX(0); }
.clc-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.15); border-radius:999px; font-size:0.78rem; font-weight:600; color:var(--pl); margin-bottom:20px; letter-spacing:0.3px; }
.clc-badge::before { content:''; width:5px; height:5px; border-radius:50%; background:#22c55e; animation:clc-pulse 2s ease-in-out infinite; }
@keyframes clc-pulse { 0%,100% { box-shadow:0 0 0 0 rgba(34,197,94,0.6); } 50% { box-shadow:0 0 0 5px rgba(34,197,94,0); } }
.clc-logo { display:flex; align-items:center; gap:10px; text-decoration:none; margin-bottom:12px; }
.clc-logo-icon { width:44px; height:44px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--p),var(--pd)); border-radius:12px; font-size:1.35rem; color:#fff; box-shadow:0 6px 20px rgba(37,99,235,0.3); }
.clc-logo-text { font-size:1.8rem; font-weight:800; background:linear-gradient(135deg,var(--pl),var(--p)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.5px; }
.clc-tagline { font-size:1.05rem; color:var(--mt); margin-bottom:28px; line-height:1.6; }
.clc-features { display:flex; flex-direction:column; gap:12px; }
.clc-ft { display:flex; align-items:center; gap:12px; font-size:0.9rem; color:var(--mt); transition:all 0.3s ease; cursor:default; }
.clc-ft:hover { color:var(--txt); transform:translateX(4px); }
.clc-ft i { font-size:1.1rem; color:var(--p); width:24px; text-align:center; }

/* Card */
.clc-card-wrap { flex:1; max-width:420px; display:flex; align-items:center; justify-content:center; }
.clc-card { --mx:50%; --my:50%; width:100%; background:var(--card); backdrop-filter:blur(24px) saturate(180%); -webkit-backdrop-filter:blur(24px) saturate(180%); border:1px solid var(--bd); border-radius:24px; padding:36px 32px; position:relative; overflow:hidden; transition:all 0.6s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(30px) scale(0.97); }
.clc-card.clc-card-vis { opacity:1; transform:translateY(0) scale(1); }
.clc-card::before { content:''; position:absolute; inset:-1px; border-radius:24px; padding:1px; background:linear-gradient(135deg,rgba(37,99,235,0.3),rgba(96,165,250,0.1),rgba(37,99,235,0.05),rgba(96,165,250,0.2)); background-size:300% 300%; -webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0); -webkit-mask-composite:xor; mask-composite:exclude; animation:clc-border 6s ease-in-out infinite; pointer-events:none; z-index:0; opacity:0.6; transition:opacity 0.4s ease; }
.clc-card:hover::before { opacity:1; }
@keyframes clc-border { 0%,100% { background-position:0% 50%; } 50% { background-position:100% 50%; } }
.clc-card::after { content:''; position:absolute; top:var(--my); left:var(--mx); transform:translate(-50%,-50%); width:400px; height:400px; background:radial-gradient(circle,rgba(37,99,235,0.06),transparent 70%); border-radius:50%; pointer-events:none; z-index:0; transition:all 0.3s ease; }
.clc-card:hover { border-color:rgba(37,99,235,0.15); box-shadow:0 20px 60px rgba(0,0,0,0.3); transform:translateY(-2px); }
.clc-card-hd { text-align:center; margin-bottom:28px; position:relative; z-index:1; }
.clc-card-ico { width:52px; height:52px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(37,99,235,0.05)); border:1px solid rgba(37,99,235,0.15); border-radius:16px; margin:0 auto 14px; font-size:1.4rem; color:var(--pl); animation:clc-ico-pulse 3s ease-in-out infinite; }
@keyframes clc-ico-pulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.05); } }
.clc-card-title { font-size:1.5rem; font-weight:800; color:var(--txt); margin-bottom:6px; letter-spacing:-0.3px; }
.clc-card-sub { font-size:0.88rem; color:var(--mt); }
.clc-card-body { position:relative; z-index:1; }

/* Form */
.clc-fg { margin-bottom:20px; }
.clc-label { display:block; font-size:0.82rem; font-weight:600; color:var(--txt); margin-bottom:7px; letter-spacing:0.2px; }
.clc-iw { position:relative; border-radius:12px; overflow:hidden; }
.clc-ico { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748b; z-index:2; font-size:1rem; transition:all 0.3s cubic-bezier(.16,1,.3,1); }
.clc-input { width:100%; padding:13px 42px 13px 44px; background:var(--ibg); border:1.5px solid var(--ibd); border-radius:12px; font-family:'Inter',sans-serif; font-size:0.92rem; color:var(--txt); outline:none; transition:all 0.3s cubic-bezier(.16,1,.3,1); position:relative; z-index:1; }
.clc-input::placeholder { color:#475569; }
.clc-input:focus { border-color:var(--p); background:rgba(37,99,235,0.05); box-shadow:0 0 0 4px var(--fc); }
.clc-err { border-color:#ef4444 !important; }
.clc-glow { position:absolute; inset:0; border-radius:12px; background:radial-gradient(circle at var(--mx,50%) var(--my,50%),rgba(37,99,235,0.08),transparent 60%); pointer-events:none; opacity:0; transition:opacity 0.3s ease; z-index:0; }
.clc-iw-focus .clc-glow { opacity:1; }
.clc-err-txt { display:block; color:#ef4444; font-size:0.78rem; margin-top:5px; font-weight:500; }

/* Button */
.clc-btn { width:100%; padding:14px 20px; background:linear-gradient(135deg,var(--p),var(--pd)); border:none; border-radius:12px; font-family:'Inter',sans-serif; font-size:0.95rem; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; position:relative; overflow:hidden; transition:all 0.4s cubic-bezier(.16,1,.3,1); box-shadow:0 4px 16px rgba(37,99,235,0.3); }
.clc-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(37,99,235,0.4); }
.clc-btn:active { transform:translateY(0); }
.clc-btn:disabled { opacity:0.7; cursor:not-allowed; transform:none; }
.clc-btn-shine { position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.15),transparent); transform:skewX(-20deg); transition:left 0.8s ease; }
.clc-btn:hover .clc-btn-shine { left:150%; }
.clc-btn-ldr { font-size:1.05rem; display:flex; align-items:center; }
.clc-btn:hover .clc-btn-ldr i { animation:clc-ba 1s ease infinite; }
@keyframes clc-ba { 0%,100% { transform:translateX(0); } 50% { transform:translateX(4px); } }
@keyframes clc-icon-breathe {
    0%,100% { box-shadow:0 0 0 0 rgba(37,99,235,0.15), 0 4px 16px rgba(37,99,235,0.1); transform:scale(1); }
    50% { box-shadow:0 0 0 8px rgba(37,99,235,0.05), 0 4px 24px rgba(37,99,235,0.15); transform:scale(1.03); }
}
@keyframes clc-btn-glow-pulse {
    0%,100% { box-shadow:0 4px 16px rgba(37,99,235,0.3); }
    50% { box-shadow:0 4px 28px rgba(37,99,235,0.5), 0 0 40px rgba(37,99,235,0.1); }
}

.clc-mobile-brand { display:none; }

/* Back */
.clc-back { text-align:center; margin-top:16px; }
.clc-back-link { display:inline-flex; align-items:center; gap:6px; font-size:0.85rem; font-weight:600; color:var(--mt); text-decoration:none; transition:all 0.3s ease; }
.clc-back-link:hover { color:var(--pl); gap:10px; }
.clc-back-link i { font-size:0.9rem; transition:transform 0.3s ease; }
.clc-back-link:hover i { transform:translateX(-3px); }

/* Footer */
.clc-card-ft { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:22px; padding-top:18px; border-top:1px solid rgba(255,255,255,0.05); position:relative; z-index:1; }
.clc-card-ft i { font-size:0.82rem; color:var(--p); }
.clc-card-ft span { font-size:0.75rem; color:var(--mt); }

/* Responsive */
@media (max-width: 920px) {
    .clc-wrap { flex-direction:column; gap:28px; padding:20px 16px; min-height:auto; }
    .clc-brand { display:none; }
    .clc-card-wrap { max-width:100%; width:100%; max-width:440px; }
    .clc-card { padding:28px 22px; }
    .clc-mobile-brand {
        display:flex; align-items:center; justify-content:center; gap:8px;
        text-decoration:none; margin-bottom:20px; padding-bottom:20px;
        border-bottom:1px solid rgba(255,255,255,0.06);
    }
    .clc-mobile-brand-icon {
        width:32px; height:32px; display:flex; align-items:center; justify-content:center;
        background:linear-gradient(135deg,var(--p),var(--pd));
        border-radius:9px; font-size:1rem; color:#fff;
    }
    .clc-mobile-brand-name {
        font-size:1.1rem; font-weight:700;
        background:linear-gradient(135deg,var(--pl),var(--p));
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        background-clip:text; letter-spacing:-0.3px;
    }
}
@media (max-width: 480px) {
    .clc-page { min-height:100vh; min-height:100dvh; padding:0; display:flex; align-items:center; justify-content:center; }
    .clc-wrap { padding:20px 12px; gap:0; min-height:auto; }
    .clc-card { padding:28px 20px 24px; border-radius:22px; transform-origin:bottom center; }
    .clc-card::before { border-radius:22px; }
    .clc-mobile-brand { margin-bottom:16px; padding-bottom:16px; }
    .clc-mobile-brand-icon { width:28px; height:28px; font-size:0.85rem; border-radius:8px; }
    .clc-mobile-brand-name { font-size:1rem; }
    .clc-card-ico { width:50px; height:50px; font-size:1.25rem; border-radius:14px; margin-bottom:16px; animation:clc-icon-breathe 3s ease-in-out infinite; }
    .clc-card-title { font-size:1.35rem; margin-bottom:6px; }
    .clc-card-sub { font-size:0.85rem; }
    .clc-card-hd { margin-bottom:28px; }
    .clc-fg { margin-bottom:18px; }
    .clc-label { font-size:0.82rem; margin-bottom:7px; }
    .clc-input { padding:13px 42px 13px 44px; font-size:0.9rem; border-radius:12px; }
    .clc-input:focus { border-color:var(--p); background:rgba(37,99,235,0.06); box-shadow:0 0 0 3px var(--fc), 0 0 20px rgba(37,99,235,0.08); }
    .clc-ico { left:14px; font-size:1rem; }
    .clc-btn { padding:14px 22px; font-size:0.95rem; border-radius:12px; animation:clc-btn-glow-pulse 3s ease-in-out infinite; }
    .clc-back { margin-top:18px; }
    .clc-back-link { font-size:0.85rem; }
    .clc-card-ft { flex-direction:column; text-align:center; gap:6px; margin-top:24px; padding-top:18px; }
    .clc-card-ft span { font-size:0.75rem; }
    .clc-orb-1 { width:300px; height:300px; top:-120px; left:-100px; }
    .clc-orb-2 { width:250px; height:250px; bottom:-100px; right:-80px; }
    .clc-orb-3,.clc-orb-4 { display:none; }
    .clc-particles { display:none; }
    .clc-grid { background-size:40px 40px; mask-image:none; -webkit-mask-image:none; }
}
@media (max-width: 375px) {
    .clc-wrap { padding:16px 12px; }
    .clc-card { padding:24px 16px 20px; border-radius:20px; }
    .clc-card::before { border-radius:20px; }
    .clc-mobile-brand { margin-bottom:14px; padding-bottom:14px; }
    .clc-mobile-brand-icon { width:26px; height:26px; font-size:0.8rem; border-radius:7px; }
    .clc-mobile-brand-name { font-size:0.95rem; }
    .clc-card-ico { width:44px; height:44px; font-size:1.1rem; border-radius:12px; margin-bottom:14px; }
    .clc-card-title { font-size:1.2rem; }
    .clc-card-sub { font-size:0.8rem; }
    .clc-card-hd { margin-bottom:24px; }
    .clc-fg { margin-bottom:16px; }
    .clc-label { font-size:0.8rem; }
    .clc-input { padding:11px 36px 11px 38px; font-size:0.86rem; border-radius:11px; }
    .clc-ico { left:10px; font-size:0.88rem; }
    .clc-btn { padding:12px 18px; font-size:0.9rem; border-radius:11px; }
    .clc-card-ft { margin-top:20px; padding-top:16px; }
    .clc-card-ft span { font-size:0.72rem; }
}
@media (max-width: 320px) {
    .clc-wrap { padding:12px 8px; }
    .clc-card { padding:20px 12px 16px; border-radius:18px; }
    .clc-card::before { border-radius:18px; }
    .clc-mobile-brand { margin-bottom:12px; padding-bottom:12px; }
    .clc-mobile-brand-icon { width:24px; height:24px; font-size:0.75rem; border-radius:6px; }
    .clc-mobile-brand-name { font-size:0.85rem; }
    .clc-card-ico { width:40px; height:40px; font-size:1rem; border-radius:11px; margin-bottom:12px; }
    .clc-card-title { font-size:1.05rem; }
    .clc-card-sub { font-size:0.76rem; }
    .clc-card-hd { margin-bottom:20px; }
    .clc-fg { margin-bottom:14px; }
    .clc-label { font-size:0.76rem; }
    .clc-input { padding:10px 32px 10px 34px; font-size:0.82rem; border-radius:10px; }
    .clc-ico { left:8px; font-size:0.82rem; }
    .clc-btn { padding:11px 16px; font-size:0.86rem; border-radius:10px; }
    .clc-card-ft { margin-top:16px; padding-top:14px; }
    .clc-card-ft span { font-size:0.68rem; }
}
@media (max-height: 600px) and (orientation: landscape) {
    .clc-wrap { padding:12px; gap:16px; }
    .clc-brand { display:none; }
    .clc-card { padding:16px 16px; border-radius:18px; }
    .clc-card::before { border-radius:18px; }
    .clc-card-hd { margin-bottom:14px; }
    .clc-card-ico { width:36px; height:36px; font-size:1rem; margin-bottom:8px; }
    .clc-card-title { font-size:1.1rem; }
    .clc-orb-1 { width:160px;height:160px; }
    .clc-orb-2 { width:140px;height:140px; }
    .clc-orb-3,.clc-orb-4 { display:none; }
    .clc-particles { display:none; }
}
@media (prefers-reduced-motion: reduce) {
    .clc-page *,.clc-page *::before,.clc-page *::after { animation-duration:0.01ms !important; animation-iteration-count:1 !important; transition-duration:0.01ms !important; }
    .clc-particles { display:none; }
    .clc-card { opacity:1; transform:none; }
    .clc-card::before { animation:none; opacity:0.3; }
    .clc-brand-inner { opacity:1; transform:none; }
}
::-webkit-scrollbar { width:6px; }
::-webkit-scrollbar-track { background:var(--bg); }
::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.08); border-radius:3px; }
::-webkit-scrollbar-thumb:hover { background:rgba(255,255,255,0.12); }
</style>
</body>
</html>