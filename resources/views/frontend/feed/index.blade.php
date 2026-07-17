@extends('frontend.app')

@section('content')

<div class="connectly-feed-page">
    <div class="connectly-feed-bg-glow"></div>
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show connectly-feed-alert" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Composer Card -->
                <div class="connectly-composer-card">
                    <div class="d-flex align-items-start gap-3">
                        @if(auth()->user()->avatar_path)
                            <img src="{{ route('media.show', ['path' => auth()->user()->avatar_path]) }}"
                                 alt="My avatar"
                                 class="connectly-feed-avatar connectly-feed-avatar-image">
                        @else
                            <div class="connectly-feed-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold connectly-composer-name">{{ auth()->user()->name }}</h6>
                            <p class="mb-3 text-muted small connectly-composer-hint">What's on your mind?</p>

                            <form action="{{ route('feed.posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <textarea
                                    name="content"
                                    class="form-control connectly-feed-textarea @error('content') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Write a post..."
                                    maxlength="600"
                                >{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-3">
                                    <label class="form-label small fw-semibold text-muted mb-1 connectly-image-label">
                                        <i class="bi bi-image me-1"></i>Add Image (optional)
                                    </label>
                                    <div class="connectly-file-upload">
                                        <input
                                            type="file"
                                            name="image"
                                            accept="image/*"
                                            class="connectly-file-input @error('image') is-invalid @enderror"
                                            id="composerImageInput"
                                        >
                                        <label for="composerImageInput" class="connectly-file-label">
                                            <i class="bi bi-cloud-arrow-up me-2"></i>
                                            <span>Choose an image</span>
                                        </label>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text connectly-form-text">You can post without image.</div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn connectly-feed-post-btn">
                                        <i class="bi bi-send-fill me-2"></i>Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Posts List -->
                <div class="mt-4 d-flex flex-column gap-3">
                    @forelse ($posts as $post)
                        @include('frontend.partials.post', ['post' => $post, 'showPinButton' => false])
                    @empty
                        <div class="connectly-post-card text-center py-5">
                            <i class="bi bi-journal-text" style="font-size: 2.5rem; color: #94a3b8; display: block; margin-bottom: 0.75rem;"></i>
                            <p class="mb-0 text-muted">No posts yet. Be the first one to share something!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Search Card -->
                <div class="connectly-side-card">
                    <h6 class="fw-bold mb-3 connectly-side-card-title">
                        <i class="bi bi-search-heart me-2 connectly-side-icon-search"></i>Search
                    </h6>
                    <form action="{{ route('search') }}" method="GET">
                        <div class="connectly-search-group">
                            <i class="bi bi-search connectly-search-group-icon"></i>
                            <input
                                type="text"
                                name="q"
                                class="connectly-search-input"
                                placeholder="Search users, posts..."
                                autocomplete="off"
                            >
                            <button type="submit" class="connectly-search-btn">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Feed Tips Card -->
                <div class="connectly-side-card mt-3">
                    <h6 class="fw-bold mb-3 connectly-side-card-title">
                        <i class="bi bi-lightbulb me-2 connectly-side-icon-tips"></i>Feed Tips
                    </h6>
                    <ul class="mb-0 connectly-tips-list">
                        <li>
                            <span class="connectly-tips-bullet"></span>
                            Keep posts short to improve readability.
                        </li>
                        <li>
                            <span class="connectly-tips-bullet"></span>
                            Use reactions to engage with other people quickly.
                        </li>
                        <li>
                            <span class="connectly-tips-bullet"></span>
                            Add comments to start meaningful discussions.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== CONNECTLY FEED PAGE — PREMIUM DARK THEME ===== */

:root {
    --feed-bg: #0b1121;
    --feed-surface: rgba(255,255,255,0.04);
    --feed-border: rgba(255,255,255,0.06);
    --feed-text: #f1f5f9;
    --feed-muted: #94a3b8;
    --feed-primary: #2563EB;
    --feed-primary-light: #60A5FA;
    --feed-primary-dark: #1E40AF;
    --feed-input-bg: rgba(255,255,255,0.05);
    --feed-input-border: rgba(255,255,255,0.08);
    --feed-radius: 16px;
    --feed-radius-sm: 10px;
}

.connectly-feed-page {
    min-height: 100%;
    background: var(--feed-bg);
    position: relative;
    overflow: hidden;
}

/* Background glow */
.connectly-feed-bg-glow {
    position: fixed;
    top: -200px;
    left: -100px;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(37,99,235,0.08), transparent 70%);
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
    z-index: 0;
    animation: feedGlowFloat1 12s ease-in-out infinite;
}

@keyframes feedGlowFloat1 {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(60px,40px) scale(1.1); }
}

/* ===== ALERT ===== */
.connectly-feed-alert {
    border-radius: var(--feed-radius-sm, 10px);
    border: 1px solid rgba(16,185,129,0.2);
    background: rgba(16,185,129,0.08);
    color: #34d399;
    font-weight: 500;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    animation: connectlyAlertSlideIn 0.4s ease-out;
}
.connectly-feed-alert .btn-close {
    filter: invert(0.8) brightness(1.5);
}

