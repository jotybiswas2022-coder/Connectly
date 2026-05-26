@extends('frontend.app')

@section('content')

<div class="connectly-feed-page">
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
/* ===== CONNECTLY FEED PAGE ===== */

.connectly-feed-page {
    min-height: 100%;
    background: var(--clr-bg, #F0F5FF);
    animation: connectlyFeedFadeIn 0.5s ease-out;
}

@keyframes connectlyFeedFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* ===== ALERT ===== */
.connectly-feed-alert {
    border-radius: var(--radius-md, 12px);
    border: none;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
    animation: connectlyAlertSlideIn 0.4s ease-out;
}

@keyframes connectlyAlertSlideIn {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* ===== COMPOSER CARD ===== */
.connectly-composer-card {
    background: var(--clr-surface, #FFFFFF);
    border-radius: var(--radius-lg, 16px);
    border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
    transition: box-shadow 0.3s ease;
    animation: connectlyCardSlideUp 0.5s ease-out;
}

.connectly-composer-card:hover {
    box-shadow: 0 8px 30px rgba(37, 99, 235, 0.08);
}

.connectly-composer-name {
    color: var(--clr-text, #0F172A);
    font-size: 0.95rem;
}

.connectly-composer-hint {
    font-size: 0.8rem;
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
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.2);
}

.connectly-feed-avatar-alt {
    background: linear-gradient(135deg, #64748b 0%, #334155 100%);
}

.connectly-feed-avatar-image {
    object-fit: cover;
    border: 2px solid #dbeafe;
    background: #ffffff;
}

/* ===== TEXTAREA ===== */
.connectly-feed-textarea {
    border-radius: var(--radius-md, 12px);
    border: 1.5px solid #e2e8f0;
    padding: 0.9rem 1rem;
    resize: none;
    font-size: 0.9rem;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.connectly-feed-textarea:focus {
    border-color: var(--clr-primary, #2563EB);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    background: #ffffff;
}

.connectly-feed-textarea::placeholder {
    color: #94a3b8;
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
    border: 1.5px dashed #cbd5e1;
    border-radius: var(--radius-sm, 8px);
    background: #f8fafc;
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
}

.connectly-file-label:hover {
    border-color: var(--clr-primary, #2563EB);
    background: #eff6ff;
    color: var(--clr-primary, #2563EB);
}

.connectly-file-input:has(.has-file) ~ .connectly-file-label span {
    color: var(--clr-primary, #2563EB);
}

.connectly-image-label {
    color: #64748b;
    font-size: 0.8rem;
}

.connectly-form-text {
    font-size: 0.75rem;
    color: #94a3b8;
}

/* ===== POST BUTTON ===== */
.connectly-feed-post-btn {
    background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
    color: #fff;
    border-radius: var(--radius-sm, 8px);
    font-weight: 600;
    font-size: 0.85rem;
    padding: 0.55rem 1.25rem;
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.connectly-feed-post-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
    color: #fff;
    background: linear-gradient(135deg, #1d4ed8 0%, #1E40AF 100%);
}

.connectly-feed-post-btn:active {
    transform: translateY(0);
}

/* ===== POST CARD ===== */
.connectly-post-card {
    background: var(--clr-surface, #FFFFFF);
    border-radius: var(--radius-lg, 16px);
    border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
    padding: 1.25rem 1.35rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: connectlyCardSlideUp 0.5s ease-out backwards;
}

.connectly-post-card:nth-child(1) { animation-delay: 0.1s; }
.connectly-post-card:nth-child(2) { animation-delay: 0.2s; }
.connectly-post-card:nth-child(3) { animation-delay: 0.3s; }
.connectly-post-card:nth-child(4) { animation-delay: 0.4s; }
.connectly-post-card:nth-child(5) { animation-delay: 0.5s; }

.connectly-post-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(37, 99, 235, 0.08);
    border-color: rgba(37, 99, 235, 0.15);
}

@keyframes connectlyCardSlideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== POST TEXT ===== */
.connectly-post-text {
    color: var(--clr-text, #0F172A);
    line-height: 1.7;
    white-space: pre-line;
    font-size: 0.92rem;
}

/* ===== SIDE CARDS ===== */
.connectly-side-card {
    background: var(--clr-surface, #FFFFFF);
    border-radius: var(--radius-lg, 16px);
    border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
    padding: 1.3rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
    animation: connectlyCardSlideUp 0.6s ease-out;
}

.connectly-side-card-title {
    color: var(--clr-text, #0F172A);
    font-size: 0.95rem;
}

.connectly-side-icon-search {
    color: var(--clr-primary, #2563EB);
    font-size: 1.1rem;
}

.connectly-side-icon-tips {
    color: #f59e0b;
    font-size: 1.1rem;
}

/* ===== SEARCH GROUP ===== */
.connectly-search-group {
    position: relative;
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: var(--radius-md, 12px);
    padding: 0.1rem;
    transition: all 0.25s ease;
}

.connectly-search-group:focus-within {
    border-color: var(--clr-primary, #2563EB);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.connectly-search-group-icon {
    position: absolute;
    left: 12px;
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
    transition: color 0.25s ease;
}

.connectly-search-group:focus-within .connectly-search-group-icon {
    color: var(--clr-primary, #2563EB);
}

.connectly-search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 0.7rem 2.8rem 0.7rem 2.2rem;
    font-size: 0.85rem;
    color: var(--clr-text, #0F172A);
    background: transparent;
    border-radius: 10px;
}

.connectly-search-input::placeholder {
    color: #94a3b8;
}

.connectly-search-btn {
    position: absolute;
    right: 4px;
    width: 34px;
    height: 34px;
    border: none;
    background: linear-gradient(135deg, #2563EB, #1E40AF);
    color: #fff;
    border-radius: var(--radius-sm, 8px);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
}

.connectly-search-btn:hover {
    background: linear-gradient(135deg, #1d4ed8, #1E40AF);
    transform: scale(1.05);
}

.connectly-search-btn:active {
    transform: scale(0.95);
}

/* ===== TIPS LIST ===== */
.connectly-tips-list {
    padding-left: 0;
    list-style: none;
    color: #334155;
    line-height: 1.8;
    font-size: 0.85rem;
}

.connectly-tips-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 0.4rem 0;
    border-bottom: 1px solid #f1f5f9;
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
    background: linear-gradient(135deg, #60A5FA, #2563EB);
    margin-top: 8px;
    box-shadow: 0 1px 4px rgba(37, 99, 235, 0.3);
}

/* ===== POST IMAGE ===== */
.connectly-post-image {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    border-radius: var(--radius-sm, 8px);
    border: 1px solid #eef2f8;
    transition: transform 0.3s ease;
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
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(8px) scale(0.95);
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
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
    background: #eff6ff;
}

.connectly-reaction-option.active {
    background: #dbeafe;
}

/* ===== MAIN REACTION BUTTON ===== */
.connectly-main-reaction-btn {
    border-radius: 999px !important;
    padding: 0.3rem 0.85rem !important;
    font-size: 0.8rem !important;
    font-weight: 500 !important;
    transition: all 0.25s ease !important;
    border: 1.5px solid #e2e8f0 !important;
    background: #f8fafc !important;
    color: #64748b !important;
}

.connectly-main-reaction-btn:hover {
    background: #eff6ff !important;
    border-color: #93c5fd !important;
    color: var(--clr-primary, #2563EB) !important;
    transform: translateY(-1px);
}

.connectly-main-reaction-btn.btn-primary {
    background: linear-gradient(135deg, #2563EB, #1E40AF) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.2);
}

.connectly-main-reaction-btn.btn-primary:hover {
    box-shadow: 0 5px 16px rgba(37, 99, 235, 0.3);
    transform: translateY(-1px);
}

/* ===== COMMENT BUTTON ===== */
.connectly-comment-btn {
    border-radius: 999px !important;
    padding: 0.3rem 0.85rem !important;
    font-size: 0.8rem !important;
    font-weight: 500 !important;
    border: 1.5px solid #e2e8f0 !important;
    background: #f8fafc !important;
    color: #64748b !important;
    transition: all 0.25s ease !important;
}

.connectly-comment-btn:hover {
    background: #eff6ff !important;
    border-color: #93c5fd !important;
    color: var(--clr-primary, #2563EB) !important;
    transform: translateY(-1px);
}

/* ===== REACTION BADGES ===== */
.connectly-reaction-badge {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    color: #475569 !important;
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
    background: #fef3c7;
    color: #b45309;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 12px;
    border: 1px solid #fde68a;
}

/* ===== PROFILE LINK ===== */
.connectly-profile-link {
    color: var(--clr-dark, #1E40AF);
    font-weight: 600;
    transition: color 0.2s ease;
}

.connectly-profile-link:hover {
    color: var(--clr-primary, #2563EB);
    text-decoration: underline !important;
}

/* ===== PIN / EDIT / DELETE BUTTONS ===== */
.connectly-action-btn {
    border-radius: var(--radius-sm, 8px) !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    padding: 0.25rem 0.6rem !important;
    transition: all 0.2s ease !important;
}

/* ===== COMMENT ITEM ===== */
.connectly-comment-item {
    padding: 0.85rem;
    border-radius: var(--radius-md, 12px);
    border: 1px solid #eef2f8;
    background: #fafcff;
    transition: background 0.2s ease;
}

.connectly-comment-item:hover {
    background: #f8fafc;
}

.connectly-comment-replies {
    margin-left: 1rem;
    padding-left: 0.9rem;
    border-left: 2px solid #dbe4ef;
}

.connectly-comment-reply-item {
    padding: 0.75rem;
    border-radius: var(--radius-sm, 8px);
    border: 1px solid #eef2f8;
    background: #ffffff;
}

.connectly-comment-image {
    width: 100%;
    max-width: 320px;
    max-height: 260px;
    object-fit: cover;
    border-radius: var(--radius-sm, 8px);
    border: 1px solid #eef2f8;
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
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(8px) scale(0.95);
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
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
    background: #eff6ff;
}

.connectly-comment-reaction-option.active {
    background: #dbeafe;
}

.connectly-comment-main-reaction-btn {
    border-radius: 999px !important;
    padding: 0.2rem 0.7rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border: 1.5px solid #e2e8f0 !important;
    background: #f8fafc !important;
    color: #64748b !important;
    transition: all 0.2s ease !important;
}

.connectly-comment-main-reaction-btn:hover {
    background: #eff6ff !important;
    border-color: #93c5fd !important;
    color: var(--clr-primary, #2563EB) !important;
}

.connectly-comment-main-reaction-btn.btn-primary {
    background: linear-gradient(135deg, #2563EB, #1E40AF) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.2);
}

.connectly-comment-main-reaction-btn.btn-primary:hover {
    box-shadow: 0 5px 14px rgba(37, 99, 235, 0.3);
}

/* ===== REPLY TRIGGER ===== */
.connectly-reply-trigger {
    border-radius: 999px !important;
    padding: 0.2rem 0.7rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border: 1.5px solid #e2e8f0 !important;
    background: #f8fafc !important;
    color: #64748b !important;
    transition: all 0.2s ease !important;
}

.connectly-reply-trigger:hover {
    background: #eff6ff !important;
    border-color: #93c5fd !important;
    color: var(--clr-primary, #2563EB) !important;
}

/* ===== REPLY INDICATOR ===== */
.connectly-reply-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.55rem 0.85rem;
    margin-bottom: 0.75rem;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: var(--radius-sm, 8px);
    color: var(--clr-dark, #1E40AF);
    font-size: 0.82rem;
    font-weight: 500;
    animation: connectlyReplySlideIn 0.25s ease;
}

@keyframes connectlyReplySlideIn {
    from { transform: translateY(-6px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.connectly-reply-indicator-icon {
    color: var(--clr-primary, #2563EB);
    font-size: 0.85rem;
}

.connectly-reply-cancel-btn {
    background: transparent;
    border: none;
    color: #64748b;
    padding: 2px 6px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.7rem;
    transition: all 0.2s ease;
    line-height: 1;
}

.connectly-reply-cancel-btn:hover {
    background: #dbeafe;
    color: var(--clr-dark, #1E40AF);
}

/* ===== COMMENT SUBMIT ===== */
.connectly-comment-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #2563EB, #1E40AF);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    border-radius: var(--radius-sm, 8px);
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.connectly-comment-submit-btn:hover {
    background: linear-gradient(135deg, #1d4ed8, #1E40AF);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
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
    border: 1.5px dashed #cbd5e1;
    border-radius: var(--radius-sm, 8px);
    background: #f8fafc;
    color: #64748b;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.25s;
    cursor: pointer;
}

.connectly-file-label-comment:hover {
    border-color: var(--clr-primary, #2563EB);
    background: #eff6ff;
    color: var(--clr-primary, #2563EB);
}

/* ===== TOAST ===== */
.connectly-toast-popup {
    border-radius: var(--radius-md, 12px) !important;
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12) !important;
    font-family: inherit !important;
}

.connectly-toast-popup .swal2-title {
    font-size: 0.88rem !important;
    font-weight: 500 !important;
    color: var(--clr-text, #0F172A) !important;
}

.connectly-toast-popup .swal2-timer-progress-bar {
    background: #dbeafe !important;
    height: 3px !important;
}

.connectly-toast-popup.swal2-icon-success {
    border-left: 4px solid #10b981 !important;
}

.connectly-toast-popup.swal2-icon-error {
    border-left: 4px solid #ef4444 !important;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991.98px) {
    .connectly-composer-card {
        padding: 1.2rem;
    }
}

@media (max-width: 576px) {
    .connectly-composer-card {
        padding: 1rem;
    }

    .connectly-post-card {
        padding: 1rem;
    }

    .connectly-side-card {
        padding: 1rem;
    }

    .connectly-feed-avatar {
        width: 40px;
        height: 40px;
        font-size: 0.95rem;
    }
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
