@extends('frontend.app')

@section('content')

<div class="connectly-feed-page">

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show connectly-feed-alert" role="alert" id="successAlert">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show connectly-feed-alert-danger" role="alert" id="errorAlert">
                <i class="bi bi-exclamation-circle-fill me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Mobile Search Card (Only visible on mobile, scroll-aware) -->
                <div class="connectly-mobile-search d-lg-none" id="mobileSearch">
                    <div class="connectly-mobile-search-inner" id="mobileSearchInner">
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
                        <!-- Scroll hint arrow -->
                        <div class="connectly-scroll-hint d-none" id="scrollHint">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Composer Card -->
                <div class="connectly-composer-card">
                    <div class="d-flex align-items-start gap-3">
                        @if(auth()->user()->avatar_path)
                            <img src="{{ route('media.show', ['path' => auth()->user()->avatar_path]) }}"
                                 alt="My avatar"
                                 class="connectly-feed-avatar connectly-feed-avatar-image" loading="lazy">
                        @else
                            <div class="connectly-feed-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold connectly-composer-name">{{ auth()->user()->name }}</h6>
                            <p class="mb-3 text-muted small connectly-composer-hint">What's on your mind?</p>

                            <form action="{{ route('feed.posts.store') }}" method="POST" enctype="multipart/form-data" id="composerForm">
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

                                <!-- Image Preview Container -->
                                <div class="connectly-image-preview-container mt-3 d-none" id="composerPreviewContainer">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="small fw-semibold text-muted">
                                            <i class="bi bi-images me-1"></i>Image Preview
                                        </span>
                                        <button type="button" class="connectly-preview-clear-btn" id="composerClearPreview">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    <div class="connectly-image-preview-grid" id="composerPreviewGrid"></div>
                                </div>

                                <div class="mt-3">
                                    <div class="connectly-file-upload">
                                        <input
                                            type="file"
                                            name="images[]"
                                            accept="image/*"
                                            multiple
                                            class="connectly-file-input @error('images') is-invalid @enderror"
                                            id="composerImageInput"
                                        >
                                        <label for="composerImageInput" class="connectly-file-label">
                                            <i class="bi bi-cloud-arrow-up me-2"></i>
                                            <span>Add images <span class="text-muted fw-normal">(drag & drop or click)</span></span>
                                        </label>
                                    </div>
                                    @error('images')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('images.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text connectly-form-text">You can add multiple images or post without any.</div>
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
                        <div class="connectly-empty-state text-center py-5">
                            <div class="connectly-empty-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <h5 class="fw-bold mt-3">No posts yet</h5>
                            <p class="text-muted mb-0">Be the first one to share something with the community!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Desktop Search Card -->
                <div class="connectly-side-card d-none d-lg-block connectly-side-sticky">
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
                        <li>
                            <span class="connectly-tips-bullet"></span>
                            Upload multiple images to make your posts more expressive.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================================
   CONNECTLY FEED PAGE — PREMIUM LIGHT THEME
   ============================================================ */

/* ----- CSS Variables ----- */
:root {
    --feed-bg: #f5f5f7;
    --feed-bg-alt: #fafbfc;
    --feed-surface: #ffffff;
    --feed-surface-hover: #f8f9fa;
    --feed-border: #e5e7eb;
    --feed-border-light: #f0f0f2;
    --feed-border-focus: #0071e3;
    --feed-text: #1d1d1f;
    --feed-text-secondary: #424245;
    --feed-muted: #86868b;
    --feed-muted-light: #aeaeb2;
    --feed-primary: #0071e3;
    --feed-primary-light: #40a9ff;
    --feed-primary-dark: #0058b3;
    --feed-primary-subtle: rgba(0,113,227,0.06);
    --feed-purple: #8b5cf6;
    --feed-purple-light: #a78bfa;
    --feed-cyan: #22d3ee;
    --feed-rose: #fb7185;
    --feed-amber: #fbbf24;
    --feed-emerald: #34d399;
    --feed-success: #059669;
    --feed-warning: #d97706;
    --feed-danger: #dc2626;
    --feed-input-bg: #f5f5f7;
    --feed-input-border: #d2d2d7;
    --feed-radius: 24px;
    --feed-radius-sm: 14px;
    --feed-radius-xs: 10px;
    --feed-radius-pill: 9999px;
    --feed-shadow-sm: 0 1px 2px rgba(0,0,0,0.03);
    --feed-shadow-md: 0 2px 8px rgba(0,0,0,0.04);
    --feed-shadow-lg: 0 8px 24px rgba(0,0,0,0.05);
    --feed-shadow-xl: 0 12px 40px rgba(0,0,0,0.06);
    --feed-shadow-glow: 0 4px 16px rgba(0,113,227,0.08);
    --feed-transition: 0.25s cubic-bezier(.4,0,.2,1);
    --feed-spring: 0.5s cubic-bezier(.34,1.56,.64,1);
}

/* ----- Page Layout ----- */
.connectly-feed-page {
    min-height: 100vh;
    background: var(--feed-bg);
    position: relative;
    z-index: 1;
}

.connectly-feed-page > .container {
    position: relative;
    z-index: 2;
}

/* ----- Alert ----- */
.connectly-feed-alert {
    border-radius: var(--feed-radius-sm);
    border: 1px solid rgba(16,185,129,0.25);
    background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(16,185,129,0.04));
    color: #065f46;
    font-weight: 500;
    animation: connectlyAlertSlideIn 0.4s ease-out;
    box-shadow: var(--feed-shadow-sm);
}
.connectly-feed-alert-danger {
    border-radius: var(--feed-radius-sm);
    border: 1px solid rgba(239,68,68,0.25);
    background: linear-gradient(135deg, rgba(239,68,68,0.08), rgba(239,68,68,0.04));
    color: #991b1b;
    font-weight: 500;
    animation: connectlyAlertSlideIn 0.4s ease-out;
    box-shadow: var(--feed-shadow-sm);
}
.connectly-feed-alert .btn-close,
.connectly-feed-alert-danger .btn-close {
    filter: none;
    opacity: 0.6;
}