@keyframes connectlyAlertSlideIn {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* ===== COMPOSER CARD ===== */
.connectly-composer-card {
    background: var(--feed-surface);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(.16,1,.3,1);
    animation: feedCardSlideUp 0.5s ease-out;
}

/* Animated gradient border */
.connectly-composer-card::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: var(--feed-radius);
    padding: 1px;
    background: linear-gradient(135deg, rgba(37,99,235,0.3), rgba(96,165,250,0.1), rgba(37,99,235,0.05), rgba(96,165,250,0.2));
    background-size: 300% 300%;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    animation: feedBorderGlow 6s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
    opacity: 0.5;
    transition: opacity 0.4s ease;
}
.connectly-composer-card:hover::before {
    opacity: 1;
}

@keyframes feedBorderGlow {
    0%,100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.connectly-composer-card:hover {
    border-color: rgba(37,99,235,0.15);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3), 0 0 40px rgba(37,99,235,0.05);
    transform: translateY(-2px);
}

.connectly-composer-name {
    color: var(--feed-text);
    font-size: 0.95rem;
}

.connectly-composer-hint {
    font-size: 0.8rem;
    color: var(--feed-muted) !important;
}

/* ===== AVATAR ===== */
.connectly-feed-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    color: #ffffff;
    background: linear-gradient(135deg, var(--feed-primary) 0%, var(--feed-primary-dark) 100%);
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.3);
}

.connectly-feed-avatar-alt {
    background: linear-gradient(135deg, #475569 0%, #1e293b 100%);
}

.connectly-feed-avatar-image {
    object-fit: cover;
    border: 2px solid rgba(37,99,235,0.2);
    background: var(--feed-bg);
}

/* ===== TEXTAREA ===== */
.connectly-feed-textarea {
    border-radius: var(--feed-radius-sm);
    border: 1.5px solid var(--feed-input-border);
    padding: 0.9rem 1rem;
    resize: none;
    font-size: 0.9rem;
    background: var(--feed-input-bg);
    color: var(--feed-text);
    transition: all 0.3s cubic-bezier(.16,1,.3,1);
}

.connectly-feed-textarea:focus {
    border-color: var(--feed-primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
    background: rgba(37,99,235,0.05);
}

.connectly-feed-textarea::placeholder {
    color: #475569;
}

/* ===== FILE UPLOAD ===== */
.connectly-file-upload {
    position: relative;
}

.connectly-file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.connectly-file-label {
    display: flex;
    align-items: center;
    padding: 0.65rem 1rem;
    border: 1.5px dashed rgba(255,255,255,0.1);
    border-radius: var(--feed-radius-sm);
    background: rgba(255,255,255,0.03);
    color: var(--feed-muted);
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
}

.connectly-file-label:hover {
    border-color: var(--feed-primary);
    background: rgba(37,99,235,0.08);
    color: var(--feed-primary-light);
}

.connectly-image-label {
    color: var(--feed-muted);
    font-size: 0.8rem;
}

.connectly-form-text {
    font-size: 0.75rem;
    color: #475569;
}

/* ===== POST BUTTON ===== */
.connectly-feed-post-btn {
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark));
    color: #fff;
    border-radius: var(--feed-radius-sm);
    font-weight: 600;
    font-size: 0.85rem;
    padding: 0.6rem 1.5rem;
    border: none;
    transition: all 0.3s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
    position: relative;
    overflow: hidden;
}

.connectly-feed-post-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(37,99,235,0.4);
    color: #fff;
}

.connectly-feed-post-btn:active {
    transform: translateY(0);
}

/* ===== POST CARD ===== */
.connectly-post-card {
    background: var(--feed-surface);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.25rem 1.35rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(.16,1,.3,1);
    animation: feedCardSlideUp 0.5s ease-out backwards;
}

.connectly-post-card:nth-child(1) { animation-delay: 0.08s; }
.connectly-post-card:nth-child(2) { animation-delay: 0.16s; }
.connectly-post-card:nth-child(3) { animation-delay: 0.24s; }
.connectly-post-card:nth-child(4) { animation-delay: 0.32s; }
.connectly-post-card:nth-child(5) { animation-delay: 0.40s; }

.connectly-post-card:hover {
    border-color: rgba(37,99,235,0.12);
    box-shadow: 0 12px 40px rgba(0,0,0,0.3), 0 0 30px rgba(37,99,235,0.03);
    transform: translateY(-3px);
}

@keyframes feedCardSlideUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== POST TEXT ===== */
.connectly-post-text {
    color: var(--feed-text);
    line-height: 1.7;
    white-space: pre-line;
    font-size: 0.92rem;
}

/* ===== SIDE CARDS ===== */
.connectly-side-card {
    background: var(--feed-surface);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.3rem;
    position: relative;
    overflow: hidden;
    animation: feedCardSlideUp 0.6s ease-out;
}

