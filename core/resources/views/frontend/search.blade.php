@extends('frontend.app')

@section('content')

<div class="chatbox-search-page">
    <div class="chatbox-search-container">
        <!-- Search Hero Section -->
        <div class="chatbox-search-hero">
            <div class="chatbox-search-hero-bg-shapes">
                <div class="chatbox-shape chatbox-shape-1"></div>
                <div class="chatbox-shape chatbox-shape-2"></div>
                <div class="chatbox-shape chatbox-shape-3"></div>
                <div class="chatbox-shape chatbox-shape-4"></div>
            </div>

            <div class="chatbox-search-hero-content">
                <div class="chatbox-search-icon-wrapper">
                    <i class="bi bi-search-heart chatbox-search-hero-icon"></i>
                </div>
                <h1 class="chatbox-search-title">
                    {{ $query ? 'Search Results' : 'Discover ChatBox' }}
                </h1>
                <p class="chatbox-search-subtitle">
                    {{ $query ? "Showing results for \"{$query}\"" : 'Find users, posts, and more across the community' }}
                </p>

                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="chatbox-search-form" id="searchForm">
                    <div class="chatbox-search-input-group">
                        <i class="bi bi-search chatbox-search-input-icon"></i>
                        <input
                            type="text"
                            name="q"
                            value="{{ $query }}"
                            class="chatbox-search-input"
                            placeholder="Search users, posts..."
                            autocomplete="off"
                            autofocus
                        >
                        @if ($query)
                            <a href="{{ route('search') }}" class="chatbox-search-clear-btn" title="Clear search">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                        <button type="submit" class="chatbox-search-submit-btn">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Search Suggestions -->
                @if (!$query)
                    <div class="chatbox-search-suggestions">
                        <span class="chatbox-suggestions-label">Try searching for:</span>
                        <div class="chatbox-suggestions-tags">
                            <a href="{{ route('search', ['q' => 'Hello']) }}" class="chatbox-suggestion-tag">
                                <i class="bi bi-hash me-1"></i>Hello
                            </a>
                            <a href="{{ route('search', ['q' => 'Welcome']) }}" class="chatbox-suggestion-tag">
                                <i class="bi bi-hash me-1"></i>Welcome
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Results Section -->
        @if ($query)
            <div class="chatbox-search-results-section">
                @if ($users->isEmpty() && $posts->isEmpty())
                    <!-- Empty State -->
                    <div class="chatbox-search-empty">
                        <div class="chatbox-search-empty-icon-wrapper">
                            <i class="bi bi-search"></i>
                            <div class="chatbox-search-empty-ring"></div>
                        </div>
                        <h5 class="chatbox-search-empty-title">No results found</h5>
                        <p class="chatbox-search-empty-text">
                            We couldn't find anything matching <strong>"{{ $query }}"</strong>.
                            Try different keywords or browse the community.
                        </p>
                        <div class="chatbox-search-empty-suggestions">
                            <span>Suggestions:</span>
                            <ul>
                                <li>Check your spelling</li>
                                <li>Try more general keywords</li>
                                <li>Search for user names or email addresses</li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="chatbox-search-results-grid">
                        <!-- Users Section -->
                        @if ($users->isNotEmpty())
                            <div class="chatbox-search-section">
                                <div class="chatbox-search-section-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-people-fill chatbox-search-section-icon"></i>
                                        <h5 class="mb-0 fw-bold">Users</h5>
                                    </div>
                                    <span class="chatbox-search-count-badge">{{ $users->count() }} found</span>
                                </div>

                                <div class="chatbox-search-users-grid">
                                    @foreach ($users as $user)
                                        <a href="{{ route('profile.show', $user->id) }}" class="chatbox-search-user-card">
                                            <div class="chatbox-search-user-avatar-wrapper">
                                                @if ($user->avatar_path)
                                                    <img src="{{ route('media.show', ['path' => $user->avatar_path]) }}"
                                                         alt="{{ $user->name }}"
                                                         class="chatbox-search-user-avatar">
                                                @else
                                                    <div class="chatbox-search-user-avatar chatbox-search-user-avatar-fallback">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <span class="chatbox-search-user-online"></span>
                                            </div>
                                            <div class="chatbox-search-user-info">
                                                <span class="chatbox-search-user-name">{{ $user->name }}</span>
                                                <span class="chatbox-search-user-email">{{ $user->email }}</span>
                                            </div>
                                            <div class="chatbox-search-user-arrow">
                                                <i class="bi bi-chevron-right"></i>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Posts Section -->
                        @if ($posts->isNotEmpty())
                            <div class="chatbox-search-section">
                                <div class="chatbox-search-section-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-text-fill chatbox-search-section-icon"></i>
                                        <h5 class="mb-0 fw-bold">Posts</h5>
                                    </div>
                                    <span class="chatbox-search-count-badge">{{ $posts->count() }} found</span>
                                </div>

                                <div class="chatbox-search-posts-list">
                                    @foreach ($posts as $post)
                                        <a href="{{ route('profile.show', $post->user_id) }}" class="chatbox-search-post-card">
                                            <div class="d-flex align-items-start gap-3">
                                                @if ($post->user->avatar_path)
                                                    <img src="{{ route('media.show', ['path' => $post->user->avatar_path]) }}"
                                                         alt="{{ $post->user->name }}"
                                                         class="chatbox-search-post-avatar">
                                                @else
                                                    <div class="chatbox-search-post-avatar chatbox-search-post-avatar-fallback">
                                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                        <span class="chatbox-search-post-author">
                                                            {{ $post->user->name }}
                                                        </span>
                                                        <span class="chatbox-search-post-time">{{ $post->created_at->diffForHumans() }}</span>
                                                    </div>

                                                    <p class="chatbox-search-post-content">
                                                        {{ \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', strip_tags($post->content ?? '')), 200) }}
                                                    </p>

                                                    @if ($post->image_path)
                                                        <div class="chatbox-search-post-image-wrapper">
                                                            <img src="{{ route('media.show', ['path' => $post->image_path]) }}"
                                                                 alt="Post image"
                                                                 class="chatbox-search-post-image">
                                                        </div>
                                                    @endif

                                                    <div class="chatbox-search-post-stats">
                                                        <span class="chatbox-search-post-stat">
                                                            <i class="bi bi-emoji-smile"></i>
                                                            {{ $post->reactions_count }}
                                                        </span>
                                                        <span class="chatbox-search-post-stat">
                                                            <i class="bi bi-chat-dots"></i>
                                                            {{ $post->comments_count }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
/* ===== SEARCH PAGE STYLES ===== */
.chatbox-search-page {
    min-height: 100%;
    background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
}

.chatbox-search-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ===== SEARCH HERO SECTION ===== */
.chatbox-search-hero {
    position: relative;
    padding: 4rem 1rem 3rem;
    text-align: center;
    overflow: hidden;
}

.chatbox-search-hero-bg-shapes {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.chatbox-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.15;
    animation: chatboxShapeFloat 8s ease-in-out infinite;
}

.chatbox-shape-1 {
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, #2563eb, transparent);
    top: -50px;
    left: -50px;
    animation-delay: 0s;
}

.chatbox-shape-2 {
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, #7c3aed, transparent);
    top: 20%;
    right: -30px;
    animation-delay: 2s;
}

.chatbox-shape-3 {
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, #10b981, transparent);
    bottom: 10%;
    left: 10%;
    animation-delay: 4s;
}

.chatbox-shape-4 {
    width: 180px;
    height: 180px;
    background: radial-gradient(circle, #f59e0b, transparent);
    bottom: -50px;
    right: 20%;
    animation-delay: 6s;
}

@keyframes chatboxShapeFloat {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.12; }
    50% { transform: translateY(-20px) scale(1.1); opacity: 0.2; }
}

.chatbox-search-hero-content {
    position: relative;
    z-index: 2;
    animation: chatboxSearchHeroFadeIn 0.8s ease-out;
}

@keyframes chatboxSearchHeroFadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.chatbox-search-icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 32px rgba(37, 99, 235, 0.25);
    animation: chatboxSearchIconPulse 3s ease-in-out infinite;
}

@keyframes chatboxSearchIconPulse {
    0%, 100% { box-shadow: 0 8px 32px rgba(37, 99, 235, 0.25); }
    50% { box-shadow: 0 8px 48px rgba(37, 99, 235, 0.4); }
}

.chatbox-search-hero-icon {
    font-size: 2.2rem;
    color: #fff;
}

.chatbox-search-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.chatbox-search-subtitle {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 2rem;
}

/* ===== SEARCH FORM ===== */
.chatbox-search-form {
    max-width: 600px;
    margin: 0 auto;
}

.chatbox-search-input-group {
    position: relative;
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    padding: 0.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

.chatbox-search-input-group:focus-within {
    border-color: #2563eb;
    box-shadow: 0 4px 24px rgba(37, 99, 235, 0.15);
    transform: translateY(-1px);
}

.chatbox-search-input-icon {
    position: absolute;
    left: 16px;
    color: #9ca3af;
    font-size: 1.1rem;
    pointer-events: none;
    transition: color 0.3s ease;
}

.chatbox-search-input-group:focus-within .chatbox-search-input-icon {
    color: #2563eb;
}

.chatbox-search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 0.9rem 3.5rem 0.9rem 3rem;
    font-size: 1rem;
    color: #1f2937;
    background: transparent;
    border-radius: 14px;
}

.chatbox-search-input::placeholder {
    color: #9ca3af;
}

.chatbox-search-clear-btn {
    position: absolute;
    right: 56px;
    color: #9ca3af;
    text-decoration: none;
    padding: 4px 8px;
    border-radius: 50%;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbox-search-clear-btn:hover {
    color: #ef4444;
    background: #fef2f2;
}

.chatbox-search-submit-btn {
    width: 44px;
    height: 44px;
    border: none;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.chatbox-search-submit-btn:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: scale(1.05);
}

.chatbox-search-submit-btn:active {
    transform: scale(0.95);
}

/* ===== SUGGESTIONS ===== */
.chatbox-search-suggestions {
    margin-top: 1.5rem;
    animation: chatboxSearchFadeIn 0.8s ease-out 0.3s backwards;
}

@keyframes chatboxSearchFadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.chatbox-suggestions-label {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
    display: block;
    margin-bottom: 0.75rem;
}

.chatbox-suggestions-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
}

.chatbox-suggestion-tag {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.2rem;
    background: #ffffff;
    border: 1.5px solid #e5e7eb;
    border-radius: 50px;
    color: #4b5563;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.chatbox-suggestion-tag:hover {
    border-color: #2563eb;
    color: #2563eb;
    background: #eff6ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
}

/* ===== RESULTS SECTION ===== */
.chatbox-search-results-section {
    padding: 0 0 3rem;
    animation: chatboxSearchResultsSlideUp 0.6s ease-out 0.2s backwards;
}

@keyframes chatboxSearchResultsSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.chatbox-search-results-grid {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Section Headers */
.chatbox-search-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding: 0 0.25rem;
}

.chatbox-search-section-icon {
    font-size: 1.2rem;
    color: #2563eb;
}

.chatbox-search-count-badge {
    background: #eff6ff;
    color: #2563eb;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 4px 14px;
    border-radius: 20px;
    border: 1px solid #dbeafe;
}

/* ===== USER RESULTS ===== */
.chatbox-search-users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 0.75rem;
}

.chatbox-search-user-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: #ffffff;
    border: 1px solid #e3ebf4;
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.chatbox-search-user-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: transparent;
    transition: background 0.3s ease;
    border-radius: 0 2px 2px 0;
}

