@extends('frontend.app')

@section('content')

<div class="cl-settings">
    <div class="cl-settings-card">
        <div class="cl-settings-header">
            <a href="{{ route('profile.show', $user->id) }}" class="cl-settings-back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="cl-settings-header-left">
                <div class="cl-settings-icon"><i class="bi bi-sliders2"></i></div>
                <div>
                    <h5 class="cl-settings-title">Profile Settings</h5>
                    <span class="cl-settings-sub">Manage your profile information</span>
                </div>
            </div>
        </div>

        <div class="cl-settings-body">
            @if (session('success'))
            <div class="cl-settings-toast">
                <div class="cl-settings-toast-icon"><i class="bi bi-check-circle-fill"></i></div>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="redirect_to" value="settings">

                <div class="cl-settings-grid">
                    <div class="cl-settings-field">
                        <label><i class="bi bi-person"></i> Display Name</label>
                        <div class="cl-settings-input-wrap">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" maxlength="255" required placeholder="Enter your full name" class="@error('name') is-invalid @enderror">
                            <div class="cl-settings-input-focus-ring"></div>
                            @error('name') <span class="cl-settings-field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="cl-settings-field">
                        <label><i class="bi bi-image"></i> Profile Picture</label>
                        <div class="cl-settings-upload-wrap">
                            <input type="file" name="avatar" accept="image/*" id="avatarInput" class="cl-settings-upload-input">
                            <label for="avatarInput" class="cl-settings-upload-label">
                                <div class="cl-settings-upload-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                                <div class="cl-settings-upload-text">
                                    <span class="cl-settings-upload-title">Choose an image</span>
                                    <span class="cl-settings-upload-hint">JPEG, PNG, GIF, WebP (max 5MB)</span>
                                </div>
                            </label>
                            <div class="cl-settings-upload-preview" id="avatarPreview">
                                <img src="" alt="Preview" id="avatarPreviewImg">
                                <button type="button" class="cl-settings-upload-preview-remove" id="avatarPreviewRemove" title="Remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        @error('avatar') <span class="cl-settings-field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                    </div>
                </div>

                @if ($user->avatar_path)
                <label class="cl-settings-checkbox">
                    <input type="checkbox" name="remove_avatar" value="1">
                    <span class="cl-settings-checkbox-mark">
                        <i class="bi bi-trash3"></i>
                    </span>
                    <span>Remove current picture</span>
                </label>
                @endif

                <div class="cl-settings-footer">
                    <button type="submit" class="cl-settings-btn cl-settings-btn-primary">
                        <i class="bi bi-check2"></i>
                        <span>Update Profile</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
:root {
    --cl-settings-bg: #f0f2f5;
    --cl-settings-surface: #ffffff;
    --cl-settings-surface-alt: #f8f9fa;
    --cl-settings-border: #e4e6eb;
    --cl-settings-border-light: #f0f0f2;
    --cl-settings-text: #050505;
    --cl-settings-text-secondary: #65676b;
    --cl-settings-text-muted: #8a8d91;
    --cl-settings-primary: #2563eb;
    --cl-settings-primary-dark: #1d4ed8;
    --cl-settings-primary-subtle: rgba(37,99,235,0.08);
    --cl-settings-success: #10b981;
    --cl-settings-success-subtle: rgba(16,185,129,0.1);
    --cl-settings-danger: #ef4444;
    --cl-settings-danger-subtle: rgba(239,68,68,0.08);
    --cl-settings-radius: 20px;
    --cl-settings-radius-sm: 14px;
    --cl-settings-radius-xs: 10px;
    --cl-settings-radius-pill: 9999px;
    --cl-settings-shadow: 0 2px 8px rgba(0,0,0,0.04);
    --cl-settings-shadow-md: 0 8px 24px rgba(0,0,0,0.06);
    --cl-settings-shadow-lg: 0 16px 48px rgba(0,0,0,0.08);
    --cl-settings-transition: 0.3s cubic-bezier(.4,0,.2,1);
    --cl-settings-spring: 0.5s cubic-bezier(.34,1.56,.64,1);
    --cl-settings-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.cl-settings {
    min-height: 100dvh;
    background: var(--cl-settings-bg);
    font-family: var(--cl-settings-font);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 3rem 1rem;
}

.cl-settings-card {
    width: 100%;
    max-width: 560px;
    background: var(--cl-settings-surface);
    border: 1px solid var(--cl-settings-border);
    border-radius: var(--cl-settings-radius);
    box-shadow: var(--cl-settings-shadow-lg);
    overflow: hidden;
    animation: settingsSlideUp 0.5s cubic-bezier(.16,1,.3,1) backwards;
}

@keyframes settingsSlideUp {
    from { opacity: 0; transform: translateY(20px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.cl-settings-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--cl-settings-border);
}

.cl-settings-back {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: var(--cl-settings-bg);
    color: var(--cl-settings-text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    flex-shrink: 0;
}

.cl-settings-back:hover {
    background: var(--cl-settings-primary-subtle);
    color: var(--cl-settings-primary);
}

.cl-settings-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.cl-settings-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--cl-settings-primary-subtle);
    color: var(--cl-settings-primary);
    font-size: 1.05rem;
    flex-shrink: 0;
}

.cl-settings-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--cl-settings-text);
    margin: 0;
}