@keyframes connectlyAlertSlideIn {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* ===== MOBILE SEARCH (SCROLL-AWARE) ===== */
.connectly-mobile-search {
    position: sticky;
    top: 0;
    z-index: 1020;
    margin-bottom: 1rem;
}

.connectly-mobile-search-inner {
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 0.7rem 0.9rem;
    box-shadow: var(--feed-shadow-md);
    animation: mobileSearchSlideDown 0.4s ease-out;
    transition: all 0.3s ease;
    position: relative;
}

.connectly-mobile-search-inner.is-compact {
    padding: 0.5rem 0.75rem;
    border-radius: var(--feed-radius-sm);
    box-shadow: var(--feed-shadow-lg);
    border-color: var(--feed-border-focus);
}

.connectly-scroll-hint {
    position: absolute;
    bottom: -6px;
    left: 50%;
    transform: translateX(-50%);
    color: var(--feed-muted-light);
    font-size: 0.6rem;
    animation: scrollHintBounce 2s ease-in-out infinite;
}

@keyframes scrollHintBounce {
    0%, 100% { transform: translateX(-50%) translateY(0); opacity: 0.4; }
    50% { transform: translateX(-50%) translateY(4px); opacity: 0.8; }
}

@keyframes mobileSearchSlideDown {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.connectly-mobile-search-inner .connectly-search-group {
    margin-bottom: 0;
}

@keyframes skeletonFadeOut {
    to { opacity: 0; transform: translateY(-10px); }
}

.connectly-skeleton-fade-out {
    animation: skeletonFadeOut 0.4s ease forwards;
}

@media (max-width: 991.98px) {
    .connectly-composer-card { padding: 1.2rem; }
    .connectly-post-card { padding: 1.15rem; }
    .connectly-mobile-search-inner {
        border-radius: 18px;
    }
}

@media (max-width: 767.98px) {
    .chatbox-layout-feed-profile .chatbox-content-area {
        height: calc(100vh - var(--chatbox-navbar-height, 68px)) !important;
        overflow-y: auto !important;
    }
    .connectly-feed-page > .container {
        padding-top: 0 !important;
    }
    .connectly-mobile-search {
        top: 0;
    }
    .connectly-mobile-search-inner {
        padding: 0.65rem 0.85rem;
    }
}

@media (max-width: 576px) {
    .connectly-mobile-search-inner {
        padding: 0.6rem 0.8rem;
        border-radius: var(--feed-radius-sm);
    }
}

@media (max-width: 480px) {
    .connectly-mobile-search-inner {
        padding: 0.5rem 0.7rem;
        border-radius: 14px;
    }
}

/* ===== COMPOSER CARD ===== */
.connectly-composer-card {
    background: var(--feed-surface);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.75rem;
    position: relative;
    transition: all var(--feed-transition);
    animation: feedCardSlideUp 0.5s ease-out;
    box-shadow: var(--feed-shadow-sm);
}

.connectly-composer-card:hover {
    box-shadow: var(--feed-shadow-md);
    border-color: var(--feed-border-focus);
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
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.1rem;
    color: #ffffff;
    background: var(--feed-primary);
    flex-shrink: 0;
}

.connectly-feed-avatar-alt {
    background: var(--feed-muted-light);
}

.connectly-feed-avatar-image {
    object-fit: cover;
    background: var(--feed-surface);
}

/* ===== TEXTAREA ===== */
.connectly-feed-textarea {
    border-radius: var(--feed-radius-sm);
    border: 1.5px solid var(--feed-input-border);
    padding: 1rem 1.1rem;
    resize: none;
    font-size: 0.9rem;
    background: var(--feed-input-bg);
    color: var(--feed-text);
    transition: border-color var(--feed-transition), box-shadow var(--feed-transition);
    line-height: 1.6;
}

.connectly-feed-textarea:focus {
    border-color: var(--feed-primary);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.1);
    background: var(--feed-surface);
    outline: none;
}

.connectly-feed-textarea::placeholder {
    color: var(--feed-muted-light);
}

/* ===== IMAGE PREVIEW ===== */
.connectly-image-preview-container {
    background: var(--feed-input-bg);
    border: 1.5px dashed var(--feed-border);
    border-radius: var(--feed-radius-sm);
    padding: 0.75rem;
    animation: previewFadeIn 0.3s ease;
}

@keyframes previewFadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}

.connectly-preview-clear-btn {
    background: rgba(239,68,68,0.1);
    border: none;
    color: var(--feed-danger);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.7rem;
    transition: all 0.2s ease;
}

.connectly-preview-clear-btn:hover {
    background: rgba(239,68,68,0.2);
    transform: scale(1.1);
}

.connectly-image-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 0.5rem;
}

.connectly-preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid var(--feed-border);
    background: var(--feed-surface);
    animation: previewItemIn 0.25s ease backwards;
}

.connectly-preview-item:nth-child(1) { animation-delay: 0.02s; }
.connectly-preview-item:nth-child(2) { animation-delay: 0.06s; }
.connectly-preview-item:nth-child(3) { animation-delay: 0.10s; }
.connectly-preview-item:nth-child(4) { animation-delay: 0.14s; }
.connectly-preview-item:nth-child(5) { animation-delay: 0.18s; }

@keyframes previewItemIn {
    from { opacity: 0; transform: scale(0.85); }
    to { opacity: 1; transform: scale(1); }
}

.connectly-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.connectly-preview-item-remove {
    position: absolute;
    top: 3px;
    right: 3px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(239,68,68,0.9);
    color: #fff;
    border: none;
    font-size: 0.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    opacity: 0;
}

.connectly-preview-item:hover .connectly-preview-item-remove {
    opacity: 1;
}

.connectly-preview-count-badge {
    position: absolute;
    top: 3px;
    right: 3px;
    background: var(--feed-primary);
    color: #fff;
    font-size: 0.65rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 999px;
    display: none;
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
    border: 1.5px dashed var(--feed-border);
    border-radius: var(--feed-radius-sm);
    background: var(--feed-input-bg);
    color: var(--feed-muted);
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
}

.connectly-file-label:hover {
    border-color: var(--feed-primary);
    background: rgba(37,99,235,0.05);
    color: var(--feed-primary);
}

.connectly-file-label i {
    font-size: 1.1rem;
}

.connectly-form-text {
    font-size: 0.75rem;
    color: var(--feed-muted-light);
}

/* ===== POST BUTTON ===== */
.connectly-feed-post-btn {
    background: var(--feed-primary);
    color: #fff;
    border-radius: var(--feed-radius-pill);
    font-weight: 600;
    font-size: 0.85rem;
    padding: 0.65rem 1.75rem;
    border: none;
    transition: all var(--feed-transition);
    position: relative;
    cursor: pointer;
    -webkit-font-smoothing: antialiased;
}

.connectly-feed-post-btn:hover {
    background: var(--feed-primary-dark);
    color: #fff;
}

/* ===== POST CARD ===== */
.connectly-post-card {
    background: var(--feed-surface);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.25rem 1.35rem;
    position: relative;
    transition: all var(--feed-transition);
    animation: feedCardSlideUp 0.5s ease-out backwards;
    box-shadow: var(--feed-shadow-sm);
}

.connectly-post-card:nth-child(1) { animation-delay: 0.08s; }
.connectly-post-card:nth-child(2) { animation-delay: 0.16s; }
.connectly-post-card:nth-child(3) { animation-delay: 0.24s; }
.connectly-post-card:nth-child(4) { animation-delay: 0.32s; }
.connectly-post-card:nth-child(5) { animation-delay: 0.40s; }

.connectly-post-card:hover {
    border-color: var(--feed-border-focus);
    box-shadow: var(--feed-shadow-md);
}

@keyframes feedCardSlideUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== POST TEXT ===== */
.connectly-post-text {
    color: var(--feed-text-secondary);
    line-height: 1.7;
    white-space: pre-line;
    font-size: 0.92rem;
}

/* ===== POST IMAGE GRID ===== */
.connectly-post-image-grid {
    display: grid;
    gap: 0.4rem;
    border-radius: var(--feed-radius-sm);
    overflow: hidden;
}

.connectly-post-image-grid:not(.d-none) {
    margin-bottom: 0.75rem;
}

