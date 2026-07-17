<div class="clr-page">

    {{-- Orbs --}}
    <div class="clr-orb clr-orb-1"></div>
    <div class="clr-orb clr-orb-2"></div>
    <div class="clr-orb clr-orb-3"></div>
    <div class="clr-orb clr-orb-4"></div>

    {{-- Grid --}}
    <div class="clr-grid"></div>

    {{-- Particles --}}
    <div class="clr-particles" id="clrParticles"></div>

    {{-- Main --}}
    <div class="clr-wrap">

        {{-- Left: Brand --}}
        <div class="clr-brand">
            <div class="clr-brand-inner">
                <div class="clr-badge">Reset Password</div>
                <a href="/" class="clr-logo">
                    <div class="clr-logo-icon"><i class="bi bi-diagram-3-fill"></i></div>
                    <span class="clr-logo-text">Connectly</span>
                </a>
                <p class="clr-tagline">Create a new password for your account.</p>
                <div class="clr-features">
                    <div class="clr-ft"><i class="bi bi-shield-check"></i><span>Strong encryption</span></div>
                    <div class="clr-ft"><i class="bi bi-key-fill"></i><span>New secure password</span></div>
                    <div class="clr-ft"><i class="bi bi-arrow-repeat"></i><span>Instant account recovery</span></div>
                </div>
            </div>
        </div>

        {{-- Right: Card --}}
        <div class="clr-card-wrap">
            <div class="clr-card">

                {{-- Header --}}
                <div class="clr-card-hd">
                    <a href="/" class="clr-mobile-brand" aria-label="Connectly Home">
                        <div class="clr-mobile-brand-icon">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <span class="clr-mobile-brand-name">Connectly</span>
                    </a>
                    <div class="clr-card-ico">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <h2 class="clr-card-title">{{ __('Reset Password') }}</h2>
                    <p class="clr-card-sub">{{ __('Choose a new password for your account.') }}</p>
                </div>

                {{-- Body --}}
                <div class="clr-card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="clr-fg">
                            <label class="clr-label" for="email">{{ __('Email') }}</label>
                            <div class="clr-iw">
                                <i class="bi bi-envelope-fill clr-ico"></i>
                                <input id="email" type="email"
                                       class="clr-input @error('email') clr-err @enderror"
                                       name="email"
                                       value="{{ $email ?? old('email') }}"
                                       required autofocus readonly
                                       placeholder="your@email.com">
                                <div class="clr-glow"></div>
                            </div>
                            @error('email')
                                <span class="clr-err-txt">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="clr-fg">
                            <label class="clr-label" for="password">{{ __('New Password') }}</label>
                            <div class="clr-iw">
                                <i class="bi bi-lock-fill clr-ico"></i>
                                <input id="password" type="password"
                                       class="clr-input @error('password') clr-err @enderror"
                                       name="password" required
                                       placeholder="Create a strong password"
                                       autocomplete="new-password">
                                <div class="clr-glow"></div>
                            </div>
                            @error('password')
                                <span class="clr-err-txt">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="clr-fg">
                            <label class="clr-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                            <div class="clr-iw">
                                <i class="bi bi-shield-check clr-ico"></i>
                                <input id="password-confirm" type="password"
                                       class="clr-input"
                                       name="password_confirmation" required
                                       placeholder="Repeat your password"
                                       autocomplete="new-password">
                                <div class="clr-glow"></div>
                            </div>
                        </div>

                        <button type="submit" class="clr-btn">
                            <span class="clr-btn-txt">{{ __('Reset Password') }}</span>
                            <span class="clr-btn-ldr"><i class="bi bi-arrow-right"></i></span>
                            <div class="clr-btn-shine"></div>
                        </button>
                    </form>

                    <div class="clr-back">
                        <a href="{{ route('login') }}" class="clr-back-link">
                            <i class="bi bi-arrow-left"></i> {{ __('Back to Sign In') }}
                        </a>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="clr-card-ft">
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
    const pc = document.getElementById('clrParticles');
    if (pc) {
        for (let i = 0; i < 25; i++) {
            const p = document.createElement('div');
            p.className = 'clr-p';
            const s = Math.random() * 4 + 2;
            p.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*100}%;animation-duration:${Math.random()*15+12}s;animation-delay:${Math.random()*6}s;bottom:-10px;opacity:${Math.random()*0.4+0.15}`;
            pc.appendChild(p);
        }
    }
    setTimeout(() => { document.querySelector('.clr-card')?.classList.add('clr-card-vis'); }, 100);
    setTimeout(() => { document.querySelector('.clr-brand-inner')?.classList.add('clr-brand-vis'); }, 300);

    document.querySelectorAll('.clr-iw').forEach(w => {
        const inp = w.querySelector('.clr-input');
        const ico = w.querySelector('.clr-ico');
        if (inp && ico) {
            inp.addEventListener('focus', () => { w.classList.add('clr-iw-focus'); ico.style.color = '#2563EB'; ico.style.transform = 'translateY(-50%) scale(1.15)'; });
            inp.addEventListener('blur', () => { w.classList.remove('clr-iw-focus'); ico.style.color = '#64748b'; ico.style.transform = 'translateY(-50%) scale(1)'; });
        }
    });

    const c = document.querySelector('.clr-card');
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
.clr-page {
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
.clr-orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; }
.clr-orb-1 { width:500px;height:500px;background:radial-gradient(circle,rgba(37,99,235,0.1),transparent 70%);top:-180px;left:-120px;animation:clr-o1 14s ease-in-out infinite; }
.clr-orb-2 { width:400px;height:400px;background:radial-gradient(circle,rgba(96,165,250,0.07),transparent 70%);bottom:-120px;right:-80px;animation:clr-o2 16s ease-in-out infinite; }
.clr-orb-3 { width:300px;height:300px;background:radial-gradient(circle,rgba(30,64,175,0.08),transparent 70%);top:40%;left:50%;animation:clr-o3 18s ease-in-out infinite; }
.clr-orb-4 { width:250px;height:250px;background:radial-gradient(circle,rgba(37,99,235,0.05),transparent 70%);bottom:20%;left:25%;animation:clr-o1 20s ease-in-out infinite reverse; }
@keyframes clr-o1 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(60px,40px) scale(1.1); } }
@keyframes clr-o2 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(-40px,-60px) scale(1.08); } }
@keyframes clr-o3 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(30px,-30px) scale(1.12); } }
.clr-grid { position:fixed; inset:0; background-image:linear-gradient(rgba(37,99,235,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(37,99,235,0.025) 1px,transparent 1px); background-size:50px 50px; pointer-events:none; z-index:1; mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); -webkit-mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); }
.clr-particles { position:fixed; inset:0; overflow:hidden; pointer-events:none; z-index:1; }
.clr-p { position:absolute; background:linear-gradient(135deg,var(--p),var(--pl)); border-radius:50%; animation:clr-rise linear infinite; }
@keyframes clr-rise { 0% { transform:translateY(0) rotate(0deg); opacity:0; } 10% { opacity:0.35; } 90% { opacity:0.1; } 100% { transform:translateY(-100vh) rotate(360deg); opacity:0; } }
.clr-wrap { position:relative; z-index:10; display:flex; align-items:center; justify-content:center; gap:50px; width:100%; max-width:1050px; padding:32px 20px; min-height:100vh; min-height:100dvh; }

/* Brand */
.clr-brand { flex:1; max-width:400px; display:flex; align-items:center; justify-content:center; }
.clr-brand-inner { opacity:0; transform:translateX(-30px); transition:all 0.8s cubic-bezier(.16,1,.3,1); }
.clr-brand-inner.clr-brand-vis { opacity:1; transform:translateX(0); }
.clr-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.15); border-radius:999px; font-size:0.78rem; font-weight:600; color:var(--pl); margin-bottom:20px; letter-spacing:0.3px; }
.clr-badge::before { content:''; width:5px; height:5px; border-radius:50%; background:#22c55e; animation:clr-pulse 2s ease-in-out infinite; }
@keyframes clr-pulse { 0%,100% { box-shadow:0 0 0 0 rgba(34,197,94,0.6); } 50% { box-shadow:0 0 0 5px rgba(34,197,94,0); } }
.clr-logo { display:flex; align-items:center; gap:10px; text-decoration:none; margin-bottom:12px; }
.clr-logo-icon { width:44px; height:44px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--p),var(--pd)); border-radius:12px; font-size:1.35rem; color:#fff; box-shadow:0 6px 20px rgba(37,99,235,0.3); }
.clr-logo-text { font-size:1.8rem; font-weight:800; background:linear-gradient(135deg,var(--pl),var(--p)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.5px; }
.clr-tagline { font-size:1.05rem; color:var(--mt); margin-bottom:28px; line-height:1.6; }
.clr-features { display:flex; flex-direction:column; gap:12px; }
.clr-ft { display:flex; align-items:center; gap:12px; font-size:0.9rem; color:var(--mt); transition:all 0.3s ease; cursor:default; }
.clr-ft:hover { color:var(--txt); transform:translateX(4px); }
.clr-ft i { font-size:1.1rem; color:var(--p); width:24px; text-align:center; }

/* Card */
.clr-card-wrap { flex:1; max-width:420px; display:flex; align-items:center; justify-content:center; }
.clr-card { --mx:50%; --my:50%; width:100%; background:var(--card); backdrop-filter:blur(24px) saturate(180%); -webkit-backdrop-filter:blur(24px) saturate(180%); border:1px solid var(--bd); border-radius:24px; padding:36px 32px; position:relative; overflow:hidden; transition:all 0.6s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(30px) scale(0.97); }
.clr-card.clr-card-vis { opacity:1; transform:translateY(0) scale(1); }
.clr-card::before { content:''; position:absolute; inset:-1px; border-radius:24px; padding:1px; background:linear-gradient(135deg,rgba(37,99,235,0.3),rgba(96,165,250,0.1),rgba(37,99,235,0.05),rgba(96,165,250,0.2)); background-size:300% 300%; -webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0); -webkit-mask-composite:xor; mask-composite:exclude; animation:clr-border 6s ease-in-out infinite; pointer-events:none; z-index:0; opacity:0.6; transition:opacity 0.4s ease; }
.clr-card:hover::before { opacity:1; }
@keyframes clr-border { 0%,100% { background-position:0% 50%; } 50% { background-position:100% 50%; } }
.clr-card::after { content:''; position:absolute; top:var(--my); left:var(--mx); transform:translate(-50%,-50%); width:400px; height:400px; background:radial-gradient(circle,rgba(37,99,235,0.06),transparent 70%); border-radius:50%; pointer-events:none; z-index:0; transition:all 0.3s ease; }
.clr-card:hover { border-color:rgba(37,99,235,0.15); box-shadow:0 20px 60px rgba(0,0,0,0.3); transform:translateY(-2px); }
.clr-card-hd { text-align:center; margin-bottom:28px; position:relative; z-index:1; }
.clr-card-ico { width:52px; height:52px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(37,99,235,0.05)); border:1px solid rgba(37,99,235,0.15); border-radius:16px; margin:0 auto 14px; font-size:1.4rem; color:var(--pl); animation:clr-ico-pulse 3s ease-in-out infinite; }
@keyframes clr-ico-pulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.05); } }
.clr-card-title { font-size:1.5rem; font-weight:800; color:var(--txt); margin-bottom:6px; letter-spacing:-0.3px; }
.clr-card-sub { font-size:0.88rem; color:var(--mt); }
.clr-card-body { position:relative; z-index:1; }

/* Form */
.clr-fg { margin-bottom:20px; }
.clr-label { display:block; font-size:0.82rem; font-weight:600; color:var(--txt); margin-bottom:7px; letter-spacing:0.2px; }
.clr-iw { position:relative; border-radius:12px; overflow:hidden; }
.clr-ico { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748b; z-index:2; font-size:1rem; transition:all 0.3s cubic-bezier(.16,1,.3,1); }
.clr-input { width:100%; padding:13px 42px 13px 44px; background:var(--ibg); border:1.5px solid var(--ibd); border-radius:12px; font-family:'Inter',sans-serif; font-size:0.92rem; color:var(--txt); outline:none; transition:all 0.3s cubic-bezier(.16,1,.3,1); position:relative; z-index:1; }
.clr-input::placeholder { color:#475569; }
.clr-input:focus { border-color:var(--p); background:rgba(37,99,235,0.05); box-shadow:0 0 0 4px var(--fc); }
.clr-err { border-color:#ef4444 !important; }
.clr-glow { position:absolute; inset:0; border-radius:12px; background:radial-gradient(circle at var(--mx,50%) var(--my,50%),rgba(37,99,235,0.08),transparent 60%); pointer-events:none; opacity:0; transition:opacity 0.3s ease; z-index:0; }
.clr-iw-focus .clr-glow { opacity:1; }
.clr-err-txt { display:block; color:#ef4444; font-size:0.78rem; margin-top:5px; font-weight:500; }

/* Button */
.clr-btn { width:100%; padding:14px 20px; background:linear-gradient(135deg,var(--p),var(--pd)); border:none; border-radius:12px; font-family:'Inter',sans-serif; font-size:0.95rem; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; position:relative; overflow:hidden; transition:all 0.4s cubic-bezier(.16,1,.3,1); box-shadow:0 4px 16px rgba(37,99,235,0.3); }
.clr-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(37,99,235,0.4); }
.clr-btn:active { transform:translateY(0); }
.clr-btn:disabled { opacity:0.7; cursor:not-allowed; transform:none; }
.clr-btn-shine { position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.15),transparent); transform:skewX(-20deg); transition:left 0.8s ease; }
.clr-btn:hover .clr-btn-shine { left:150%; }
.clr-btn-ldr { font-size:1.05rem; display:flex; align-items:center; }
.clr-btn:hover .clr-btn-ldr i { animation:clr-ba 1s ease infinite; }
@keyframes clr-ba { 0%,100% { transform:translateX(0); } 50% { transform:translateX(4px); } }
@keyframes clr-icon-breathe {
    0%,100% { box-shadow:0 0 0 0 rgba(37,99,235,0.15), 0 4px 16px rgba(37,99,235,0.1); transform:scale(1); }
    50% { box-shadow:0 0 0 8px rgba(37,99,235,0.05), 0 4px 24px rgba(37,99,235,0.15); transform:scale(1.03); }
}
@keyframes clr-btn-glow-pulse {
    0%,100% { box-shadow:0 4px 16px rgba(37,99,235,0.3); }
    50% { box-shadow:0 4px 28px rgba(37,99,235,0.5), 0 0 40px rgba(37,99,235,0.1); }
}

.clr-mobile-brand { display:none; }

/* Back */
.clr-back { text-align:center; margin-top:20px; }
.clr-back-link { display:inline-flex; align-items:center; gap:6px; font-size:0.85rem; font-weight:600; color:var(--mt); text-decoration:none; transition:all 0.3s ease; }
.clr-back-link:hover { color:var(--pl); gap:10px; }
.clr-back-link i { font-size:0.9rem; transition:transform 0.3s ease; }
.clr-back-link:hover i { transform:translateX(-3px); }

/* Footer */
.clr-card-ft { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:22px; padding-top:18px; border-top:1px solid rgba(255,255,255,0.05); position:relative; z-index:1; }
.clr-card-ft i { font-size:0.82rem; color:var(--p); }
.clr-card-ft span { font-size:0.75rem; color:var(--mt); }

/* Responsive */
@media (max-width: 920px) {
    .clr-wrap { flex-direction:column; gap:28px; padding:20px 16px; min-height:auto; }
    .clr-brand { display:none; }
    .clr-card-wrap { max-width:100%; width:100%; max-width:440px; }
    .clr-card { padding:28px 22px; }
    .clr-mobile-brand {
        display:flex; align-items:center; justify-content:center; gap:8px;
        text-decoration:none; margin-bottom:20px; padding-bottom:20px;
        border-bottom:1px solid rgba(255,255,255,0.06);
    }
    .clr-mobile-brand-icon {
        width:32px; height:32px; display:flex; align-items:center; justify-content:center;
        background:linear-gradient(135deg,var(--p),var(--pd));
        border-radius:9px; font-size:1rem; color:#fff;
    }
    .clr-mobile-brand-name {
        font-size:1.1rem; font-weight:700;
        background:linear-gradient(135deg,var(--pl),var(--p));
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        background-clip:text; letter-spacing:-0.3px;
    }
}
@media (max-width: 480px) {
    .clr-page { min-height:100vh; min-height:100dvh; padding:0; display:flex; align-items:center; justify-content:center; }
    .clr-wrap { padding:20px 12px; gap:0; min-height:auto; }
    .clr-card { padding:28px 20px 24px; border-radius:22px; transform-origin:bottom center; }
    .clr-card::before { border-radius:22px; }
    .clr-mobile-brand { margin-bottom:16px; padding-bottom:16px; }
    .clr-mobile-brand-icon { width:28px; height:28px; font-size:0.85rem; border-radius:8px; }
    .clr-mobile-brand-name { font-size:1rem; }
    .clr-card-ico { width:50px; height:50px; font-size:1.25rem; border-radius:14px; margin-bottom:16px; animation:clr-icon-breathe 3s ease-in-out infinite; }
    .clr-card-title { font-size:1.35rem; margin-bottom:6px; }
    .clr-card-sub { font-size:0.85rem; }
    .clr-card-hd { margin-bottom:28px; }
    .clr-fg { margin-bottom:18px; }
    .clr-label { font-size:0.82rem; margin-bottom:7px; }
    .clr-input { padding:13px 42px 13px 44px; font-size:0.9rem; border-radius:12px; }
    .clr-input:focus { border-color:var(--p); background:rgba(37,99,235,0.06); box-shadow:0 0 0 3px var(--fc), 0 0 20px rgba(37,99,235,0.08); }
    .clr-ico { left:14px; font-size:1rem; }
    .clr-btn { padding:14px 22px; font-size:0.95rem; border-radius:12px; animation:clr-btn-glow-pulse 3s ease-in-out infinite; }
    .clr-back { margin-top:18px; }
    .clr-back-link { font-size:0.85rem; }
    .clr-card-ft { flex-direction:column; text-align:center; gap:6px; margin-top:24px; padding-top:18px; }
    .clr-card-ft span { font-size:0.75rem; }
    .clr-orb-1 { width:300px; height:300px; top:-120px; left:-100px; }
    .clr-orb-2 { width:250px; height:250px; bottom:-100px; right:-80px; }
    .clr-orb-3,.clr-orb-4 { display:none; }
    .clr-particles { display:none; }
    .clr-grid { background-size:40px 40px; mask-image:none; -webkit-mask-image:none; }
}
@media (max-width: 375px) {
    .clr-wrap { padding:16px 12px; }
    .clr-card { padding:24px 16px 20px; border-radius:20px; }
    .clr-card::before { border-radius:20px; }
    .clr-mobile-brand { margin-bottom:14px; padding-bottom:14px; }
    .clr-mobile-brand-icon { width:26px; height:26px; font-size:0.8rem; border-radius:7px; }
    .clr-mobile-brand-name { font-size:0.95rem; }
    .clr-card-ico { width:44px; height:44px; font-size:1.1rem; border-radius:12px; margin-bottom:14px; }
    .clr-card-title { font-size:1.2rem; }
    .clr-card-sub { font-size:0.8rem; }
    .clr-card-hd { margin-bottom:24px; }
    .clr-fg { margin-bottom:16px; }
    .clr-label { font-size:0.8rem; }
    .clr-input { padding:11px 36px 11px 38px; font-size:0.86rem; border-radius:11px; }
    .clr-ico { left:10px; font-size:0.88rem; }
    .clr-btn { padding:12px 18px; font-size:0.9rem; border-radius:11px; }
    .clr-card-ft { margin-top:20px; padding-top:16px; }
    .clr-card-ft span { font-size:0.72rem; }
}
@media (max-width: 320px) {
    .clr-wrap { padding:12px 8px; }
    .clr-card { padding:20px 12px 16px; border-radius:18px; }
    .clr-card::before { border-radius:18px; }
    .clr-mobile-brand { margin-bottom:12px; padding-bottom:12px; }
    .clr-mobile-brand-icon { width:24px; height:24px; font-size:0.75rem; border-radius:6px; }
    .clr-mobile-brand-name { font-size:0.85rem; }
    .clr-card-ico { width:40px; height:40px; font-size:1rem; border-radius:11px; margin-bottom:12px; }
    .clr-card-title { font-size:1.05rem; }
    .clr-card-sub { font-size:0.76rem; }
    .clr-card-hd { margin-bottom:20px; }
    .clr-fg { margin-bottom:14px; }
    .clr-label { font-size:0.76rem; }
    .clr-input { padding:10px 32px 10px 34px; font-size:0.82rem; border-radius:10px; }
    .clr-ico { left:8px; font-size:0.82rem; }
    .clr-btn { padding:11px 16px; font-size:0.86rem; border-radius:10px; }
    .clr-card-ft { margin-top:16px; padding-top:14px; }
    .clr-card-ft span { font-size:0.68rem; }
}
@media (max-height: 600px) and (orientation: landscape) {
    .clr-wrap { padding:12px; gap:16px; }
    .clr-brand { display:none; }
    .clr-card { padding:16px 16px; border-radius:18px; }
    .clr-card::before { border-radius:18px; }
    .clr-card-hd { margin-bottom:14px; }
    .clr-card-ico { width:36px; height:36px; font-size:1rem; margin-bottom:8px; }
    .clr-card-title { font-size:1.1rem; }
    .clr-orb-1 { width:160px;height:160px; }
    .clr-orb-2 { width:140px;height:140px; }
    .clr-orb-3,.clr-orb-4 { display:none; }
    .clr-particles { display:none; }
}
@media (prefers-reduced-motion: reduce) {
    .clr-page *,.clr-page *::before,.clr-page *::after { animation-duration:0.01ms !important; animation-iteration-count:1 !important; transition-duration:0.01ms !important; }
    .clr-particles { display:none; }
    .clr-card { opacity:1; transform:none; }
    .clr-card::before { animation:none; opacity:0.3; }
    .clr-brand-inner { opacity:1; transform:none; }
}
::-webkit-scrollbar { width:6px; }
::-webkit-scrollbar-track { background:var(--bg); }
::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.08); border-radius:3px; }
::-webkit-scrollbar-thumb:hover { background:rgba(255,255,255,0.12); }
</style>