.chatbox-search-user-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    border-color: #d1dff0;
}

.chatbox-search-user-card:hover::before {
    background: #2563eb;
}

.chatbox-search-user-avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.chatbox-search-user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #eef2f8;
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.chatbox-search-user-card:hover .chatbox-search-user-avatar {
    transform: scale(1.05);
    border-color: #dbeafe;
}

.chatbox-search-user-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    color: #fff;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.chatbox-search-user-online {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background: #10b981;
    border: 2px solid #ffffff;
    border-radius: 50%;
    animation: chatboxOnlinePulse 2s infinite;
}

@keyframes chatboxOnlinePulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    50% { box-shadow: 0 0 0 4px rgba(16, 185, 129, 0); }
}

.chatbox-search-user-info {
    flex: 1;
    min-width: 0;
}

.chatbox-search-user-name {
    display: block;
    font-weight: 600;
    font-size: 0.95rem;
    color: #1f2937;
    margin-bottom: 2px;
    transition: color 0.3s ease;
}

.chatbox-search-user-card:hover .chatbox-search-user-name {
    color: #2563eb;
}

.chatbox-search-user-email {
    display: block;
    font-size: 0.8rem;
    color: #9ca3af;
}

.chatbox-search-user-arrow {
    color: #d1d5db;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.chatbox-search-user-card:hover .chatbox-search-user-arrow {
    color: #2563eb;
    transform: translateX(3px);
}