/* 1 image */
.connectly-post-image-grid.grid-1 {
    grid-template-columns: 1fr;
    max-height: 400px;
}

/* 2 images */
.connectly-post-image-grid.grid-2 {
    grid-template-columns: 1fr 1fr;
    max-height: 280px;
}

/* 3 images */
.connectly-post-image-grid.grid-3 {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    max-height: 320px;
}
.connectly-post-image-grid.grid-3 .connectly-post-image-item:nth-child(1) {
    grid-row: span 2;
}

/* 4+ images */
.connectly-post-image-grid.grid-4,
.connectly-post-image-grid.grid-many {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    max-height: 320px;
}

.connectly-post-image-item {
    position: relative;
    overflow: hidden;
    border-radius: 6px;
    background: var(--feed-input-bg);
    cursor: pointer;
}

.connectly-post-image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.connectly-post-image-item:hover img {
    transform: scale(1.03);
}

.connectly-post-image-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
}

/* ===== SIDE CARDS ===== */
.connectly-side-card {
    background: var(--feed-surface);
    border-radius: var(--feed-radius);
    border: 1px solid var(--feed-border);
    padding: 1.5rem;
    position: relative;
    animation: feedCardSlideUp 0.6s ease-out;
    box-shadow: var(--feed-shadow-sm);
    transition: all var(--feed-transition);
}

.connectly-side-sticky {
    position: sticky;
    top: 24px;
}

.connectly-side-card-title {
    color: var(--feed-text);
    font-size: 0.92rem;
}

.connectly-side-icon-search {
    color: var(--feed-primary);
}

.connectly-side-icon-tips {
    color: var(--feed-warning);
}

/* ===== SEARCH GROUP ===== */
.connectly-search-group {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--feed-input-bg);
    border: 1.5px solid var(--feed-input-border);
    border-radius: var(--feed-radius-pill);
    padding: 0.1rem;
    transition: all var(--feed-transition);
}

.connectly-search-group:focus-within {
    border-color: var(--feed-primary);
    background: var(--feed-surface);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.1);
}

.connectly-search-group-icon {
    position: absolute;
    left: 14px;
    color: var(--feed-muted-light);
    font-size: 0.85rem;
    pointer-events: none;
    transition: color 0.25s ease;
}

.connectly-search-group:focus-within .connectly-search-group-icon {
    color: var(--feed-primary);
}

.connectly-search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 0.65rem 2.8rem 0.65rem 2.3rem;
    font-size: 0.88rem;
    color: var(--feed-text);
    background: transparent;
    border-radius: var(--feed-radius-pill);
}

.connectly-search-input::placeholder {
    color: var(--feed-muted-light);
}

.connectly-search-btn {
    position: absolute;
    right: 3px;
    width: 32px;
    height: 32px;
    border: none;
    background: var(--feed-primary);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.connectly-search-btn:hover {
    background: var(--feed-primary-dark);
}

.connectly-search-btn:active {
    transform: scale(0.92);
}

/* ===== TIPS LIST ===== */
.connectly-tips-list {
    padding-left: 0;
    list-style: none;
    color: var(--feed-text-secondary);
    line-height: 1.8;
    font-size: 0.85rem;
}

.connectly-tips-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--feed-border);
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
    box-shadow: 0 1px 6px rgba(37,99,235,0.3);
}

/* ===== EMPTY STATE ===== */
.connectly-empty-state {
    background: var(--feed-surface);
    border-radius: var(--feed-radius);
    border: 2px dashed var(--feed-border);
    box-shadow: var(--feed-shadow-sm);
}

.connectly-empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto;
    background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(124,58,237,0.08));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    color: var(--feed-muted-light);
}

.connectly-empty-state h5 {
    color: var(--feed-text);
}

/* ===== PROFILE LINK ===== */
.connectly-profile-link {
    color: var(--feed-text);
    font-weight: 600;
    transition: color 0.2s ease;
}

.connectly-profile-link:hover {
    color: var(--feed-primary);
}

/* ===== COMMENT ITEM (LIGHT) ===== */
.connectly-comment-item {
    padding: 0.85rem;
    border-radius: var(--feed-radius-sm);
    border: 1px solid var(--feed-border);
    background: var(--feed-input-bg);
    transition: background 0.2s ease;
}

.connectly-comment-item:hover {
    background: var(--feed-surface-hover);
}

.connectly-comment-replies {
    margin-left: 1rem;
    padding-left: 0.9rem;
    border-left: 2px solid var(--feed-border);
}

.connectly-comment-reply-item {
    padding: 0.75rem;
    border-radius: var(--feed-radius-sm);
    border: 1px solid var(--feed-border);
    background: var(--feed-input-bg);
}

.connectly-comment-image {
    width: 100%;
    max-width: 320px;
    max-height: 260px;
    object-fit: cover;
    border-radius: var(--feed-radius-sm);
    border: 1px solid var(--feed-border);
}

/* ===== REACTION BUTTON ===== */
.connectly-reaction-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.connectly-react-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    border: 1.5px solid var(--feed-border);
    background: var(--feed-surface);
    color: var(--feed-muted);
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(.4,0,.2,1);
    font-family: inherit;
}

.connectly-react-btn:hover {
    border-color: var(--feed-primary);
    color: var(--feed-primary);
    background: var(--feed-primary-subtle);
}

.connectly-react-btn.is-reacted {
    background: var(--feed-primary);
    border-color: var(--feed-primary);
    color: #fff;
    box-shadow: 0 2px 8px rgba(0,113,227,0.2);
}

.connectly-react-btn.is-reacted:hover {
    background: var(--feed-primary-dark);
    border-color: var(--feed-primary-dark);
    color: #fff;
}

.connectly-react-emoji {
    font-size: 0.95rem;
    line-height: 1;
}

.connectly-react-count {
    font-weight: 600;
}

.connectly-react-count::before {
    content: '(';
}

.connectly-react-count::after {
    content: ')';
}

.connectly-react-float {
    position: absolute;
    left: 0;
    bottom: calc(100% + 6px);
    display: flex;
    gap: 0.2rem;
    padding: 0.35rem 0.45rem;
    background: var(--feed-surface);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid var(--feed-border);
    border-radius: 999px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(8px) scale(0.92);
    transition: all 0.2s cubic-bezier(.16,1,.3,1);
    z-index: 25;
}

.connectly-react-float::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: -12px;
    height: 12px;
}

.connectly-reaction-wrap:hover .connectly-react-float,
.connectly-reaction-wrap:focus-within .connectly-react-float,
.connectly-react-float:hover {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0) scale(1);
}

.connectly-react-emojibtn {
    border: none;
    background: transparent;
    border-radius: 50%;
    width: 34px;
    height: 34px;
    font-size: 1.2rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.15s ease, background 0.15s ease;
    cursor: pointer;
}

.connectly-react-emojibtn:hover {
    transform: scale(1.3);
    background: rgba(0,113,227,0.08);
}

.connectly-react-emojibtn.active {
    background: rgba(0,113,227,0.12);
    transform: scale(1.15);
}

/* ===== COMMENT BUTTON ===== */
.connectly-comment-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    border: 1.5px solid var(--feed-border);
    background: var(--feed-surface);
    color: var(--feed-muted);
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(.4,0,.2,1);
}

