@extends('backend.app')

@section('content')

@if (session('success'))
    <input type="hidden" id="sessionSuccess" value="{{ session('success') }}">
@endif

@if ($errors->any())
    <input type="hidden" id="validationErrors" value="{{ implode('\n', $errors->all()) }}">
@endif

<div class="acc-edit-page">

    {{-- BG Orbs --}}
    <div class="ae-orb ae-orb-1"></div>
    <div class="ae-orb ae-orb-2"></div>
    <div class="ae-orb ae-orb-3"></div>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Edit Account</h1>
            <div class="sub">Update your admin profile details</div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="ae-card animate-in">
        <div class="ae-card-bg-shine"></div>

        <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data" class="ae-form">
            @csrf

            <div class="ae-form-grid">

                {{-- Name --}}
                <div class="ae-field">
                    <label class="ae-label">Name</label>
                    <div class="ae-input-wrap">
                        <svg class="ae-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" name="name" value="{{ $account->name ?? '' }}" placeholder="Enter name" required class="ae-input @error('name') ae-input-error @enderror" aria-label="Account name">
                    </div>
                    @error('name') <span class="ae-field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Phone --}}
                <div class="ae-field">
                    <label class="ae-label">Phone Number</label>
                    <div class="ae-input-wrap">
                        <svg class="ae-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <input type="text" name="phone" value="{{ $account->phone ?? '' }}" placeholder="Enter phone number" class="ae-input @error('phone') ae-input-error @enderror">
                    </div>
                    @error('phone') <span class="ae-field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="ae-field">
                    <label class="ae-label">Email</label>
                    <div class="ae-input-wrap">
                        <svg class="ae-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" name="email" value="{{ $account->email ?? '' }}" placeholder="Enter email address" class="ae-input @error('email') ae-input-error @enderror">
                    </div>
                    @error('email') <span class="ae-field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Website --}}
                <div class="ae-field">
                    <label class="ae-label">Website</label>
                    <div class="ae-input-wrap">
                        <svg class="ae-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        <input type="url" name="website" value="{{ $account->website ?? '' }}" placeholder="https://example.com" class="ae-input @error('website') ae-input-error @enderror">
                    </div>
                    @error('website') <span class="ae-field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Profile Picture --}}
                <div class="ae-field ae-field-full">
                    <label class="ae-label">Profile Picture</label>
                    <div class="ae-file-wrap">
                        <div class="ae-file-preview" id="filePreview">
                            @if(isset($account) && $account->image)
                                <img src="{{ config('app.storage_url') }}{{ $account->image }}" class="ae-preview-img" id="preview">
                            @else
                                <div class="ae-preview-placeholder" id="previewPlaceholder">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <span>No image selected</span>
                                </div>
                                <img id="preview" style="display:none;" class="ae-preview-img">
                            @endif
                        </div>
                        <label class="ae-file-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Upload Image
                            <input type="file" accept="image/*" name="image" onchange="previewImage(event)" hidden>
                        </label>
                        <span class="ae-file-hint">Max 2MB</span>
                    </div>
                    @error('image') <span class="ae-field-error">{{ $message }}</span> @enderror
                </div>

            </div>

            {{-- Submit --}}
            <div class="ae-submit-wrap">
                <a href="{{ route('account.index') }}" class="ae-btn ae-btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back
                </a>
                <button type="submit" class="ae-btn ae-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="20 6 9 17 4 12"/></svg>
                    Update Account
                </button>
            </div>

        </form>
    </div>
</div>

<style>
.acc-edit-page {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #0f172a;
    --clr-card: rgba(255,255,255,0.06);
    --clr-border: rgba(255,255,255,0.08);
    --clr-text: #f1f5f9;
    --clr-text-secondary: #94a3b8;
    --clr-danger: #ef4444;
    --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    --radius: 16px;
    --radius-sm: 10px;
    --radius-xs: 8px;

    font-family: var(--font);
    color: var(--clr-text);
    -webkit-font-smoothing: antialiased;
    position: relative;
    max-width: 820px;
    margin: 0 auto;
    padding: 32px 28px 48px;
    min-height: calc(100vh - 80px);
    overflow: hidden;
    background: var(--clr-bg);
}

/* ── Orbs ── */
.ae-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
}
.ae-orb-1 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(37,99,235,0.2), transparent 70%);
    top: -80px; left: -80px;
    animation: aeFloat 8s ease-in-out infinite;
}
.ae-orb-2 {
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(96,165,250,0.15), transparent 70%);
    bottom: -60px; right: -60px;
    animation: aeFloat 10s ease-in-out infinite reverse;
}
.ae-orb-3 {
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(30,64,175,0.12), transparent 70%);
    top: 50%; left: 50%;
    animation: aeFloat 12s ease-in-out infinite 3s;
}
@keyframes aeFloat {
    0%,100%{ transform: translate(0,0) scale(1); }
    33%{ transform: translate(30px,-30px) scale(1.1); }
    66%{ transform: translate(-20px,20px) scale(0.95); }
}

.page-header {
    position: relative;
    z-index: 2;
    margin-bottom: 28px;
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

.ae-card {
    position: relative;
    z-index: 2;
    background: var(--clr-card);
    backdrop-filter: blur(24px) saturate(1.4);
    -webkit-backdrop-filter: blur(24px) saturate(1.4);
    border: 1px solid var(--clr-border);
    border-radius: var(--radius);
    padding: 36px 32px;
    overflow: hidden;
    transition: transform .3s ease, box-shadow .3s ease;
}
.ae-card:hover {
    box-shadow: 0 20px 60px rgba(37,99,235,0.08);
}
.ae-card-bg-shine {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 70% 30%, rgba(96,165,250,0.05), transparent 60%);
    pointer-events: none;
}