.connectly-side-card::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: var(--feed-radius);
    padding: 1px;
    background: linear-gradient(135deg, rgba(37,99,235,0.2), transparent, rgba(37,99,235,0.1));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
    z-index: 0;
    opacity: 0.4;
}

.connectly-side-card-title {
    color: var(--feed-text);
    font-size: 0.92rem;
    position: relative;
    z-index: 1;
}

.connectly-side-icon-search {
    color: var(--feed-primary-light);
    font-size: 1.05rem;
}

.connectly-side-icon-tips {
    color: #fbbf24;
    font-size: 1.05rem;
}

/* ===== SEARCH GROUP ===== */
.connectly-search-group {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.04);
    border: 1.5px solid rgba(255,255,255,0.08);
    border-radius: var(--feed-radius-sm);
    padding: 0.1rem;
    transition: all 0.3s cubic-bezier(.16,1,.3,1);
}

.connectly-search-group:focus-within {
    border-color: var(--feed-primary);
    background: rgba(37,99,235,0.05);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}

.connectly-search-group-icon {
    position: absolute;
    left: 12px;
    color: #64748b;
    font-size: 0.9rem;
    pointer-events: none;
    transition: color 0.25s ease;
}

.connectly-search-group:focus-within .connectly-search-group-icon {
    color: var(--feed-primary-light);
}

.connectly-search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 0.7rem 2.8rem 0.7rem 2.2rem;
    font-size: 0.85rem;
    color: var(--feed-text);
    background: transparent;
    border-radius: 8px;
}

.connectly-search-input::placeholder {
    color: #475569;
}

.connectly-search-btn {
    position: absolute;
    right: 4px;
    width: 34px;
    height: 34px;
    border: none;
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark));
    color: #fff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
}

.connectly-search-btn:hover {
    background: linear-gradient(135deg, var(--feed-primary-dark), #153e75);
    transform: scale(1.05);
}

.connectly-search-btn:active {
    transform: scale(0.95);
}

/* ===== TIPS LIST ===== */
.connectly-tips-list {
    padding-left: 0;
    list-style: none;
    color: #cbd5e1;
    line-height: 1.8;
    font-size: 0.85rem;
    position: relative;
    z-index: 1;
}

.connectly-tips-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}

.connectly-tips-list li:last-child {
    border-bottom: none;
}

.connectly-tips-bullet {
    display: inline-flex;
    width: 8px;
    height: 8px;
    min-width: 8px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--feed-primary-light), var(--feed-primary));
    margin-top: 8px;
    box-shadow: 0 1px 6px rgba(37,99,235,0.4);
}

/* ===== POST IMAGE ===== */
.connectly-post-image {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    border-radius: var(--feed-radius-sm);
    border: 1px solid rgba(255,255,255,0.06);
    transition: transform 0.4s ease;
}

.connectly-post-image:hover {
    transform: scale(1.01);
}

/* ===== REACTION PICKER ===== */
.connectly-reaction-picker {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.connectly-reaction-options {
    position: absolute;
    left: 0;
    bottom: calc(100% + 4px);
    display: flex;
    gap: 0.35rem;
    padding: 0.4rem 0.5rem;
    background: rgba(30,41,59,0.95);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 999px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(8px) scale(0.95);
    transition: all 0.2s cubic-bezier(.16,1,.3,1);
    z-index: 25;
}

.connectly-reaction-options::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: -12px;
    height: 12px;
}

.connectly-reaction-picker:hover .connectly-reaction-options,
.connectly-reaction-picker:focus-within .connectly-reaction-options,
.connectly-reaction-options:hover {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0) scale(1);
}

.connectly-reaction-option {
    border: none;
    background: transparent;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-size: 1.1rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.15s ease, background-color 0.15s ease;
    cursor: pointer;
}

.connectly-reaction-option:hover {
    transform: scale(1.22);
    background: rgba(37,99,235,0.15);
}

.connectly-reaction-option.active {
    background: rgba(37,99,235,0.2);
}

/* ===== MAIN REACTION BUTTON ===== */
.connectly-main-reaction-btn {
    border-radius: 999px !important;
    padding: 0.3rem 0.85rem !important;
    font-size: 0.8rem !important;
    font-weight: 500 !important;
    transition: all 0.25s ease !important;
    border: 1.5px solid rgba(255,255,255,0.08) !important;
    background: rgba(255,255,255,0.04) !important;
    color: var(--feed-muted) !important;
}

.connectly-main-reaction-btn:hover {
    background: rgba(37,99,235,0.1) !important;
    border-color: rgba(37,99,235,0.25) !important;
    color: var(--feed-primary-light) !important;
    transform: translateY(-1px);
}

.connectly-main-reaction-btn.btn-primary {
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark)) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 3px 12px rgba(37,99,235,0.3);
}

.connectly-main-reaction-btn.btn-primary:hover {
    box-shadow: 0 5px 20px rgba(37,99,235,0.4);
}