.connectly-comment-link:hover {
    border-color: var(--feed-primary);
    color: var(--feed-primary);
    background: var(--feed-primary-subtle);
}

.connectly-comment-link i {
    font-size: 0.9rem;
}

.connectly-comment-count {
    font-weight: 600;
}

.connectly-comment-count::before {
    content: '(';
}

.connectly-comment-count::after {
    content: ')';
}

/* ===== REACTION BADGES ===== */
.connectly-reaction-badge {
    background: var(--feed-input-bg) !important;
    border: 1px solid var(--feed-border) !important;
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
    background: rgba(245,158,11,0.1);
    color: #d97706;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 12px;
    border: 1px solid rgba(245,158,11,0.2);
}

/* ===== POST ACTIONS DROPDOWN ===== */
.connectly-post-actions {
    position: relative;
}

.connectly-post-actions-trigger {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--feed-muted-light);
    cursor: pointer;
    transition: all var(--feed-transition);
}

.connectly-post-actions-trigger:hover {
    background: var(--feed-input-bg);
    color: var(--feed-text);
}

.connectly-post-actions-trigger:active {
    transform: scale(0.92);
}

.connectly-post-actions-trigger[aria-expanded="true"] {
    background: var(--feed-input-bg);
    color: var(--feed-primary);
}

.connectly-post-dropdown {
    border-radius: var(--feed-radius-sm);
    border: 1px solid var(--feed-border);
    padding: 0.35rem;
    box-shadow: var(--feed-shadow-lg);
    min-width: 150px;
    animation: connectlyDropdownIn 0.15s ease-out;
    transform-origin: top right;
}

@keyframes connectlyDropdownIn {
    from {
        opacity: 0;
        transform: scale(0.92) translateY(-4px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.connectly-dropdown-item {
    border-radius: 8px;
    padding: 0.45rem 0.85rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--feed-text);
    transition: all 0.15s ease;
}

.connectly-dropdown-item:hover {
    background: var(--feed-primary-subtle);
    color: var(--feed-primary);
}

.connectly-dropdown-item i {
    font-size: 0.9rem;
}

.connectly-dropdown-danger {
    color: var(--feed-danger) !important;
}

.connectly-dropdown-danger:hover {
    background: rgba(239,68,68,0.08) !important;
    color: var(--feed-danger) !important;
}

.connectly-post-dropdown .dropdown-divider {
    margin: 0.25rem 0;
    border-top-color: var(--feed-border-light);
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
    background: var(--feed-surface);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid var(--feed-border);
    border-radius: 999px;
    box-shadow: var(--feed-shadow-lg);
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
    background: rgba(37,99,235,0.1);
}

.connectly-comment-reaction-option.active {
    background: rgba(37,99,235,0.15);
}

.connectly-comment-main-reaction-btn {
    border-radius: 999px !important;
    padding: 0.2rem 0.7rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border: 1.5px solid var(--feed-border) !important;
    background: var(--feed-surface) !important;
    color: var(--feed-muted) !important;
    transition: all 0.2s ease !important;
}

.connectly-comment-main-reaction-btn:hover {
    background: rgba(37,99,235,0.06) !important;
    border-color: rgba(37,99,235,0.25) !important;
    color: var(--feed-primary) !important;
}

.connectly-comment-main-reaction-btn.btn-primary {
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark)) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 3px 10px rgba(37,99,235,0.2);
}

.connectly-comment-main-reaction-btn.btn-primary:hover {
    box-shadow: 0 5px 16px rgba(37,99,235,0.3);
    color: #fff !important;
}

/* ===== REPLY TRIGGER ===== */
.connectly-reply-trigger {
    border-radius: 999px !important;
    padding: 0.2rem 0.7rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border: 1.5px solid var(--feed-border) !important;
    background: var(--feed-surface) !important;
    color: var(--feed-muted) !important;
    transition: all 0.2s ease !important;
}

.connectly-reply-trigger:hover {
    background: rgba(37,99,235,0.06) !important;
    border-color: rgba(37,99,235,0.25) !important;
    color: var(--feed-primary) !important;
}

/* ===== REPLY INDICATOR ===== */
.connectly-reply-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.55rem 0.85rem;
    margin-bottom: 0.75rem;
    background: rgba(37,99,235,0.06);
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: var(--feed-radius-sm);
    color: var(--feed-primary);
    font-size: 0.82rem;
    font-weight: 500;
    animation: feedReplySlideIn 0.25s ease;
}

@keyframes feedReplySlideIn {
    from { transform: translateY(-6px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.connectly-reply-indicator-icon {
    color: var(--feed-primary);
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
    background: rgba(37,99,235,0.1);
    color: var(--feed-primary);
}

/* ===== COMMENT SUBMIT ===== */
.connectly-comment-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.5rem 1.25rem;
    background: var(--feed-primary);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 500;
    border: none;
    border-radius: var(--feed-radius-pill);
    cursor: pointer;
    transition: all 0.2s ease;
}

.connectly-comment-submit-btn:hover {
    background: var(--feed-primary-dark);
    color: #fff;
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
    border: 1.5px dashed var(--feed-border);
    border-radius: var(--feed-radius-sm);
    background: var(--feed-input-bg);
    color: var(--feed-muted);
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.25s;
    cursor: pointer;
}

.connectly-file-label-comment:hover {
    border-color: var(--feed-primary);
    background: rgba(37,99,235,0.05);
    color: var(--feed-primary);
}

/* ===== MODAL UPGRADE (LIGHT THEME) ===== */
.modal-content {
    border-radius: var(--feed-radius) !important;
    border: 1px solid var(--feed-border) !important;
    box-shadow: var(--feed-shadow-xl) !important;
    background: var(--feed-surface) !important;
    color: var(--feed-text) !important;
    overflow: hidden;
}

.modal-header {
    border-bottom: 1px solid var(--feed-border) !important;
    padding: 1.1rem 1.25rem !important;
    background: linear-gradient(135deg, var(--feed-surface), var(--feed-input-bg));
}

.modal-header .modal-title {
    font-weight: 700 !important;
    font-size: 1.05rem !important;
    color: var(--feed-text) !important;
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-header .btn-close {
    filter: none !important;
    opacity: 0.5;
    transition: all 0.2s ease;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230f172a'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
}

.modal-header .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg);
}

.modal-body {
    padding: 1.25rem !important;
}

.modal-body .form-control {
    background: var(--feed-input-bg) !important;
    border: 1.5px solid var(--feed-input-border) !important;
    color: var(--feed-text) !important;
    border-radius: var(--feed-radius-sm) !important;
    font-size: 0.9rem !important;
}

.modal-body .form-control:focus {
    border-color: var(--feed-primary) !important;
    box-shadow: 0 0 0 4px rgba(37,99,235,0.1) !important;
    background: var(--feed-surface) !important;
}

.modal-body .form-check-label {
    color: var(--feed-text-secondary) !important;
    font-size: 0.85rem !important;
}

.modal-body .form-check-input:checked {
    background-color: var(--feed-primary) !important;
    border-color: var(--feed-primary) !important;
}

.modal-body .btn {
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
    padding: 0.45rem 1rem !important;
    transition: all 0.25s ease !important;
}

.modal-body .btn-primary {
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-primary-dark)) !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(37,99,235,0.2) !important;
    color: #fff !important;
}