.ae-form {
    position: relative;
    z-index: 1;
}

.ae-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.ae-field-full {
    grid-column: 1 / -1;
}

.ae-label {
    display: block;
    font-size: .75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: var(--clr-text-secondary);
    margin-bottom: 8px;
}

.ae-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.ae-input-icon {
    position: absolute;
    left: 14px;
    color: var(--clr-text-secondary);
    pointer-events: none;
    flex-shrink: 0;
}

.ae-input {
    width: 100%;
    padding: 12px 14px 12px 42px;
    background: rgba(255,255,255,0.05);
    border: 1.5px solid var(--clr-border);
    border-radius: var(--radius-xs);
    font-size: .85rem;
    font-family: var(--font);
    color: var(--clr-text);
    outline: none;
    transition: all .25s ease;
}
.ae-input::placeholder { color: rgba(148,163,184,0.5); }
.ae-input:focus {
    border-color: var(--clr-primary);
    background: rgba(255,255,255,0.08);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
}
.ae-input-error {
    border-color: var(--clr-danger);
}
.ae-input-error:focus {
    border-color: var(--clr-danger);
    box-shadow: 0 0 0 4px rgba(239,68,68,0.15);
}

.ae-field-error {
    display: block;
    font-size: .72rem;
    color: var(--clr-danger);
    margin-top: 5px;
    font-weight: 500;
}

/* ── File Upload ── */
.ae-file-wrap {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.ae-file-preview {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid var(--clr-border);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.04);
}
.ae-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.ae-preview-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    color: var(--clr-text-secondary);
    font-size: .68rem;
}
.ae-preview-placeholder svg { width: 28px; height: 28px; }
.ae-file-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255,255,255,0.06);
    border: 1.5px dashed var(--clr-border);
    border-radius: var(--radius-xs);
    color: var(--clr-light);
    font-size: .82rem;
    font-weight: 500;
    cursor: pointer;
    transition: all .25s ease;
}
.ae-file-btn:hover {
    background: rgba(255,255,255,0.1);
    border-color: var(--clr-light);
    color: #93c5fd;
}
.ae-file-hint {
    font-size: .7rem;
    color: var(--clr-text-secondary);
}

/* ── Submit ── */
.ae-submit-wrap {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid var(--clr-border);
}
.ae-btn {
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
    white-space: nowrap;
}
.ae-btn-primary {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}
.ae-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(37,99,235,0.45);
    color: #fff;
}
.ae-btn-secondary {
    background: rgba(255,255,255,0.06);
    border: 1.5px solid var(--clr-border);
    color: var(--clr-text-secondary);
}
.ae-btn-secondary:hover {
    background: rgba(255,255,255,0.1);
    color: var(--clr-text);
}

.animate-in {
    animation: aeFadeUp .6s cubic-bezier(.16,1,.3,1) forwards;
    opacity: 0;
}
@keyframes aeFadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .acc-edit-page { padding: 20px 16px 36px; }
    .ae-card { padding: 24px 20px; }
    .ae-form-grid { gap: 14px; }
    .page-header h1 { font-size: 1.4rem; }
    .page-header h1::before { height: 22px; }
}
@media (max-width: 640px) {
    .acc-edit-page { padding: 16px 12px 28px; }
    .page-header h1 { font-size: 1.25rem; }
    .page-header .sub { font-size: 0.8rem; padding-left: 12px; }
    .ae-card { padding: 20px 14px; border-radius: 14px; }
    .ae-form-grid { grid-template-columns: 1fr; }
    .ae-field { margin-bottom: 0; }
    .ae-label { font-size: 0.7rem; margin-bottom: 6px; }
    .ae-input { padding: 10px 12px 10px 36px; font-size: 0.8rem; }
    .ae-input-icon { left: 10px; width: 14px; height: 14px; }
    .ae-file-wrap { justify-content: center; flex-direction: column; align-items: center; gap: 10px; }
    .ae-file-preview { width: 76px; height: 76px; }
    .ae-file-btn { padding: 8px 14px; font-size: 0.78rem; }
    .ae-file-hint { font-size: 0.65rem; }
    .ae-submit-wrap { flex-direction: column-reverse; gap: 8px; margin-top: 20px; padding-top: 16px; }
    .ae-btn { justify-content: center; width: 100%; padding: 10px 20px; font-size: 0.8rem; }
}
@media (max-width: 400px) {
    .acc-edit-page { padding: 12px 8px 24px; }
    .page-header { margin-bottom: 18px; }
    .page-header h1 { font-size: 1.1rem; }
    .page-header h1::before { height: 18px; width: 3px; }
    .ae-card { padding: 16px 10px; border-radius: 12px; }
    .ae-input { padding: 8px 10px 8px 32px; font-size: 0.75rem; }
}

::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.3); border-radius: 10px; }
::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,0.5); }
</style>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('previewPlaceholder');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Success toast
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

    // Validation errors toast
    var validationErrors = document.getElementById('validationErrors');
    if (validationErrors) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: validationErrors.value,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#1e293b',
            color: '#fca5a5',
            iconColor: '#ef4444',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }
});
</script>

@endsection