.cl-settings-sub {
    display: block;
    font-size: 0.75rem;
    color: var(--cl-settings-text-muted);
    margin-top: 1px;
}

.cl-settings-body {
    padding: 1.5rem;
}

.cl-settings-toast {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: var(--cl-settings-success-subtle);
    border: 1px solid rgba(16,185,129,0.2);
    border-radius: var(--cl-settings-radius-xs);
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--cl-settings-text);
    margin-bottom: 1.25rem;
    animation: toastSlideIn 0.4s cubic-bezier(.16,1,.3,1) backwards;
}

.cl-settings-toast-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--cl-settings-success-subtle);
    color: var(--cl-settings-success);
    flex-shrink: 0;
}

@keyframes toastSlideIn {
    from { opacity: 0; transform: translateY(-12px); }
    to { opacity: 1; transform: translateY(0); }
}

.cl-settings-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    margin-bottom: 1rem;
}

.cl-settings-field label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--cl-settings-text-secondary);
    margin-bottom: 6px;
}

.cl-settings-field label i { color: var(--cl-settings-primary); font-size: 0.8rem; }

.cl-settings-input-wrap {
    position: relative;
}

.cl-settings-input-wrap input {
    width: 100%;
    padding: 0.65rem 0.85rem;
    border: 1.5px solid var(--cl-settings-border);
    border-radius: var(--cl-settings-radius-xs);
    background: var(--cl-settings-bg);
    color: var(--cl-settings-text);
    font-size: 0.88rem;
    transition: all 0.25s ease;
    outline: none;
    font-family: inherit;
    box-sizing: border-box;
    position: relative;
    z-index: 1;
}

.cl-settings-input-focus-ring {
    position: absolute;
    inset: -3px;
    border-radius: calc(var(--cl-settings-radius-xs) + 3px);
    border: 2px solid var(--cl-settings-primary);
    opacity: 0;
    transition: opacity 0.25s ease;
    pointer-events: none;
}

.cl-settings-input-wrap input:focus {
    border-color: var(--cl-settings-primary);
    background: var(--cl-settings-surface);
}

.cl-settings-input-wrap input:focus ~ .cl-settings-input-focus-ring {
    opacity: 0.3;
}

.cl-settings-input-wrap input.is-invalid {
    border-color: var(--cl-settings-danger);
    background: #fef2f2;
}

.cl-settings-field-error {
    display: flex;
    align-items: center;
    gap: 4px;
    color: var(--cl-settings-danger);
    font-size: 0.72rem;
    font-weight: 500;
    margin-top: 4px;
}

.cl-settings-field-error i { font-size: 0.7rem; }

.cl-settings-upload-wrap {
    position: relative;
}

.cl-settings-upload-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.cl-settings-upload-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.85rem 1rem;
    border: 1.5px dashed var(--cl-settings-border);
    border-radius: var(--cl-settings-radius-xs);
    background: var(--cl-settings-bg);
    color: var(--cl-settings-text-muted);
    transition: all 0.25s ease;
    cursor: pointer;
}

.cl-settings-upload-label:hover {
    border-color: var(--cl-settings-primary);
    background: var(--cl-settings-primary-subtle);
}

.cl-settings-upload-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--cl-settings-primary-subtle);
    color: var(--cl-settings-primary);
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.cl-settings-upload-label:hover .cl-settings-upload-icon {
    transform: scale(1.05);
    background: rgba(37,99,235,0.12);
}

.cl-settings-upload-title {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--cl-settings-text);
}

.cl-settings-upload-hint {
    display: block;
    font-size: 0.68rem;
    color: var(--cl-settings-text-muted);
    margin-top: 2px;
}