.modal-body .btn-primary:hover {
    box-shadow: 0 6px 18px rgba(37,99,235,0.3) !important;
    transform: translateY(-1px);
}

.modal-body .btn-outline-secondary {
    color: var(--feed-muted) !important;
    border-color: var(--feed-border) !important;
}

.modal-body .btn-outline-secondary:hover {
    background: var(--feed-input-bg) !important;
    color: var(--feed-text) !important;
}

.modal-body .btn-outline-danger {
    color: var(--feed-danger) !important;
    border-color: rgba(239,68,68,0.3) !important;
}

.modal-body .btn-outline-danger:hover {
    background: rgba(239,68,68,0.06) !important;
}

.modal-body .btn-outline-warning {
    color: #d97706 !important;
    border-color: rgba(245,158,11,0.3) !important;
}

.modal-body .btn-outline-warning:hover {
    background: rgba(245,158,11,0.08) !important;
}

.modal-body .btn-warning {
    background: rgba(245,158,11,0.12) !important;
    border-color: rgba(245,158,11,0.3) !important;
    color: #d97706 !important;
}

.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

/* ===== SWEETALERT OVERRIDES ===== */
.connectly-toast-popup {
    border-radius: var(--feed-radius-sm) !important;
    box-shadow: var(--feed-shadow-lg) !important;
    font-family: inherit !important;
    background: var(--feed-surface) !important;
    border: 1px solid var(--feed-border) !important;
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

.connectly-toast-popup .swal2-icon {
    font-size: 0.6em !important;
}

/* Delete confirm dialog */
.connectly-confirm-popup {
    border-radius: var(--feed-radius) !important;
    font-family: inherit !important;
    padding: 1.5rem !important;
    box-shadow: var(--feed-shadow-xl) !important;
    border: 1px solid var(--feed-border) !important;
}

.connectly-confirm-popup .swal2-title {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    color: var(--feed-text) !important;
}

.connectly-confirm-popup .swal2-html-container {
    font-size: 0.9rem !important;
    color: var(--feed-text-secondary) !important;
}

.connectly-confirm-popup .swal2-confirm {
    background: linear-gradient(135deg, var(--feed-danger), #dc2626) !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    padding: 0.5rem 1.25rem !important;
    box-shadow: 0 4px 12px rgba(239,68,68,0.3) !important;
}

.connectly-confirm-popup .swal2-cancel {
    border-radius: 8px !important;
    font-weight: 600 !important;
    padding: 0.5rem 1.25rem !important;
    border: 1.5px solid var(--feed-border) !important;
    color: var(--feed-text-secondary) !important;
    background: var(--feed-surface) !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
}

.connectly-confirm-popup .swal2-cancel:hover {
    background: var(--feed-input-bg) !important;
    border-color: var(--feed-muted-light) !important;
}

/* ===== PREMIUM SCROLLBAR ===== */
/* Firefox */
.connectly-feed-page {
    scrollbar-width: thin;
    scrollbar-color: var(--feed-border) transparent;
}

::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: var(--feed-input-bg);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: var(--feed-border);
    border-radius: 4px;
    transition: background 0.2s ease;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--feed-muted-light);
}

/* ===== MICRO-INTERACTIONS ===== */
.connectly-feed-post-btn,
.connectly-search-btn,
.connectly-comment-submit-btn {
    position: relative;
    overflow: hidden;
}

.connectly-feed-post-btn::before,
.connectly-search-btn::before,
.connectly-comment-submit-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
    pointer-events: none;
}

.connectly-feed-post-btn:active::before,
.connectly-search-btn:active::before,
.connectly-comment-submit-btn:active::before {
    width: 300px;
    height: 300px;
}

/* Scale-down on click for buttons */
.connectly-feed-post-btn:active,
.connectly-search-btn:active,
.connectly-comment-submit-btn:active,
.connectly-react-btn:active,
.connectly-comment-link:active,
.connectly-reply-trigger:active {
    transform: scale(0.96) !important;
}

/* Smooth focus ring for inputs */
.connectly-feed-textarea:focus,
.connectly-search-input:focus,
.modal-body .form-control:focus {
    transition: all 0.2s ease, box-shadow 0.3s ease !important;
}

/* Avatar subtle glow pulse */
.connectly-feed-avatar-image {
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.connectly-feed-avatar-image:hover {
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15), 0 4px 16px rgba(37,99,235,0.2);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991.98px) {
    .connectly-composer-card { padding: 1.2rem; }
    .connectly-post-card { padding: 1.15rem; }
}

@media (max-width: 576px) {
    .connectly-composer-card { padding: 1rem; }
    .connectly-post-card { padding: 1rem; }
    .connectly-side-card { padding: 1rem; }
    .connectly-feed-avatar { width: 40px; height: 40px; font-size: 0.95rem; }

    .connectly-post-image-grid.grid-2,
    .connectly-post-image-grid.grid-3,
    .connectly-post-image-grid.grid-4,
    .connectly-post-image-grid.grid-many {
        max-height: 200px;
    }

    .connectly-image-preview-grid {
        grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
    }

    .modal-body {
        padding: 1rem !important;
    }
}

@media (max-width: 480px) {
    .connectly-mobile-search-inner {
        padding: 0.65rem 0.85rem;
        border-radius: 14px;
    }

    .connectly-composer-card {
        padding: 0.85rem;
        border-radius: 14px;
    }

    .connectly-post-card {
        padding: 0.85rem;
        border-radius: 14px;
    }

    .connectly-feed-avatar {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
    }

    .connectly-feed-textarea {
        padding: 0.75rem 0.85rem;
        font-size: 0.85rem;
    }

    .connectly-post-text {
        font-size: 0.88rem;
    }

    .connectly-react-btn,
    .connectly-comment-link {
        padding: 0.25rem 0.65rem;
        font-size: 0.75rem;
    }

    .connectly-post-image-grid.grid-2,
    .connectly-post-image-grid.grid-3,
    .connectly-post-image-grid.grid-4,
    .connectly-post-image-grid.grid-many {
        max-height: 160px;
    }
}

/* ============================================================
   POST PARTIAL — SHARED COMPONENT STYLES
   ============================================================ */

/* Post Avatar */
.connectly-post-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    background: var(--feed-surface);
}

.connectly-post-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
    color: #ffffff;
    background: linear-gradient(135deg, var(--feed-primary), var(--feed-purple));
    box-shadow: 0 2px 8px rgba(37,99,235,0.12);
}

/* Post User Name */
.connectly-post-user-name {
    font-size: 0.9rem;
}

.connectly-post-user-name a {
    color: var(--feed-text);
    font-weight: 700;
    transition: color 0.2s ease;
}

.connectly-post-user-name a:hover {
    color: var(--feed-primary);
}

/* Post Time */
.connectly-post-time {
    font-size: 0.75rem;
    color: var(--feed-muted);
    font-weight: 400;
}

