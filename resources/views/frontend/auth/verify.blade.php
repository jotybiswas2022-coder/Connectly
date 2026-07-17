<div class="clv-page">

    {{-- Orbs --}}
    <div class="clv-orb clv-orb-1"></div>
    <div class="clv-orb clv-orb-2"></div>
    <div class="clv-orb clv-orb-3"></div>
    <div class="clv-orb clv-orb-4"></div>

    {{-- Grid --}}
    <div class="clv-grid"></div>

    {{-- Particles --}}
    <div class="clv-particles" id="clvParticles"></div>

    {{-- Main --}}
    <div class="clv-wrap">
        <div class="clv-card-wrap">
            <div class="clv-card">

                {{-- Header --}}
                <div class="clv-card-hd">
                    <a href="/" class="clv-mobile-brand" aria-label="Connectly Home">
                        <div class="clv-mobile-brand-icon">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <span class="clv-mobile-brand-name">Connectly</span>
                    </a>
                    <div class="clv-card-ico">
                        <i class="bi bi-envelope-check-fill"></i>
                    </div>
                    <h2 class="clv-card-title">{{ __('Verify Your Email Address') }}</h2>
                    <p class="clv-card-sub">{{ __('Please check your email for a verification link.') }}</p>
                </div>

                {{-- Body --}}
                <div class="clv-card-body">

                    @if (session('resent'))
                        <div class="clv-alert clv-alert-ok">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <div class="clv-info">
                        <div class="clv-info-icon">
                            <i class="bi bi-envelope-open-fill"></i>
                        </div>
                        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    </div>

                    <p class="clv-text">{{ __('If you did not receive the email') }},</p>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="clv-btn">
                            <i class="bi bi-arrow-repeat"></i>
                            {{ __('Click here to request another') }}
                        </button>
                    </form>

                    <div class="clv-back">
                        <a href="{{ route('login') }}" class="clv-back-link">
                            <i class="bi bi-arrow-left"></i> {{ __('Back to Sign In') }}
                        </a>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="clv-card-ft">
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
    const pc = document.getElementById('clvParticles');
    if (pc) {
        for (let i = 0; i < 20; i++) {
            const p = document.createElement('div');
            p.className = 'clv-p';
            const s = Math.random() * 3 + 1.5;
            p.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*100}%;animation-duration:${Math.random()*15+12}s;animation-delay:${Math.random()*6}s;bottom:-10px;opacity:${Math.random()*0.35+0.1}`;
            pc.appendChild(p);
        }
    }
    setTimeout(() => { document.querySelector('.clv-card')?.classList.add('clv-card-vis'); }, 100);

    const c = document.querySelector('.clv-card');
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
.clv-page {
    --p:#2563EB; --pl:#60A5FA; --pd:#1E40AF;
    --bg:#0b1121; --card:rgba(255,255,255,0.04); --bd:rgba(255,255,255,0.06);
    --txt:#f1f5f9; --mt:#94a3b8;
    font-family: 'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
    background:var(--bg); color:var(--txt);
    min-height:100vh; min-height:100dvh;
    display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden;
}
.clv-orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; }
.clv-orb-1 { width:450px;height:450px;background:radial-gradient(circle,rgba(37,99,235,0.1),transparent 70%);top:-150px;left:-100px;animation:clv-o1 14s ease-in-out infinite; }
.clv-orb-2 { width:350px;height:350px;background:radial-gradient(circle,rgba(96,165,250,0.07),transparent 70%);bottom:-100px;right:-60px;animation:clv-o2 16s ease-in-out infinite; }
.clv-orb-3 { width:250px;height:250px;background:radial-gradient(circle,rgba(30,64,175,0.08),transparent 70%);top:45%;left:45%;animation:clv-o3 18s ease-in-out infinite; }
.clv-orb-4 { width:200px;height:200px;background:radial-gradient(circle,rgba(37,99,235,0.05),transparent 70%);bottom:25%;left:20%;animation:clv-o1 20s ease-in-out infinite reverse; }
@keyframes clv-o1 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(50px,30px) scale(1.1); } }
@keyframes clv-o2 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(-30px,-50px) scale(1.08); } }
@keyframes clv-o3 { 0%,100% { transform:translate(0,0) scale(1); } 50% { transform:translate(20px,-20px) scale(1.12); } }
.clv-grid { position:fixed; inset:0; background-image:linear-gradient(rgba(37,99,235,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(37,99,235,0.025) 1px,transparent 1px); background-size:50px 50px; pointer-events:none; z-index:1; mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); -webkit-mask-image:radial-gradient(ellipse at 50% 50%,black 25%,transparent 70%); }
.clv-particles { position:fixed; inset:0; overflow:hidden; pointer-events:none; z-index:1; }
.clv-p { position:absolute; background:linear-gradient(135deg,var(--p),var(--pl)); border-radius:50%; animation:clv-rise linear infinite; }
@keyframes clv-rise { 0% { transform:translateY(0) rotate(0deg); opacity:0; } 10% { opacity:0.35; } 90% { opacity:0.1; } 100% { transform:translateY(-100vh) rotate(360deg); opacity:0; } }
.clv-wrap { position:relative; z-index:10; display:flex; align-items:center; justify-content:center; width:100%; max-width:460px; padding:24px; min-height:100vh; min-height:100dvh; }
.clv-card-wrap { width:100%; display:flex; align-items:center; justify-content:center; }
.clv-card { --mx:50%; --my:50%; width:100%; background:var(--card); backdrop-filter:blur(24px) saturate(180%); -webkit-backdrop-filter:blur(24px) saturate(180%); border:1px solid var(--bd); border-radius:24px; padding:36px 32px; position:relative; overflow:hidden; transition:all 0.6s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(30px) scale(0.97); }
.clv-card.clv-card-vis { opacity:1; transform:translateY(0) scale(1); }
.clv-card::before { content:''; position:absolute; inset:-1px; border-radius:24px; padding:1px; background:linear-gradient(135deg,rgba(37,99,235,0.3),rgba(96,165,250,0.1),rgba(37,99,235,0.05),rgba(96,165,250,0.2)); background-size:300% 300%; -webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0); -webkit-mask-composite:xor; mask-composite:exclude; animation:clv-border 6s ease-in-out infinite; pointer-events:none; z-index:0; opacity:0.6; transition:opacity 0.4s ease; }
.clv-card:hover::before { opacity:1; }
@keyframes clv-border { 0%,100% { background-position:0% 50%; } 50% { background-position:100% 50%; } }
.clv-card::after { content:''; position:absolute; top:var(--my); left:var(--mx); transform:translate(-50%,-50%); width:400px; height:400px; background:radial-gradient(circle,rgba(37,99,235,0.06),transparent 70%); border-radius:50%; pointer-events:none; z-index:0; transition:all 0.3s ease; }
.clv-card:hover { border-color:rgba(37,99,235,0.15); box-shadow:0 20px 60px rgba(0,0,0,0.3); transform:translateY(-2px); }
.clv-card-hd { text-align:center; margin-bottom:28px; position:relative; z-index:1; }
.clv-card-ico { width:56px; height:56px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(37,99,235,0.05)); border:1px solid rgba(37,99,235,0.15); border-radius:16px; margin:0 auto 14px; font-size:1.5rem; color:var(--pl); animation:clv-pulse 3s ease-in-out infinite; }
@keyframes clv-pulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.05); } }
@keyframes clv-icon-breathe {
    0%,100% { box-shadow:0 0 0 0 rgba(37,99,235,0.15), 0 4px 16px rgba(37,99,235,0.1); transform:scale(1); }
    50% { box-shadow:0 0 0 8px rgba(37,99,235,0.05), 0 4px 24px rgba(37,99,235,0.15); transform:scale(1.03); }
}
@keyframes clv-btn-glow-pulse {
    0%,100% { box-shadow:0 4px 16px rgba(37,99,235,0.3); }
    50% { box-shadow:0 4px 28px rgba(37,99,235,0.5), 0 0 40px rgba(37,99,235,0.1); }
}

.clv-mobile-brand { display:none; }
.clv-card-title { font-size:1.4rem; font-weight:800; color:var(--txt); margin-bottom:8px; letter-spacing:-0.3px; }
.clv-card-sub { font-size:0.88rem; color:var(--mt); }
.clv-card-body { position:relative; z-index:1; }
.clv-alert { padding:12px 14px; border-radius:12px; font-size:0.85rem; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
.clv-alert-ok { background:rgba(16,185,129,0.1); color:#10b981; border:1px solid rgba(16,185,129,0.15); }
.clv-info { text-align:center; padding:24px 16px; background:rgba(255,255,255,0.03); border:1px solid var(--bd); border-radius:14px; margin-bottom:20px; }
.clv-info-icon { width:48px; height:48px; margin:0 auto 12px; display:flex; align-items:center; justify-content:center; background:rgba(37,99,235,0.1); border-radius:50%; font-size:1.3rem; color:var(--pl); }
.clv-info p { font-size:0.88rem; color:var(--mt); line-height:1.6; }
.clv-text { text-align:center; font-size:0.85rem; color:var(--mt); margin-bottom:16px; }
.clv-btn { width:100%; padding:14px 20px; background:linear-gradient(135deg,var(--p),var(--pd)); border:none; border-radius:12px; font-family:'Inter',sans-serif; font-size:0.95rem; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; position:relative; overflow:hidden; transition:all 0.4s cubic-bezier(.16,1,.3,1); box-shadow:0 4px 16px rgba(37,99,235,0.3); }
.clv-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(37,99,235,0.4); }
.clv-back { text-align:center; margin-top:20px; }
.clv-back-link { display:inline-flex; align-items:center; gap:6px; font-size:0.85rem; font-weight:600; color:var(--mt); text-decoration:none; transition:all 0.3s ease; }
.clv-back-link:hover { color:var(--pl); gap:10px; }
.clv-back-link i { font-size:0.9rem; transition:transform 0.3s ease; }
.clv-back-link:hover i { transform:translateX(-3px); }
.clv-card-ft { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:24px; padding-top:18px; border-top:1px solid rgba(255,255,255,0.05); position:relative; z-index:1; }
.clv-card-ft i { font-size:0.82rem; color:var(--p); }
.clv-card-ft span { font-size:0.75rem; color:var(--mt); }

/* Responsive */
@media (max-width: 480px) {
    .clv-page { min-height:100vh; min-height:100dvh; padding:0; display:flex; align-items:center; justify-content:center; }
    .clv-wrap { padding:20px 12px; min-height:auto; }
    .clv-card { padding:28px 20px 24px; border-radius:22px; transform-origin:bottom center; }
    .clv-card::before { border-radius:22px; }
    .clv-mobile-brand { display:flex; align-items:center; justify-content:center; gap:8px; text-decoration:none; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.06); }
    .clv-mobile-brand-icon { width:28px; height:28px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--p),var(--pd)); border-radius:8px; font-size:0.85rem; color:#fff; }
    .clv-mobile-brand-name { font-size:1rem; font-weight:700; background:linear-gradient(135deg,var(--pl),var(--p)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:-0.3px; }
    .clv-card-ico { width:50px; height:50px; font-size:1.25rem; border-radius:14px; margin-bottom:16px; animation:clv-icon-breathe 3s ease-in-out infinite; }
    .clv-card-title { font-size:1.25rem; margin-bottom:6px; }
    .clv-card-sub { font-size:0.85rem; }
    .clv-card-hd { margin-bottom:28px; }
    .clv-alert { font-size:0.82rem; margin-bottom:18px; padding:10px 12px; }
    .clv-info { padding:20px 14px; margin-bottom:18px; }
    .clv-info-icon { width:44px; height:44px; font-size:1.15rem; }
    .clv-info p { font-size:0.85rem; }
    .clv-text { font-size:0.82rem; margin-bottom:14px; }
    .clv-btn { padding:14px 20px; font-size:0.95rem; border-radius:12px; animation:clv-btn-glow-pulse 3s ease-in-out infinite; }
    .clv-back { margin-top:18px; }
    .clv-back-link { font-size:0.85rem; }
    .clv-card-ft { flex-direction:column; text-align:center; gap:6px; margin-top:24px; padding-top:18px; }
    .clv-card-ft span { font-size:0.75rem; }
    .clv-orb-1 { width:300px; height:300px; top:-120px; left:-100px; }
    .clv-orb-2 { width:250px; height:250px; bottom:-100px; right:-80px; }
    .clv-orb-3,.clv-orb-4 { display:none; }
    .clv-particles { display:none; }
    .clv-grid { background-size:40px 40px; mask-image:none; -webkit-mask-image:none; }
}
@media (max-width: 375px) {
    .clv-wrap { padding:16px 12px; }
    .clv-card { padding:24px 16px 20px; border-radius:20px; }
    .clv-card::before { border-radius:20px; }
    .clv-mobile-brand { margin-bottom:16px; padding-bottom:16px; }
    .clv-mobile-brand-icon { width:26px; height:26px; font-size:0.8rem; border-radius:7px; }
    .clv-mobile-brand-name { font-size:0.95rem; }
    .clv-card-ico { width:44px; height:44px; font-size:1.1rem; border-radius:12px; margin-bottom:14px; }
    .clv-card-title { font-size:1.15rem; }
    .clv-card-sub { font-size:0.8rem; }
    .clv-card-hd { margin-bottom:24px; }
    .clv-info { padding:16px 12px; }
    .clv-btn { padding:12px 18px; font-size:0.9rem; border-radius:11px; }
    .clv-card-ft { margin-top:20px; padding-top:16px; }
    .clv-card-ft span { font-size:0.72rem; }
}
@media (max-width: 320px) {
    .clv-wrap { padding:12px 8px; }
    .clv-card { padding:20px 12px 16px; border-radius:18px; }
    .clv-card::before { border-radius:18px; }
    .clv-mobile-brand { margin-bottom:14px; padding-bottom:14px; }
    .clv-mobile-brand-icon { width:24px; height:24px; font-size:0.75rem; border-radius:6px; }
    .clv-mobile-brand-name { font-size:0.85rem; }
    .clv-card-ico { width:40px; height:40px; font-size:1rem; border-radius:11px; margin-bottom:12px; }
    .clv-card-title { font-size:1rem; }
    .clv-card-sub { font-size:0.76rem; }
    .clv-card-hd { margin-bottom:20px; }
    .clv-btn { padding:11px 16px; font-size:0.86rem; border-radius:10px; }
    .clv-card-ft { margin-top:16px; padding-top:14px; }
    .clv-card-ft span { font-size:0.68rem; }
}
@media (max-height: 600px) and (orientation: landscape) {
    .clv-wrap { padding:12px; }
    .clv-card { padding:18px 16px; border-radius:18px; }
    .clv-card::before { border-radius:18px; }
    .clv-orb-1 { width:150px;height:150px; }
    .clv-orb-2 { width:120px;height:120px; }
    .clv-orb-3,.clv-orb-4 { display:none; }
    .clv-particles { display:none; }
}
@media (prefers-reduced-motion: reduce) {
    .clv-page *,.clv-page *::before,.clv-page *::after { animation-duration:0.01ms !important; animation-iteration-count:1 !important; transition-duration:0.01ms !important; }
    .clv-particles { display:none; }
    .clv-card { opacity:1; transform:none; }
    .clv-card::before { animation:none; opacity:0.3; }
}
::-webkit-scrollbar { width:6px; }
::-webkit-scrollbar-track { background:var(--bg); }
::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.08); border-radius:3px; }
::-webkit-scrollbar-thumb:hover { background:rgba(255,255,255,0.12); }
</style>