/* ===== COMMENT BUTTON ===== */
.connectly-comment-btn {
    border-radius: 999px !important;
    padding: 0.3rem 0.85rem !important;
    font-size: 0.8rem !important;
    font-weight: 500 !important;
    border: 1.5px solid rgba(255,255,255,0.08) !important;
    background: rgba(255,255,255,0.04) !important;
    color: var(--feed-muted) !important;
    transition: all 0.25s ease !important;
}

.connectly-comment-btn:hover {
    background: rgba(37,99,235,0.1) !important;
    border-color: rgba(37,99,235,0.25) !important;
    color: var(--feed-primary-light) !important;
    transform: translateY(-1px);
}

/* ===== REACTION BADGES ===== */
.connectly-reaction-badge {
    background: rgba(255,255,255,0.04) !important;
    border: 1px solid rgba(255,255,255,0.06) !important;
    color: var(--feed-muted) !important;
    font-weight: 500 !important;
    font-size: 0.75rem !important;
    padding: 0.2rem 0.65rem !important;
    border-radius: 999px !important;
}

.connectly-reaction-badge-emoji {
    margin-right: 2px;
}

/* ===== PINNED BADGE ===== */
.connectly-pinned-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: rgba(251,191,36,0.12);
    color: #fbbf24;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 12px;
    border: 1px solid rgba(251,191,36,0.2);
}

/* ===== PROFILE LINK ===== */
.connectly-profile-link {
    color: var(--feed-primary-light);
    font-weight: 600;
    transition: color 0.2s ease;
}

.connectly-profile-link:hover {
    color: var(--feed-primary);
}

/* ===== COMMENT ITEM ===== */
.connectly-comment-item {
    padding: 0.85rem;
    border-radius: var(--feed-radius-sm);
    border: 1px solid rgba(255,255,255,0.05);
    background: rgba(255,255,255,0.02);
    transition: background 0.2s ease;
}

.connectly-comment-item:hover {
    background: rgba(255,255,255,0.04);
}

.connectly-comment-replies {
    margin-left: 1rem;
    padding-left: 0.9rem;
    border-left: 2px solid rgba(255,255,255,0.06);
}

.connectly-comment-reply-item {
    padding: 0.75rem;
    border-radius: var(--feed-radius-sm);
    border: 1px solid rgba(255,255,255,0.05);
    background: rgba(255,255,255,0.02);
}

.connectly-comment-image {
    width: 100%;
    max-width: 320px;
    max-height: 260px;
    object-fit: cover;
    border-radius: var(--feed-radius-sm);
    border: 1px solid rgba(255,255,255,0.06);
}

/* ===== COMMENT REACTION PICKER ===== */
.connectly-comment-reaction-picker {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.connectly-comment-reaction-options {
    position: absolute;
    left: 0;
    bottom: calc(100% + 4px);
    display: flex;
    gap: 0.3rem;
    padding: 0.35rem 0.45rem;
    background: rgba(30,41,59,0.95);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 999px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(8px) scale(0.95);
    transition: all 0.2s cubic-bezier(.16,1,.3,1);
    z-index: 35;
}

.connectly-comment-reaction-options::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: -12px;
    height: 12px;
}

.connectly-comment-reaction-picker:hover .connectly-comment-reaction-options,
.connectly-comment-reaction-picker:focus-within .connectly-comment-reaction-options,
.connectly-comment-reaction-options:hover {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0) scale(1);
}

.connectly-comment-reaction-option {
    border: none;
    background: transparent;
    border-radius: 50%;
    width: 34px;
    height: 34px;
    font-size: 1rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.15s ease, background-color 0.15s ease;
    cursor: pointer;
}

.connectly-comment-reaction-option:hover {
    transform: scale(1.22);
    background: rgba(37,99,235,0.15);
}

.connectly-comment-reaction-option.active {
    background: rgba(37,99,235,0.2);
}

.connectly-comment-main-reaction-btn {
    border-radius: 999px !important;
    padding: 0.2rem 0.7rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border: 1.5px solid rgba(255,255,255,0.08) !important;
    background: rgba(255,255,255,0.04) !important;
    color: var(--feed-muted) !important;
    transition: all 0.2s ease !important;
}

.connectly-comment-main-reaction-btn:hover {
    background: rgba(37,99,235,0.1) !important;
    border-color: rgba(37,99,235,0.25) !important;
    color: var(--feed-primary-light) !important;
}

.connectly-comment-main-reaction-btn.btn-primary {
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark)) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 3px 10px rgba(37,99,235,0.25);
}

.connectly-comment-main-reaction-btn.btn-primary:hover {
    box-shadow: 0 5px 16px rgba(37,99,235,0.35);
}

/* ===== REPLY TRIGGER ===== */
.connectly-reply-trigger {
    border-radius: 999px !important;
    padding: 0.2rem 0.7rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border: 1.5px solid rgba(255,255,255,0.08) !important;
    background: rgba(255,255,255,0.04) !important;
    color: var(--feed-muted) !important;
    transition: all 0.2s ease !important;
}

.connectly-reply-trigger:hover {
    background: rgba(37,99,235,0.1) !important;
    border-color: rgba(37,99,235,0.25) !important;
    color: var(--feed-primary-light) !important;
}