/* ===== POST RESULTS ===== */
.chatbox-search-posts-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.chatbox-search-post-card {
    padding: 1.25rem;
    background: #ffffff;
    border: 1px solid #e3ebf4;
    border-radius: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.chatbox-search-post-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: transparent;
    transition: background 0.3s ease;
    border-radius: 0 2px 2px 0;
}

.chatbox-search-post-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    border-color: #d1dff0;
}

.chatbox-search-post-card:hover::before {
    background: #7c3aed;
}

.chatbox-search-post-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #eef2f8;
    flex-shrink: 0;
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.chatbox-search-post-card:hover .chatbox-search-post-avatar {
    transform: scale(1.05);
    border-color: #dbeafe;
}

.chatbox-search-post-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: #fff;
    background: linear-gradient(135deg, #64748b, #334155);
    flex-shrink: 0;
}

.chatbox-search-post-author {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1e3a8a;
    text-decoration: none;
    transition: color 0.25s ease;
}

.chatbox-search-post-author:hover {
    color: #2563eb;
    text-decoration: underline;
}

.chatbox-search-post-time {
    font-size: 0.78rem;
    color: #9ca3af;
}

.chatbox-search-post-content {
    font-size: 0.92rem;
    color: #4b5563;
    line-height: 1.7;
    margin-bottom: 0.5rem;
    word-wrap: break-word;
}