.connectly-post-time-dot {
    color: var(--feed-muted-light);
    font-size: 0.6rem;
}

/* Pin Badge */
.connectly-post-pin-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: rgba(245,158,11,0.08);
    color: #d97706;
    font-size: 0.68rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 20px;
    border: 1px solid rgba(245,158,11,0.15);
}

.connectly-post-pin-badge i {
    font-size: 0.65rem;
}

/* Actions Dropdown Wrapper */
.connectly-post-actions-dropdown {
    position: relative;
    flex-shrink: 0;
}

/* Post Images Grid (updated class names) */
.connectly-post-images {
    display: grid;
    gap: 0.35rem;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 0.85rem;
}

.connectly-post-images.img-1 {
    grid-template-columns: 1fr;
    max-height: 400px;
}

.connectly-post-images.img-2 {
    grid-template-columns: 1fr 1fr;
    max-height: 260px;
}

.connectly-post-images.img-3 {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    max-height: 300px;
}

.connectly-post-images.img-3 .connectly-post-image-wrap:nth-child(1) {
    grid-row: span 2;
}

.connectly-post-images.img-4,
.connectly-post-images.img-many {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    max-height: 300px;
}

.connectly-post-image-wrap {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background: var(--feed-input-bg);
    cursor: pointer;
}

.connectly-post-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(.4,0,.2,1);
    display: block;
}

.connectly-post-image-wrap:hover img {
    transform: scale(1.05);
}

.connectly-post-image-shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
    transform: translateX(-100%);
    pointer-events: none;
}

.connectly-post-image-wrap:hover .connectly-post-image-shimmer {
    animation: imageShimmerFeed 0.8s ease;
}

@keyframes imageShimmerFeed {
    from { transform: translateX(-100%); }
    to { transform: translateX(100%); }
}

/* Action Bar */
.connectly-post-actions-bar {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.1rem;
}

/* Reaction Summary */
.connectly-reaction-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.6rem;
    padding-top: 0.6rem;
    border-top: 1px solid var(--feed-border-light);
}