/* ===== REPLY INDICATOR ===== */
.connectly-reply-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.55rem 0.85rem;
    margin-bottom: 0.75rem;
    background: rgba(37,99,235,0.08);
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: var(--feed-radius-sm);
    color: var(--feed-primary-light);
    font-size: 0.82rem;
    font-weight: 500;
    animation: feedReplySlideIn 0.25s ease;
}

@keyframes feedReplySlideIn {
    from { transform: translateY(-6px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.connectly-reply-indicator-icon {
    color: var(--feed-primary-light);
    font-size: 0.85rem;
}

.connectly-reply-cancel-btn {
    background: transparent;
    border: none;
    color: var(--feed-muted);
    padding: 2px 6px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.7rem;
    transition: all 0.2s ease;
    line-height: 1;
}

.connectly-reply-cancel-btn:hover {
    background: rgba(37,99,235,0.15);
    color: var(--feed-primary-light);
}

/* ===== COMMENT SUBMIT ===== */
.connectly-comment-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark));
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    border-radius: var(--feed-radius-sm);
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 16px rgba(37,99,235,0.25);
}

.connectly-comment-submit-btn:hover {
    background: linear-gradient(135deg, var(--feed-primary-dark), #153e75);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(37,99,235,0.35);
    color: #fff;
}

.connectly-comment-submit-btn:active {
    transform: translateY(0);
}

/* ===== FILE INPUT WRAPPER ===== */
.connectly-file-input-wrapper {
    position: relative;
}

.connectly-file-input-hidden {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.connectly-file-label-comment {
    display: flex;
    align-items: center;
    padding: 0.55rem 0.9rem;
    border: 1.5px dashed rgba(255,255,255,0.1);
    border-radius: var(--feed-radius-sm);
    background: rgba(255,255,255,0.03);
    color: var(--feed-muted);
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.25s;
    cursor: pointer;
}

.connectly-file-label-comment:hover {
    border-color: var(--feed-primary);
    background: rgba(37,99,235,0.08);
    color: var(--feed-primary-light);
}

/* ===== TOAST ===== */
.connectly-toast-popup {
    border-radius: var(--feed-radius-sm) !important;
    box-shadow: 0 12px 40px rgba(0,0,0,0.4) !important;
    font-family: inherit !important;
    background: rgba(30,41,59,0.98) !important;
    backdrop-filter: blur(16px) !important;
    border: 1px solid rgba(255,255,255,0.06) !important;
    color: var(--feed-text) !important;
}

.connectly-toast-popup .swal2-title {
    font-size: 0.88rem !important;
    font-weight: 500 !important;
    color: var(--feed-text) !important;
}

.connectly-toast-popup .swal2-timer-progress-bar {
    background: var(--feed-primary) !important;
    height: 3px !important;
}

/* ===== DARK MODE COMPATIBILITY FOR BOOTSTRAP MODALS ===== */
.modal-content {
    background: rgba(15,23,42,0.98) !important;
    backdrop-filter: blur(24px) saturate(180%) !important;
    border: 1px solid rgba(255,255,255,0.08) !important;
    border-radius: var(--feed-radius) !important;
    color: var(--feed-text) !important;
}
.modal-header {
    border-bottom: 1px solid rgba(255,255,255,0.06) !important;
}
.modal-header .btn-close {
    filter: invert(0.7) brightness(1.5);
}
.modal-title {
    color: var(--feed-text) !important;
}
.modal-body .form-control {
    background: var(--feed-input-bg) !important;
    border: 1.5px solid var(--feed-input-border) !important;
    color: var(--feed-text) !important;
    border-radius: var(--feed-radius-sm) !important;
}
.modal-body .form-control:focus {
    border-color: var(--feed-primary) !important;
    box-shadow: 0 0 0 4px rgba(37,99,235,0.15) !important;
    background: rgba(37,99,235,0.05) !important;
}
.modal-body .form-check-label {
    color: var(--feed-muted) !important;
}
.modal-body .btn-primary {
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark)) !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(37,99,235,0.25) !important;
}
.modal-body .btn-primary:hover {
    box-shadow: 0 6px 18px rgba(37,99,235,0.35) !important;
    transform: translateY(-1px);
}
.modal-body .btn-outline-warning,
.modal-body .btn-warning {
    color: #fbbf24 !important;
    border-color: rgba(251,191,36,0.3) !important;
}
.modal-body .btn-outline-warning:hover,
.modal-body .btn-warning:hover {
    background: rgba(251,191,36,0.1) !important;
}
.modal-body .btn-warning {
    background: rgba(251,191,36,0.15) !important;
    border-color: rgba(251,191,36,0.3) !important;
}
.modal-body .btn-outline-secondary {
    color: var(--feed-muted) !important;
    border-color: rgba(255,255,255,0.1) !important;
}
.modal-body .btn-outline-secondary:hover {
    background: rgba(255,255,255,0.05) !important;
    color: var(--feed-text) !important;
}
.modal-body .btn-outline-danger {
    color: #ef4444 !important;
    border-color: rgba(239,68,68,0.3) !important;
}
.modal-body .btn-outline-danger:hover {
    background: rgba(239,68,68,0.1) !important;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991.98px) {
    .connectly-composer-card { padding: 1.2rem; }
}