.chatbox-search-post-image-wrapper {
    margin: 0.75rem 0;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #eef2f8;
}

.chatbox-search-post-image {
    width: 100%;
    max-height: 260px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.chatbox-search-post-card:hover .chatbox-search-post-image {
    transform: scale(1.02);
}

.chatbox-search-post-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.5rem;
}

.chatbox-search-post-stat {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.8rem;
    color: #9ca3af;
    font-weight: 500;
}

.chatbox-search-post-stat i {
    font-size: 0.85rem;
}

/* ===== EMPTY STATE ===== */
.chatbox-search-empty {
    text-align: center;
    padding: 4rem 1rem;
    animation: chatboxSearchFadeIn 0.6s ease-out;
}

.chatbox-search-empty-icon-wrapper {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbox-search-empty-icon-wrapper i {
    font-size: 2.5rem;
    color: #2563eb;
    z-index: 2;
    animation: chatboxSearchEmptyBounce 2s ease-in-out infinite;
}

@keyframes chatboxSearchEmptyBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.chatbox-search-empty-ring {
    position: absolute;
    inset: 0;
    border: 2px dashed #dbeafe;
    border-radius: 50%;
    animation: chatboxSearchRingRotate 8s linear infinite;
}

@keyframes chatboxSearchRingRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.chatbox-search-empty-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.chatbox-search-empty-text {
    font-size: 0.95rem;
    color: #6b7280;
    max-width: 400px;
    margin: 0 auto 1.5rem;
    line-height: 1.7;
}

.chatbox-search-empty-suggestions {
    background: #ffffff;
    border: 1px solid #e3ebf4;
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    max-width: 400px;
    margin: 0 auto;
    text-align: left;
}

.chatbox-search-empty-suggestions span {
    font-weight: 600;
    font-size: 0.85rem;
    color: #374151;
}

.chatbox-search-empty-suggestions ul {
    margin: 0.5rem 0 0;
    padding-left: 1.2rem;
}

.chatbox-search-empty-suggestions li {
    font-size: 0.85rem;
    color: #6b7280;
    line-height: 1.8;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .chatbox-search-hero {
        padding: 2.5rem 1rem 2rem;
    }

    .chatbox-search-title {
        font-size: 1.6rem;
    }

    .chatbox-search-subtitle {
        font-size: 0.9rem;
    }

    .chatbox-search-icon-wrapper {
        width: 60px;
        height: 60px;
    }

    .chatbox-search-hero-icon {
        font-size: 1.6rem;
    }

    .chatbox-search-input {
        padding: 0.75rem 3rem 0.75rem 2.5rem;
        font-size: 0.9rem;
    }

    .chatbox-search-submit-btn {
        width: 38px;
        height: 38px;
    }

    .chatbox-search-users-grid {
        grid-template-columns: 1fr;
    }

    .chatbox-search-post-card {
        padding: 1rem;
    }

    .chatbox-search-empty {
        padding: 3rem 1rem;
    }
}

@media (max-width: 480px) {
    .chatbox-search-title {
        font-size: 1.3rem;
    }

    .chatbox-search-suggestions {
        display: none;
    }

    .chatbox-search-user-card {
        padding: 0.75rem 1rem;
    }

    .chatbox-search-user-avatar {
        width: 40px;
        height: 40px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.chatbox-search-input');
    const searchForm = document.getElementById('searchForm');

    if (searchInput) {
        // Place cursor at end of input
        const val = searchInput.value;
        if (val) {
            searchInput.setSelectionRange(val.length, val.length);
        }
    }

    if (searchForm) {
        // Add a tiny loading indicator on submit
        searchForm.addEventListener('submit', function () {
            const btn = this.querySelector('.chatbox-search-submit-btn');
            if (btn) {
                btn.innerHTML = '<div class="chatbox-search-spinner"></div>';
                btn.disabled = true;
            }
        });
    }
});
</script>

<style>
/* Small spinner for submit button */
.chatbox-search-spinner {
    width: 18px;
    height: 18px;
    border: 2.5px solid rgba(255, 255, 255, 0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: chatboxSearchSpinnerRotate 0.6s linear infinite;
}

@keyframes chatboxSearchSpinnerRotate {
    to { transform: rotate(360deg); }
}
</style>

@endsection