/* Responsive overrides for updated classes */
@media (max-width: 576px) {
    .connectly-post-avatar {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .connectly-post-avatar {
        width: 36px;
        height: 36px;
    }
}

</style>

<script>
// ============================================================
// SCROLL REVEAL ANIMATION (Intersection Observer)
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    // Staggered reveal for post cards as user scrolls
    if ('IntersectionObserver' in window) {
        const postCards = document.querySelectorAll('.connectly-post-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'perspective(1000px) rotateX(0deg)';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        postCards.forEach((card, index) => {
            // Reset initial state for observer to reveal (flat 2D entrance)
            card.style.opacity = '0';
            card.style.transform = 'translateY(24px)';
            card.style.transition = `opacity 0.6s ease-out ${index * 0.08}s, transform 0.6s ease-out ${index * 0.08}s`;
            observer.observe(card);
        });
    }

    // ============================================================
    // IMAGE PREVIEW — Composer
    // ============================================================
    const composerInput = document.getElementById('composerImageInput');
    const previewContainer = document.getElementById('composerPreviewContainer');
    const previewGrid = document.getElementById('composerPreviewGrid');
    const clearBtn = document.getElementById('composerClearPreview');

    if (!composerInput) return;

    let previewFiles = [];

    composerInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files || []);
        if (newFiles.length === 0) return;

        previewFiles = previewFiles.concat(newFiles);
        renderPreviews();
        updateFileList();
    });

    clearBtn?.addEventListener('click', function() {
        previewFiles = [];
        composerInput.value = '';
        previewContainer.classList.add('d-none');
        previewGrid.innerHTML = '';
        updateFileList();
    });

    function renderPreviews() {
        if (previewFiles.length === 0) {
            previewContainer.classList.add('d-none');
            return;
        }

        previewContainer.classList.remove('d-none');
        previewGrid.innerHTML = '';

        // Show max 5 previews with count badge
        const maxShow = 5;
        const filesToShow = previewFiles.slice(0, maxShow);
        const remaining = previewFiles.length - maxShow;

        filesToShow.forEach((file, index) => {
            const reader = new FileReader();
            const item = document.createElement('div');
            item.className = 'connectly-preview-item';
            item.style.animationDelay = (index * 0.04) + 's';

            reader.onload = function(ev) {
                item.innerHTML = `
                    <img src="${ev.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="connectly-preview-item-remove" data-index="${index}" title="Remove">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                item.querySelector('.connectly-preview-item-remove')?.addEventListener('click', function() {
                    previewFiles.splice(index, 1);
                    renderPreviews();
                    updateFileList();
                });
            };
            reader.readAsDataURL(file);

            previewGrid.appendChild(item);
        });

        // Show +N badge if more than maxShow
        if (remaining > 0) {
            const badge = document.createElement('div');
            badge.className = 'connectly-preview-item';
            badge.style.cssText = 'display:flex;align-items:center;justify-content:center;background:var(--feed-primary-subtle, rgba(37,99,235,0.08));border:2px dashed var(--feed-border)';
            badge.innerHTML = `<span style="font-size:1.1rem;font-weight:700;color:var(--feed-primary, #2563EB);">+${remaining} more</span>`;
            previewGrid.appendChild(badge);
        }
    }

    function updateFileList() {
        // Replace the file input's files with our managed list
        // We can't directly set input.files, so we use DataTransfer
        const dataTransfer = new DataTransfer();
        previewFiles.forEach(file => dataTransfer.items.add(file));
        composerInput.files = dataTransfer.files;
    }

    // Enable drag & drop on the label
    const fileLabel = document.querySelector('.connectly-file-label');
    if (fileLabel) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileLabel.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        fileLabel.addEventListener('drop', function(e) {
            const droppedFiles = Array.from(e.dataTransfer.files || []).filter(f => f.type.startsWith('image/'));
            if (droppedFiles.length === 0) return;

            previewFiles = previewFiles.concat(droppedFiles);
            renderPreviews();
            updateFileList();
        });
    }

    // Auto-hide success/error alerts with SweetAlert
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');

    if (successAlert && typeof Swal !== 'undefined') {
        const text = successAlert.textContent.trim().replace('×', '').trim();
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: text,
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            customClass: { popup: 'connectly-toast-popup' }
        });
        // Remove the DOM alert after showing toast
        setTimeout(() => successAlert.remove(), 100);
    }

    if (errorAlert && typeof Swal !== 'undefined') {
        const text = errorAlert.textContent.trim().replace('×', '').trim();
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: text,
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            customClass: { popup: 'connectly-toast-popup' }
        });
        setTimeout(() => errorAlert.remove(), 100);
    }
});

// ============================================================
// SWEETALERT DELETE CONFIRMATION
// ============================================================
document.addEventListener('click', function(e) {
    const deleteBtn = e.target.closest('.btn-delete-post, [data-delete-post="true"]');
    if (deleteBtn) {
        e.preventDefault();
        const form = deleteBtn.closest('form');
        if (!form) return;

        if (typeof Swal === 'undefined') {
            if (confirm('Delete this post?')) form.submit();
            return;
        }

        Swal.fire({
            title: 'Delete post?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'connectly-confirm-popup'
            },
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
});

// ============================================================
// TOAST HELPER
// ============================================================
function chatboxToast(icon, title) {
    if (typeof Swal === 'undefined') {
        console.warn('SweetAlert2 not loaded');
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
        customClass: { popup: 'connectly-toast-popup' }
    });
}

// ============================================================
// REACTION SUBMIT HANDLER
// ============================================================
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
                <strong><a href="#" class="text-decoration-none connectly-profile-link">${safeName}</a></strong>
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
    if (!form.matches('[data-reaction-form]')) {
        return;
    }

    event.preventDefault();

    const wrap = form.closest('.connectly-reaction-wrap');
    if (!wrap) return;

    const card = wrap.closest('.connectly-post-card');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const buttons = wrap.querySelectorAll('button');
    buttons.forEach((button) => { button.disabled = true; });

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

        if (!response.ok) throw new Error('Failed to submit reaction');
        const data = await response.json();
        if (!data.success) throw new Error('Invalid reaction response');

        const reactionMeta = {
            like: { label: 'Like', emoji: '👍' },
            love: { label: 'Love', emoji: '❤️' },
            haha: { label: 'Haha', emoji: '😆' },
            wow: { label: 'Wow', emoji: '😮' },
            sad: { label: 'Sad', emoji: '😢' },
        };

        const currentReaction = data.current_reaction;
        const mainInput = wrap.querySelector('.connectly-react-input');
        const mainButton = wrap.querySelector('.connectly-react-btn');
        const mainEmoji = wrap.querySelector('.connectly-react-emoji');
        const mainLabel = wrap.querySelector('.connectly-react-label');
        const mainCount = wrap.querySelector('.connectly-react-count');

        if (mainInput) mainInput.value = currentReaction || 'like';
        if (mainButton) {
            mainButton.classList.toggle('is-reacted', !!currentReaction);
        }

        const meta = reactionMeta[currentReaction] || reactionMeta.like;
        if (mainEmoji) mainEmoji.textContent = currentReaction ? meta.emoji : reactionMeta.like.emoji;
        if (mainLabel) mainLabel.textContent = currentReaction ? meta.label : 'Like';
        if (mainCount) mainCount.textContent = String(data.total_reactions ?? 0);

        wrap.querySelectorAll('.connectly-react-emojibtn').forEach((optionButton) => {
            optionButton.classList.toggle('active', optionButton.dataset.reactionKey === currentReaction);
        });

        if (card && data.reaction_counts) {
            Object.keys(reactionMeta).forEach((reactionKey) => {
                const badge = card.querySelector(`[data-reaction-badge="${reactionKey}"]`);
                if (!badge) return;
                const count = Number(data.reaction_counts[reactionKey] || 0);
                const countEl = badge.querySelector('.connectly-reaction-badge-count');
                if (countEl) countEl.textContent = String(count);
                badge.classList.toggle('d-none', count <= 0);
            });
        }
    } catch (error) {
        console.error(error);
        chatboxToast('error', 'Could not update reaction. Please try again.');
    } finally {
        buttons.forEach((button) => { button.disabled = false; });
    }
});

document.addEventListener('submit', async function (event) {
    const form = event.target;
    if (!form.matches('[data-comment-form-id]')) {
        return;
    }

    event.preventDefault();

    const postId = form.dataset.commentFormId;
    const modalBody = form.closest('.modal-body');
    if (!postId || !modalBody) return;

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

        if (emptyState) emptyState.classList.add('d-none');

        const countEl = document.querySelector(`[href$="/feed/posts/${postId}/comments"] .chatbox-comments-count`);
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
    if (!picker) return;

    const card = picker.closest('[data-comment-card]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const buttons = picker.querySelectorAll('button');
    buttons.forEach((button) => { button.disabled = true; });

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

        if (!response.ok) throw new Error('Failed to submit comment reaction');
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

        if (mainInput) mainInput.value = currentReaction || 'like';
        if (mainButton) {
            mainButton.classList.toggle('btn-primary', !!currentReaction);
            mainButton.classList.toggle('btn-outline-primary', !currentReaction);
        }

        const meta = reactionMeta[currentReaction] || reactionMeta.like;
        if (mainEmoji) mainEmoji.textContent = currentReaction ? meta.emoji : reactionMeta.like.emoji;
        if (mainLabel) mainLabel.textContent = currentReaction ? meta.label : 'Like';
        if (mainCount) mainCount.textContent = String(data.total_reactions ?? 0);

        picker.querySelectorAll('.connectly-comment-reaction-option').forEach((optionButton) => {
            optionButton.classList.toggle('active', optionButton.dataset.reactionKey === currentReaction);
        });

        if (card && data.reaction_counts) {
            Object.keys(reactionMeta).forEach((reactionKey) => {
                const badge = card.querySelector(`[data-comment-reaction-badge="${reactionKey}"]`);
                if (!badge) return;
                const count = Number(data.reaction_counts[reactionKey] || 0);
                const countEl = badge.querySelector('.chatbox-comment-reaction-badge-count');
                if (countEl) countEl.textContent = String(count);
                badge.classList.toggle('d-none', count <= 0);
            });
        }
    } catch (error) {
        console.error(error);
        chatboxToast('error', 'Could not update comment reaction. Please try again.');
    } finally {
        buttons.forEach((button) => { button.disabled = false; });
    }
});

document.addEventListener('click', function (event) {
    const replyButton = event.target.closest('.connectly-reply-trigger, .chatbox-reply-trigger');
    if (replyButton) {
        const formId = replyButton.dataset.formId;
        const parentId = replyButton.dataset.parentId || '';
        if (!formId) return;

        const form = document.getElementById(formId);
        if (!form) return;

        const parentInput = form.querySelector('.chatbox-reply-parent-id');
        const indicator = form.querySelector('.chatbox-reply-indicator, .connectly-reply-indicator');
        const textarea = form.querySelector('textarea[name="comment"]');

        if (parentInput) parentInput.value = parentId;
        if (indicator) indicator.classList.remove('d-none');
        if (textarea) textarea.focus();
        return;
    }

    const cancelButton = event.target.closest('.chatbox-reply-cancel');
    if (cancelButton) {
        event.preventDefault();
        const form = cancelButton.closest('form');
        if (!form) return;

        const parentInput = form.querySelector('.chatbox-reply-parent-id');
        const indicator = form.querySelector('.chatbox-reply-indicator, .connectly-reply-indicator');
        if (parentInput) parentInput.value = '';
        if (indicator) indicator.classList.add('d-none');
    }
});

// ============================================================
// FILE INPUT LABEL UPDATE
// ============================================================
document.addEventListener('change', function(e) {
    if (e.target.matches('.chatbox-file-input') || e.target.matches('.connectly-file-input')) {
        const wrapper = e.target.closest('.connectly-file-upload') || e.target.closest('.chatbox-file-input-wrapper');
        const label = wrapper?.querySelector('.connectly-file-label span, .chatbox-file-label span');
        if (label && e.target.files.length > 0) {
            const count = e.target.files.length;
            label.textContent = count + ' image' + (count > 1 ? 's' : '') + ' selected';
        } else if (label) {
            const placeholder = wrapper?.querySelector('.connectly-file-label span');
            if (placeholder && !placeholder.closest('.connectly-file-upload')) {
                // Comment image label
                placeholder.textContent = 'Add an image (optional)';
            } else if (placeholder) {
                placeholder.textContent = 'Add images (drag & drop or click)';
            }
        }
    }
});
</script>

{{-- Reaction List Modal --}}
<div class="modal fade" id="reactorsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Reactions</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2" id="reactorsModalBody">
                <div class="text-center text-muted py-3">Loading...</div>
            </div>
        </div>
    </div>
</div>

<style>
#reactorsModal .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
}
#reactorsModal .modal-header {
    padding: 1rem 1.25rem 0 1.25rem;
}
#reactorsModal .modal-body {
    padding: 0.75rem 0;
    max-height: 400px;
    overflow-y: auto;
}
.reactors-tab-row {
    display: flex;
    gap: 0.25rem;
    padding: 0 1rem 0.75rem 1rem;
    border-bottom: 1px solid var(--feed-border, #e9ecef);
    overflow-x: auto;
}
.reactors-tab-btn {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.7rem;
    border-radius: 999px;
    border: 1.5px solid transparent;
    background: transparent;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s ease;
    color: var(--feed-muted, #6c757d);
    font-family: inherit;
}
.reactors-tab-btn:hover {
    border-color: var(--feed-border, #e9ecef);
    background: var(--feed-input-bg, #f8f9fa);
}
.reactors-tab-btn.active {
    border-color: var(--feed-primary, #0071e3);
    background: var(--feed-primary-subtle, #e8f4fd);
    color: var(--feed-primary, #0071e3);
}
.reactors-tab-count {
    font-size: 0.75rem;
    opacity: 0.7;
}
.reactors-list {
    padding: 0.25rem 0;
}
.reactors-list-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    text-decoration: none;
    color: inherit;
    transition: background 0.15s ease;
}
.reactors-list-item:hover {
    background: var(--feed-input-bg, #f8f9fa);
}
.reactors-list-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}
.reactors-list-avatar-fallback {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.85rem;
    background: var(--feed-primary-subtle, #e8f4fd);
    color: var(--feed-primary, #0071e3);
    flex-shrink: 0;
}
.reactors-list-name {
    font-size: 0.9rem;
    font-weight: 500;
    flex-grow: 1;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.reactors-list-emoji {
    font-size: 1.1rem;
    flex-shrink: 0;
}
.reactors-empty {
    text-align: center;
    padding: 2rem 1rem;
    color: var(--feed-muted, #6c757d);
    font-size: 0.9rem;
}
.reactors-list-item-you {
    background: var(--feed-primary-subtle, #e8f4fd);
}
.reactors-list-item-you:hover {
    background: var(--feed-primary-subtle, #e8f4fd);
}
.reactors-you-badge {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--feed-primary, #0071e3);
    background: rgba(0,113,227,0.1);
    padding: 0.05rem 0.45rem;
    border-radius: 999px;
    margin-left: 0.35rem;
    vertical-align: middle;
}
</style>

<script>
var reactorsAuthId = {{ (int) auth()->id() }};
var reactorsProfileRoute = @json(route('profile.show', ['user_id' => '__ID__']));

document.addEventListener('click', function (event) {
    var badge = event.target.closest('[data-reaction-type]');
    var summary = badge ? null : event.target.closest('.connectly-reaction-summary');
    if (!summary && !badge) return;

    var container = badge ? badge.closest('.connectly-reaction-summary') : summary;
    if (!container) return;

    var url = container.dataset.reactorsUrl;
    if (!url) return;

    var defaultType = badge ? badge.dataset.reactionType : null;

    var modal = new bootstrap.Modal('#reactorsModal');
    var body = document.getElementById('reactorsModalBody');
    body.innerHTML = '<div class="text-center text-muted py-3">Loading...</div>';
    modal.show();

    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken,
        }
    })
    .then(function (r) { if (!r.ok) throw new Error('Failed'); return r.json(); })
    .then(function (data) {
        if (!data.success) throw new Error('Invalid');
        renderReactors(body, data, defaultType);
    })
    .catch(function () {
        body.innerHTML = '<div class="text-center text-muted py-3">Could not load reactions.</div>';
    });
});

function renderReactors(container, data, defaultType) {
    var authId = reactorsAuthId;
    var meta = {
        like: { label: 'Like', emoji: '👍' },
        love: { label: 'Love', emoji: '❤️' },
        haha: { label: 'Haha', emoji: '😆' },
        wow: { label: 'Wow', emoji: '😮' },
        sad: { label: 'Sad', emoji: '😢' },
    };

    var types = Object.keys(meta).filter(function (k) { return data.groups[k] && data.groups[k].count > 0; });

    if (types.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-3">No reactions yet.</div>';
        return;
    }

    var activeType = defaultType && types.indexOf(defaultType) !== -1 ? defaultType : types[0];

    var html = '<div class="reactors-tab-row">';
    types.forEach(function (type) {
        html += '<button type="button" class="reactors-tab-btn' + (type === activeType ? ' active' : '') + '" data-reactor-tab="' + type + '">'
            + meta[type].emoji + ' ' + meta[type].label
            + ' <span class="reactors-tab-count">' + data.groups[type].count + '</span>'
            + '</button>';
    });
    html += '</div>';

    html += renderReactorList(data.groups[activeType], activeType);
    container.innerHTML = html;

    container.querySelectorAll('[data-reactor-tab]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var type = btn.dataset.reactorTab;
            container.querySelectorAll('.reactors-tab-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var existingList = container.querySelector('.reactors-list');
            if (existingList) existingList.remove();

            container.insertAdjacentHTML('beforeend', renderReactorList(data.groups[type], type));
        });
    });
}

function renderReactorList(group, type) {
    var html = '<div class="reactors-list" data-reactor-list="' + type + '">';
    group.users.forEach(function (user) {
        html += renderReactorUser(user, type);
    });
    html += '</div>';
    return html;
}

function renderReactorUser(user, type) {
    var meta = {
        like: { label: 'Like', emoji: '👍' },
        love: { label: 'Love', emoji: '❤️' },
        haha: { label: 'Haha', emoji: '😆' },
        wow: { label: 'Wow', emoji: '😮' },
        sad: { label: 'Sad', emoji: '😢' },
    };
    var isYou = user.id === reactorsAuthId;
    var avatarHtml = user.avatar_url
        ? '<img src="' + user.avatar_url + '" alt="" class="reactors-list-avatar" loading="lazy">'
        : '<span class="reactors-list-avatar-fallback">' + user.name.charAt(0).toUpperCase() + '</span>';
    var profileUrl = reactorsProfileRoute.replace('__ID__', user.id);
    var youTag = isYou ? ' <span class="reactors-you-badge">You</span>' : '';
    return '<a href="' + profileUrl + '" class="reactors-list-item' + (isYou ? ' reactors-list-item-you' : '') + '">'
        + avatarHtml
        + '<span class="reactors-list-name">' + user.name + youTag + '</span>'
        + '<span class="reactors-list-emoji">' + meta[type].emoji + '</span>'
        + '</a>';
}
</script>

@endsection