@media (max-width: 576px) {
    .connectly-composer-card { padding: 1rem; }
    .connectly-post-card { padding: 1rem; }
    .connectly-side-card { padding: 1rem; }
    .connectly-feed-avatar { width: 40px; height: 40px; font-size: 0.95rem; }
}
</style>

<script>
    // Update file input label when a file is selected
    document.addEventListener('change', function(e) {
        if (e.target.matches('.chatbox-file-input') || e.target.matches('.connectly-file-input')) {
            const wrapper = e.target.closest('.connectly-file-upload') || e.target.closest('.chatbox-file-input-wrapper');
            const label = wrapper?.querySelector('.connectly-file-label span, .chatbox-file-label span');
            if (label && e.target.files.length > 0) {
                label.textContent = e.target.files[0].name;
                e.target.classList.add('has-file');
            } else if (label) {
                label.textContent = 'Choose an image';
                e.target.classList.remove('has-file');
            }
        }
    });

    // Toast notification helper using SweetAlert2
    function chatboxToast(icon, title) {
        if (typeof Swal === 'undefined') {
            console.warn('SweetAlert2 not loaded, falling back to alert');
            alert(title);
            return;
        }
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'connectly-toast-popup'
            }
        });
    }

    document.addEventListener('submit', async function (event) {
        const form = event.target;
        if (!form.matches('[data-reaction-form]')) {
            return;
        }

        event.preventDefault();

        const picker = form.closest('.connectly-reaction-picker') || form.closest('.chatbox-reaction-picker');
        if (!picker) {
            return;
        }

        const card = picker.closest('.connectly-post-card') || picker.closest('.chatbox-feed-post-card');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const buttons = picker.querySelectorAll('button');

        buttons.forEach((button) => {
            button.disabled = true;
        });

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(form),
            });

            if (!response.ok) {
                throw new Error('Failed to submit reaction');
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error('Invalid reaction response');
            }

            const reactionMeta = {
                like: { label: 'Like', emoji: '👍' },
                love: { label: 'Love', emoji: '❤️' },
                haha: { label: 'Haha', emoji: '😆' },
                wow: { label: 'Wow', emoji: '😮' },
                sad: { label: 'Sad', emoji: '😢' },
            };

            const currentReaction = data.current_reaction;
            const mainInput = picker.querySelector('.chatbox-main-reaction-input');
            const mainButton = picker.querySelector('.chatbox-main-reaction-button');
            const mainEmoji = picker.querySelector('.chatbox-main-reaction-emoji');
            const mainLabel = picker.querySelector('.chatbox-main-reaction-label');
            const mainCount = picker.querySelector('.chatbox-main-reaction-count');

            if (mainInput) {
                mainInput.value = currentReaction || 'like';
            }

            if (mainButton) {
                mainButton.classList.toggle('btn-primary', !!currentReaction);
                mainButton.classList.toggle('btn-outline-primary', !currentReaction);
            }

            const meta = reactionMeta[currentReaction] || reactionMeta.like;
            if (mainEmoji) {
                mainEmoji.textContent = currentReaction ? meta.emoji : reactionMeta.like.emoji;
            }
            if (mainLabel) {
                mainLabel.textContent = currentReaction ? meta.label : 'Like';
            }
            if (mainCount) {
                mainCount.textContent = String(data.total_reactions ?? 0);
            }

            picker.querySelectorAll('.connectly-reaction-option, .chatbox-reaction-option').forEach((optionButton) => {
                optionButton.classList.toggle('active', optionButton.dataset.reactionKey === currentReaction);
            });

            if (card && data.reaction_counts) {
                Object.keys(reactionMeta).forEach((reactionKey) => {
                    const badge = card.querySelector(`[data-reaction-badge="${reactionKey}"]`);
                    if (!badge) {
                        return;
                    }

                    const count = Number(data.reaction_counts[reactionKey] || 0);
                    const countEl = badge.querySelector('.chatbox-reaction-badge-count');
                    if (countEl) {
                        countEl.textContent = String(count);
                    }

                    badge.classList.toggle('d-none', count <= 0);
                });
            }
        } catch (error) {
            console.error(error);
            chatboxToast('error', 'Could not update reaction. Please try again.');
        } finally {
            buttons.forEach((button) => {
                button.disabled = false;
            });
        }
    });

    const chatboxCommentReactionMeta = {
        like: { label: 'Like', emoji: '👍' },
        love: { label: 'Love', emoji: '❤️' },
        haha: { label: 'Haha', emoji: '😆' },
        wow: { label: 'Wow', emoji: '😮' },
        sad: { label: 'Sad', emoji: '😢' },
    };

    function chatboxEscapeHtml(text) {
        return String(text || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function chatboxNl2br(text) {
        return chatboxEscapeHtml(text).replace(/\n/g, '<br>');
    }

    function chatboxCommentCardHtml(comment, postId, parentForReply) {
        const safeName = chatboxEscapeHtml(comment.user_name || 'User');
        const safeTime = chatboxEscapeHtml(comment.created_at_human || 'Just now');
        const safeText = chatboxNl2br(comment.comment || '');
        const imageHtml = comment.image_url
            ? `<div class="mt-2"><img src="${chatboxEscapeHtml(comment.image_url)}" alt="Comment image" class="img-fluid rounded connectly-comment-image"></div>`
            : '';

        const reactionOptions = Object.entries(chatboxCommentReactionMeta).map(([key, meta]) => `
            <form action="/feed/comments/${comment.id}/react" method="POST" class="d-inline" data-comment-reaction-form="option">
                <input type="hidden" name="_token" value="${window.chatboxCsrfToken || ''}">
                <input type="hidden" name="reaction_type" value="${key}">
                <button type="submit" class="connectly-comment-reaction-option" title="${meta.label}" aria-label="${meta.label}" data-reaction-key="${key}">
                    ${meta.emoji}
                </button>
            </form>
        `).join('');

        const reactionBadges = Object.entries(chatboxCommentReactionMeta).map(([key, meta]) => `
            <span class="badge rounded-pill connectly-reaction-badge d-none" data-comment-reaction-badge="${key}">
                <span class="connectly-reaction-badge-emoji">${meta.emoji}</span>
                <span class="chatbox-comment-reaction-badge-count">0</span>
            </span>
        `).join('');

        return `
            <div class="${comment.parent_id ? 'connectly-comment-reply-item mt-2' : 'connectly-comment-item'}" data-comment-card="${comment.id}">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <strong>${safeName}</strong>
                    <span class="text-muted small">#${comment.user_id}</span>
                    <span class="text-muted small">${safeTime}</span>
                </div>
                ${safeText ? `<p class="mb-0 text-dark">${safeText}</p>` : ''}
                ${imageHtml}

                <div class="d-flex align-items-center gap-2 mt-2">
                    <div class="connectly-comment-reaction-picker" data-comment-id="${comment.id}">
                        <form action="/feed/comments/${comment.id}/react" method="POST" class="d-inline" data-comment-reaction-form="main">
                            <input type="hidden" name="_token" value="${window.chatboxCsrfToken || ''}">
                            <input type="hidden" name="reaction_type" value="like" class="chatbox-comment-main-reaction-input">
                            <button type="submit" class="btn btn-sm connectly-comment-main-reaction-btn btn-outline-primary">
                                <span class="me-1 chatbox-comment-main-reaction-emoji">👍</span>
                                <span class="chatbox-comment-main-reaction-label">Like</span>
                                (<span class="chatbox-comment-main-reaction-count">0</span>)
                            </button>
                        </form>
                        <div class="connectly-comment-reaction-options" aria-label="Comment reaction options">
                            ${reactionOptions}
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn btn-sm connectly-reply-trigger"
                        data-form-id="commentForm${postId}"
                        data-parent-id="${parentForReply}"
                    >
                        Reply
                    </button>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                    ${reactionBadges}
                </div>

                ${comment.parent_id ? '' : `<div class="connectly-comment-replies mt-3 d-none" data-replies-for="${comment.id}"></div>`}
            </div>
        `;
    }

    document.addEventListener('submit', async function (event) {
        const form = event.target;
        if (!form.matches('[data-comment-form-id]')) {
            return;
        }

        event.preventDefault();

        const postId = form.dataset.commentFormId;
        const modalBody = form.closest('.modal-body');
        if (!postId || !modalBody) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        window.chatboxCsrfToken = csrfToken;

        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) submitButton.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(form),
            });

            const data = await response.json();
            if (!response.ok || !data.success) {
                const errorText = data?.message || 'Could not add comment.';
                chatboxToast('error', errorText);
                return;
            }

            const comment = data.comment;
            const commentList = modalBody.querySelector(`#commentsList${postId}`);
            const emptyState = modalBody.querySelector(`#commentsEmpty${postId}`);

            if (comment.parent_id) {
                const repliesWrap = modalBody.querySelector(`[data-replies-for="${comment.root_parent_id}"]`);
                if (repliesWrap) {
                    repliesWrap.classList.remove('d-none');
                    repliesWrap.insertAdjacentHTML('afterbegin', chatboxCommentCardHtml(comment, postId, comment.root_parent_id));
                }
            } else if (commentList) {
                commentList.classList.remove('d-none');
                commentList.insertAdjacentHTML('afterbegin', chatboxCommentCardHtml(comment, postId, comment.id));
            }

            if (emptyState) {
                emptyState.classList.add('d-none');
            }

            const countEl = document.querySelector(`[data-bs-target="#commentsModal${postId}"] .chatbox-comments-count`);
            if (countEl) {
                const nextCount = Number(countEl.textContent || '0') + 1;
                countEl.textContent = String(nextCount);
            }

            form.reset();
            const parentInput = form.querySelector('.chatbox-reply-parent-id');
            const indicator = form.querySelector('.chatbox-reply-indicator');
            if (parentInput) parentInput.value = '';
            if (indicator) indicator.classList.add('d-none');
        } catch (error) {
            console.error(error);
            chatboxToast('error', 'Could not add comment. Please try again.');
        } finally {
            if (submitButton) submitButton.disabled = false;
        }
    });

    document.addEventListener('submit', async function (event) {
        const form = event.target;
        if (!form.matches('[data-comment-reaction-form]')) {
            return;
        }

        event.preventDefault();

        const picker = form.closest('.connectly-comment-reaction-picker') || form.closest('.chatbox-comment-reaction-picker');
        if (!picker) {
            return;
        }

        const card = picker.closest('[data-comment-card]');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const buttons = picker.querySelectorAll('button');

        buttons.forEach((button) => {
            button.disabled = true;
        });

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(form),
            });

            if (!response.ok) {
                throw new Error('Failed to submit comment reaction');
            }

            const data = await response.json();
            const currentReaction = data.current_reaction;

            const reactionMeta = {
                like: { label: 'Like', emoji: '👍' },
                love: { label: 'Love', emoji: '❤️' },
                haha: { label: 'Haha', emoji: '😆' },
                wow: { label: 'Wow', emoji: '😮' },
                sad: { label: 'Sad', emoji: '😢' },
            };

            const mainInput = picker.querySelector('.chatbox-comment-main-reaction-input');
            const mainButton = picker.querySelector('.chatbox-comment-main-reaction-button');
            const mainEmoji = picker.querySelector('.chatbox-comment-main-reaction-emoji');
            const mainLabel = picker.querySelector('.chatbox-comment-main-reaction-label');
            const mainCount = picker.querySelector('.chatbox-comment-main-reaction-count');

            if (mainInput) {
                mainInput.value = currentReaction || 'like';
            }

            if (mainButton) {
                mainButton.classList.toggle('btn-primary', !!currentReaction);
                mainButton.classList.toggle('btn-outline-primary', !currentReaction);
            }

            const meta = reactionMeta[currentReaction] || reactionMeta.like;
            if (mainEmoji) {
                mainEmoji.textContent = currentReaction ? meta.emoji : reactionMeta.like.emoji;
            }
            if (mainLabel) {
                mainLabel.textContent = currentReaction ? meta.label : 'Like';
            }
            if (mainCount) {
                mainCount.textContent = String(data.total_reactions ?? 0);
            }

            picker.querySelectorAll('.connectly-comment-reaction-option, .chatbox-comment-reaction-option').forEach((optionButton) => {
                optionButton.classList.toggle('active', optionButton.dataset.reactionKey === currentReaction);
            });

            if (card && data.reaction_counts) {
                Object.keys(reactionMeta).forEach((reactionKey) => {
                    const badge = card.querySelector(`[data-comment-reaction-badge="${reactionKey}"]`);
                    if (!badge) {
                        return;
                    }

                    const count = Number(data.reaction_counts[reactionKey] || 0);
                    const countEl = badge.querySelector('.chatbox-comment-reaction-badge-count');
                    if (countEl) {
                        countEl.textContent = String(count);
                    }

                    badge.classList.toggle('d-none', count <= 0);
                });
            }
        } catch (error) {
            console.error(error);
            chatboxToast('error', 'Could not update comment reaction. Please try again.');
        } finally {
            buttons.forEach((button) => {
                button.disabled = false;
            });
        }
    });

    document.addEventListener('click', function (event) {
        const replyButton = event.target.closest('.connectly-reply-trigger, .chatbox-reply-trigger');
        if (replyButton) {
            const formId = replyButton.dataset.formId;
            const parentId = replyButton.dataset.parentId || '';

            if (!formId) {
                return;
            }

            const form = document.getElementById(formId);
            if (!form) {
                return;
            }

            const parentInput = form.querySelector('.chatbox-reply-parent-id');
            const indicator = form.querySelector('.chatbox-reply-indicator, .connectly-reply-indicator');
            const textarea = form.querySelector('textarea[name="comment"]');

            if (parentInput) {
                parentInput.value = parentId;
            }

            if (indicator) {
                indicator.classList.remove('d-none');
            }

            if (textarea) {
                textarea.focus();
            }
            return;
        }

        const cancelButton = event.target.closest('.chatbox-reply-cancel');
        if (cancelButton) {
            event.preventDefault();
            const form = cancelButton.closest('form');
            if (!form) {
                return;
            }

            const parentInput = form.querySelector('.chatbox-reply-parent-id');
            const indicator = form.querySelector('.chatbox-reply-indicator, .connectly-reply-indicator');

            if (parentInput) {
                parentInput.value = '';
            }

            if (indicator) {
                indicator.classList.add('d-none');
            }
        }
    });
</script>

@if (session('open_modal'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalId = @json(session('open_modal'));
        const modalElement = document.getElementById(modalId);

        if (!modalElement || typeof bootstrap === 'undefined') {
            return;
        }

        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    });
</script>
@endif

@endsection