.cl-settings-upload-preview {
    display: none;
    margin-top: 0.75rem;
    position: relative;
    border-radius: var(--cl-settings-radius-sm);
    overflow: hidden;
    border: 2px solid var(--cl-settings-border);
    background: var(--cl-settings-bg);
    animation: settingsPreviewAppear 0.3s cubic-bezier(.16,1,.3,1);
}

.cl-settings-upload-preview.is-visible {
    display: block;
}

.cl-settings-upload-preview img {
    width: 100%;
    max-height: 200px;
    object-fit: contain;
    display: block;
    background: var(--cl-settings-bg);
}

.cl-settings-upload-preview-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(0,0,0,0.55);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
    backdrop-filter: blur(4px);
}

.cl-settings-upload-preview-remove:hover {
    background: rgba(239,68,68,0.85);
    transform: scale(1.1);
}

@keyframes settingsPreviewAppear {
    from { opacity: 0; transform: translateY(8px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.cl-settings-checkbox {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.82rem;
    color: var(--cl-settings-danger);
    font-weight: 500;
    cursor: pointer;
    margin-bottom: 1rem;
    padding: 8px 14px;
    border-radius: var(--cl-settings-radius-xs);
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.cl-settings-checkbox:hover {
    background: var(--cl-settings-danger-subtle);
    border-color: rgba(239,68,68,0.15);
}

.cl-settings-checkbox input {
    display: none;
}

.cl-settings-checkbox-mark {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid var(--cl-settings-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    transition: all 0.2s ease;
    color: transparent;
    flex-shrink: 0;
}

.cl-settings-checkbox input:checked + .cl-settings-checkbox-mark {
    background: var(--cl-settings-danger);
    border-color: var(--cl-settings-danger);
    color: #fff;
}

.cl-settings-footer {
    display: flex;
    justify-content: flex-end;
}

.cl-settings-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0.75rem 1.75rem;
    border: none;
    border-radius: var(--cl-settings-radius-xs);
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--cl-settings-transition);
    text-decoration: none;
    font-family: inherit;
    position: relative;
    overflow: hidden;
    -webkit-font-smoothing: antialiased;
}

.cl-settings-btn-primary {
    background: linear-gradient(135deg, var(--cl-settings-primary), var(--cl-settings-primary-dark));
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.25);
}

.cl-settings-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.35);
    color: #fff;
}

@media (max-width: 480px) {
    .cl-settings { padding: 1.5rem 0.75rem; }
    .cl-settings-header { padding: 1rem; }
    .cl-settings-body { padding: 1rem; }
}
</style>

<script>
document.addEventListener('change', function (e) {
    const input = e.target.closest('.cl-settings-upload-input');
    if (!input) return;

    const wrap = input.closest('.cl-settings-upload-wrap');
    const titleEl = wrap?.querySelector('.cl-settings-upload-title');
    const hintEl = wrap?.querySelector('.cl-settings-upload-hint');
    const preview = wrap?.querySelector('.cl-settings-upload-preview');
    const previewImg = wrap?.querySelector('.cl-settings-upload-preview img');

    if (input.files.length > 0) {
        const file = input.files[0];
        if (titleEl) titleEl.textContent = file.name;
        if (hintEl) hintEl.textContent = `${(file.size / 1024 / 1024).toFixed(1)} MB`;

        if (preview && previewImg) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                previewImg.src = ev.target.result;
                preview.classList.add('is-visible');
            };
            reader.readAsDataURL(file);
        }
    } else {
        if (titleEl) titleEl.textContent = 'Choose an image';
        if (hintEl) hintEl.textContent = 'JPEG, PNG, GIF, WebP (max 5MB)';
        if (preview) {
            preview.classList.remove('is-visible');
            if (previewImg) previewImg.src = '';
        }
    }
});

document.addEventListener('click', function (e) {
    const removeBtn = e.target.closest('#avatarPreviewRemove');
    if (!removeBtn) return;

    const wrap = removeBtn.closest('.cl-settings-upload-wrap');
    const input = wrap?.querySelector('.cl-settings-upload-input');
    const preview = wrap?.querySelector('.cl-settings-upload-preview');
    const previewImg = wrap?.querySelector('.cl-settings-upload-preview img');
    const titleEl = wrap?.querySelector('.cl-settings-upload-title');
    const hintEl = wrap?.querySelector('.cl-settings-upload-hint');

    if (input) input.value = '';
    if (preview) preview.classList.remove('is-visible');
    if (previewImg) previewImg.src = '';
    if (titleEl) titleEl.textContent = 'Choose an image';
    if (hintEl) hintEl.textContent = 'JPEG, PNG, GIF, WebP (max 5MB)';
});
</script>

@endsection
