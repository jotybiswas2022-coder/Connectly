@extends('frontend.app')

@section('content')

<div class="connectly-search-page">
    <!-- Animated gradient background -->
    <div class="connectly-bg-orb connectly-bg-orb-1"></div>
    <div class="connectly-bg-orb connectly-bg-orb-2"></div>
    <div class="connectly-bg-orb connectly-bg-orb-3"></div>

    <div class="connectly-search-container">
        <!-- ===== HERO SECTION ===== -->
        <div class="connectly-hero">
            <!-- Floating particles -->
            <div class="connectly-particles">
                <span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span>
            </div>

            <div class="connectly-hero-content">
                <!-- Logo icon -->
                <div class="connectly-hero-icon-wrap">
                    <i class="bi bi-search-heart"></i>
                    <div class="connectly-hero-icon-ring"></div>
                    <div class="connectly-hero-icon-ring connectly-hero-icon-ring-2"></div>
                </div>

                <h1 class="connectly-hero-title" id="heroTitle">
                    {{ $query ? 'Search Results' : 'Discover Connectly' }}
                </h1>

                <p class="connectly-hero-subtitle">
                    {{ $query ? "Showing results for &quot;{$query}&quot;" : 'Find users, posts, and more across the community' }}
                </p>

                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="connectly-search-form" id="searchForm">
                    <div class="connectly-search-group">
                        <i class="bi bi-search connectly-search-icon-prefix"></i>
                        <input
                            type="text"
                            name="q"
                            value="{{ $query }}"
                            class="connectly-search-input"
                            placeholder=""
                            autocomplete="off"
                            autofocus
                            id="searchInput"
                        >
                        <span class="connectly-search-placeholder" id="searchPlaceholder">Search users, posts...</span>

                        @if ($query)
                            <a href="{{ route('search') }}" class="connectly-search-clear" title="Clear search">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif

                        <button type="submit" class="connectly-search-submit" id="searchSubmitBtn">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Search glow line -->
                    <div class="connectly-search-glow"></div>
                </form>

                <!-- Trending Suggestions -->
                @if (!$query)
                    <div class="connectly-suggestions">
                        <div class="connectly-suggestions-label">
                            <i class="bi bi-stars"></i> Trending searches
                        </div>
                        <div class="connectly-suggestions-tags">
                            <a href="{{ route('search', ['q' => 'Hello']) }}" class="connectly-tag">
                                <i class="bi bi-hash"></i> Hello
                            </a>
                            <a href="{{ route('search', ['q' => 'Welcome']) }}" class="connectly-tag">
                                <i class="bi bi-hash"></i> Welcome
                            </a>
                            <a href="{{ route('search', ['q' => 'Connect']) }}" class="connectly-tag">
                                <i class="bi bi-hash"></i> Connect
                            </a>
                            <a href="{{ route('search', ['q' => 'Community']) }}" class="connectly-tag">
                                <i class="bi bi-hash"></i> Community
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- ===== RESULTS SECTION ===== -->
        @if ($query)
            <div class="connectly-results" id="resultsSection">
                @if ($users->isEmpty() && $posts->isEmpty())
                    <!-- Empty State -->
                    <div class="connectly-empty">
                        <div class="connectly-empty-icon">
                            <i class="bi bi-search"></i>
                            <div class="connectly-empty-ring"></div>
                            <div class="connectly-empty-ring connectly-empty-ring-2"></div>
                        </div>
                        <h3 class="connectly-empty-title">No results found</h3>
                        <p class="connectly-empty-text">
                            We couldn't find anything matching <strong>"{{ $query }}"</strong>.
                            Try different keywords or browse the community.
                        </p>
                        <div class="connectly-empty-tips">
                            <div class="connectly-tip">
                                <i class="bi bi-pencil"></i>
                                <span>Check your spelling</span>
                            </div>
                            <div class="connectly-tip">
                                <i class="bi bi-arrow-left-right"></i>
                                <span>Try more general keywords</span>
                            </div>
                            <div class="connectly-tip">
                                <i class="bi bi-envelope"></i>
                                <span>Search for user names or emails</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Result Tabs -->
                    <div class="connectly-tabs">
                        @if ($users->isNotEmpty())
                            <button class="connectly-tab active" data-tab="users">
                                <i class="bi bi-people-fill"></i>
                                Users
                                <span class="connectly-tab-badge">{{ $users->count() }}</span>
                            </button>
                        @endif
                        @if ($posts->isNotEmpty())
                            <button class="connectly-tab {{ $users->isEmpty() ? 'active' : '' }}" data-tab="posts">
                                <i class="bi bi-file-text-fill"></i>
                                Posts
                                <span class="connectly-tab-badge">{{ $posts->count() }}</span>
                            </button>
                        @endif
                    </div>

                    <!-- Users Results -->
                    @if ($users->isNotEmpty())
                        <div class="connectly-results-panel active" id="usersPanel">
                            <div class="connectly-users-grid">
                                @foreach ($users as $user)
                                    <a href="{{ route('profile.show', $user->id) }}" class="connectly-user-card" data-delay="{{ $loop->index * 50 }}">
                                        <div class="connectly-user-avatar-wrap">
                                            @if ($user->avatar_path)
                                                <img src="{{ route('media.show', ['path' => $user->avatar_path]) }}"
                                                     alt="{{ $user->name }}"
                                                     class="connectly-user-avatar">
                                            @else
                                                <div class="connectly-user-avatar connectly-user-avatar-fallback">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="connectly-user-online"></span>
                                        </div>
                                        <div class="connectly-user-info">
                                            <span class="connectly-user-name">{{ $user->name }}</span>
                                            <span class="connectly-user-email">{{ $user->email }}</span>
                                        </div>
                                        <div class="connectly-user-arrow">
                                            <i class="bi bi-chevron-right"></i>
                                        </div>
                                        <!-- Card hover glow -->
                                        <div class="connectly-card-glow"></div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Posts Results -->
                    @if ($posts->isNotEmpty())
                        <div class="connectly-results-panel {{ $users->isEmpty() ? 'active' : '' }}" id="postsPanel">
                            <div class="connectly-posts-list">
                                @foreach ($posts as $post)
                                    <a href="{{ route('profile.show', $post->user_id) }}" class="connectly-post-card" data-delay="{{ $loop->index * 50 }}">
                                        <div class="connectly-post-header">
                                            @if ($post->user->avatar_path)
                                                <img src="{{ route('media.show', ['path' => $post->user->avatar_path]) }}"
                                                     alt="{{ $post->user->name }}"
                                                     class="connectly-post-avatar">
                                            @else
                                                <div class="connectly-post-avatar connectly-post-avatar-fallback">
                                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="connectly-post-meta">
                                                <span class="connectly-post-author">{{ $post->user->name }}</span>
                                                <span class="connectly-post-time">{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>

                                        <p class="connectly-post-content">
                                            {{ \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', strip_tags($post->content ?? '')), 200) }}
                                        </p>

                                        @if ($post->image_path)
                                            <div class="connectly-post-image-wrap">
                                                <img src="{{ route('media.show', ['path' => $post->image_path]) }}"
                                                     alt="Post image"
                                                     class="connectly-post-image">
                                            </div>
                                        @endif

                                        <div class="connectly-post-stats">
                                            <span class="connectly-post-stat">
                                                <i class="bi bi-emoji-smile"></i>
                                                {{ $post->reactions_count }}
                                            </span>
                                            <span class="connectly-post-stat">
                                                <i class="bi bi-chat-dots"></i>
                                                {{ $post->comments_count }}
                                            </span>
                                        </div>

                                        <div class="connectly-card-glow"></div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>

<style>
/* ==============================================================
   CONNECTLY SEARCH — MODERN TRENDING DESIGN
   Color Scheme: Primary #2563EB | Light #60A5FA | Dark #1E40AF
   ============================================================== */

:root {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #F0F5FF;
    --clr-surface: rgba(255, 255, 255, 0.85);
    --clr-glass: rgba(255, 255, 255, 0.72);
    --clr-glass-border: rgba(37, 99, 235, 0.08);
    --clr-text: #0F172A;
    --clr-muted: #64748B;
    --clr-soft: #94A3B8;
    --gradient-primary: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
    --gradient-light: linear-gradient(135deg, #60A5FA 0%, #2563EB 100%);
    --gradient-mesh: linear-gradient(135deg, #F0F5FF 0%, #DBEAFE 50%, #EFF6FF 100%);
    --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
    --shadow-md: 0 8px 24px rgba(15, 23, 42, 0.06);
    --shadow-lg: 0 16px 48px rgba(15, 23, 42, 0.08);
    --shadow-glow: 0 8px 32px rgba(37, 99, 235, 0.2);
    --radius-sm: 10px;
    --radius-md: 16px;
    --radius-lg: 20px;
    --radius-xl: 28px;
}

/* ===== PAGE CONTAINER ===== */
.connectly-search-page {
    position: relative;
    min-height: 100vh;
    padding: 0 0 3rem;
    background: var(--gradient-mesh);
    overflow: hidden;
}

/* ===== ANIMATED BG ORBS ===== */
.connectly-bg-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
    opacity: 0.5;
}

.connectly-bg-orb-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.15), transparent 70%);
    top: -150px;
    right: -100px;
    animation: orbFloat1 20s ease-in-out infinite;
}

.connectly-bg-orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(96, 165, 250, 0.12), transparent 70%);
    bottom: -100px;
    left: -80px;
    animation: orbFloat2 25s ease-in-out infinite;
}

.connectly-bg-orb-3 {
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(30, 64, 175, 0.1), transparent 70%);
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: orbFloat3 18s ease-in-out infinite;
}

@keyframes orbFloat1 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(40px, 60px) scale(1.1); }
    66% { transform: translate(-20px, 30px) scale(0.9); }
}

@keyframes orbFloat2 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(-30px, -40px) scale(1.15); }
    66% { transform: translate(20px, -20px) scale(0.95); }
}

@keyframes orbFloat3 {
    0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.4; }
    50% { transform: translate(-50%, -50%) scale(1.3); opacity: 0.6; }
}

/* ===== CONTAINER ===== */
.connectly-search-container {
    position: relative;
    z-index: 1;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ===== PARTICLES ===== */
.connectly-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.connectly-particles span {
    position: absolute;
    width: 6px;
    height: 6px;
    background: rgba(37, 99, 235, 0.2);
    border-radius: 50%;
    animation: particleFloat 15s infinite;
}

.connectly-particles span:nth-child(1) { left: 10%; top: 20%; width: 8px; height: 8px; animation-delay: 0s; animation-duration: 18s; }
.connectly-particles span:nth-child(2) { left: 25%; top: 60%; width: 5px; height: 5px; animation-delay: 1s; animation-duration: 14s; }
.connectly-particles span:nth-child(3) { left: 45%; top: 15%; width: 7px; height: 7px; animation-delay: 2s; animation-duration: 16s; }
.connectly-particles span:nth-child(4) { left: 65%; top: 70%; width: 4px; height: 4px; animation-delay: 0.5s; animation-duration: 20s; }
.connectly-particles span:nth-child(5) { left: 80%; top: 30%; width: 6px; height: 6px; animation-delay: 1.5s; animation-duration: 12s; }
.connectly-particles span:nth-child(6) { left: 15%; top: 80%; width: 5px; height: 5px; animation-delay: 3s; animation-duration: 17s; }
.connectly-particles span:nth-child(7) { left: 55%; top: 45%; width: 9px; height: 9px; animation-delay: 2.5s; animation-duration: 19s; }
.connectly-particles span:nth-child(8) { left: 35%; top: 90%; width: 4px; height: 4px; animation-delay: 0.8s; animation-duration: 15s; }
.connectly-particles span:nth-child(9) { left: 90%; top: 55%; width: 7px; height: 7px; animation-delay: 1.8s; animation-duration: 13s; }
.connectly-particles span:nth-child(10) { left: 50%; top: 5%; width: 5px; height: 5px; animation-delay: 3.5s; animation-duration: 21s; }

@keyframes particleFloat {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
    25% { transform: translateY(-30px) scale(1.4); opacity: 0.6; }
    50% { transform: translateY(-60px) scale(0.8); opacity: 0.2; }
    75% { transform: translateY(-20px) scale(1.2); opacity: 0.5; }
}

/* ===== HERO ===== */
.connectly-hero {
    position: relative;
    padding: 3.5rem 1rem 2.5rem;
    text-align: center;
    overflow: hidden;
}

.connectly-hero-content {
    position: relative;
    z-index: 2;
    animation: heroEntrance 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

@keyframes heroEntrance {
    0% { opacity: 0; transform: translateY(40px) scale(0.96); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

/* ===== HERO ICON ===== */
.connectly-hero-icon-wrap {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    border-radius: 50%;
    box-shadow: 0 12px 40px rgba(37, 99, 235, 0.3);
    animation: iconPulse 3s ease-in-out infinite;
}

.connectly-hero-icon-wrap i {
    font-size: 2.6rem;
    color: #fff;
    position: relative;
    z-index: 2;
    animation: iconHeartbeat 3s ease-in-out infinite;
}

@keyframes iconHeartbeat {
    0%, 100% { transform: scale(1); }
    15% { transform: scale(1.15); }
    30% { transform: scale(1); }
    45% { transform: scale(1.08); }
    60% { transform: scale(1); }
}

.connectly-hero-icon-ring {
    position: absolute;
    inset: -5px;
    border-radius: 50%;
    border: 2px solid rgba(96, 165, 250, 0.25);
    animation: ringExpand 3s ease-out infinite;
}

.connectly-hero-icon-ring-2 {
    inset: -10px;
    border-width: 1.5px;
    animation-delay: 1.5s;
    border-color: rgba(37, 99, 235, 0.15);
}

@keyframes ringExpand {
    0% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.12); opacity: 0.2; }
    100% { transform: scale(1); opacity: 0.6; }
}

@keyframes iconPulse {
    0%, 100% { box-shadow: 0 12px 40px rgba(37, 99, 235, 0.3); }
    50% { box-shadow: 0 16px 60px rgba(37, 99, 235, 0.45); }
}

/* ===== HERO TITLE ===== */
.connectly-hero-title {
    font-size: 2.6rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.6rem;
    line-height: 1.2;
}

.connectly-hero-subtitle {
    font-size: 1.05rem;
    color: var(--clr-muted);
    margin-bottom: 2rem;
    font-weight: 400;
}

/* ===== SEARCH FORM ===== */
.connectly-search-form {
    max-width: 620px;
    margin: 0 auto;
    position: relative;
}

.connectly-search-group {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--clr-glass);
    backdrop-filter: blur(16px) saturate(1.4);
    -webkit-backdrop-filter: blur(16px) saturate(1.4);
    border: 2px solid rgba(37, 99, 235, 0.1);
    border-radius: var(--radius-xl);
    padding: 0.3rem;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: var(--shadow-md);
}

.connectly-search-group:focus-within {
    border-color: var(--clr-primary);
    box-shadow: 0 8px 40px rgba(37, 99, 235, 0.18), 0 0 0 4px rgba(37, 99, 235, 0.06);
    transform: translateY(-3px) scale(1.01);
    background: rgba(255, 255, 255, 0.95);
}

.connectly-search-icon-prefix {
    position: absolute;
    left: 20px;
    color: var(--clr-soft);
    font-size: 1.2rem;
    pointer-events: none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 3;
}

.connectly-search-group:focus-within .connectly-search-icon-prefix {
    color: var(--clr-primary);
    transform: scale(1.1);
}

.connectly-search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 1rem 4rem 1rem 3.5rem;
    font-size: 1.08rem;
    color: var(--clr-text);
    background: transparent;
    border-radius: 24px;
    position: relative;
    z-index: 2;
    caret-color: var(--clr-primary);
}

.connectly-search-input::placeholder {
    color: transparent;
}

.connectly-search-placeholder {
    position: absolute;
    left: 3.5rem;
    color: var(--clr-soft);
    font-size: 1.08rem;
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 1;
}

.connectly-search-input:focus ~ .connectly-search-placeholder,
.connectly-search-input:not(:placeholder-shown) ~ .connectly-search-placeholder {
    opacity: 0;
    transform: translateY(-8px) scale(0.95);
}

.connectly-search-clear {
    position: absolute;
    right: 64px;
    color: var(--clr-soft);
    text-decoration: none;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 3;
    font-size: 0.85rem;
}

.connectly-search-clear:hover {
    color: #EF4444;
    background: rgba(239, 68, 68, 0.1);
    transform: scale(1.15) rotate(90deg);
}

.connectly-search-submit {
    width: 50px;
    height: 50px;
    border: none;
    background: var(--gradient-primary);
    color: #fff;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
    position: relative;
    z-index: 3;
    overflow: hidden;
}

.connectly-search-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
    opacity: 0;
    transition: opacity 0.35s ease;
    border-radius: 16px;
}

.connectly-search-submit:hover::before {
    opacity: 1;
}

.connectly-search-submit i {
    position: relative;
    z-index: 2;
    font-size: 1.2rem;
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.connectly-search-submit:hover {
    transform: scale(1.05) translateY(-2px);
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
}

.connectly-search-submit:hover i {
    transform: translateX(4px);
}

.connectly-search-submit:active {
    transform: scale(0.92);
}

/* Search glow line */
.connectly-search-glow {
    position: absolute;
    bottom: -6px;
    left: 15%;
    right: 15%;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--clr-primary), var(--clr-light), var(--clr-primary), transparent);
    background-size: 200% auto;
    border-radius: 4px;
    opacity: 0;
    filter: blur(4px);
    transition: all 0.5s ease;
}

.connectly-search-group:focus-within ~ .connectly-search-glow {
    opacity: 1;
    animation: searchGlowSlide 2s linear infinite;
}

@keyframes searchGlowSlide {
    0% { background-position: -200% center; }
    100% { background-position: 200% center; }
}

/* ===== SUGGESTIONS ===== */
.connectly-suggestions {
    margin-top: 1.8rem;
    animation: fadeInUp 0.6s ease-out 0.4s backwards;
}

.connectly-suggestions-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 0.85rem;
    color: var(--clr-muted);
    font-weight: 500;
    margin-bottom: 0.8rem;
}

.connectly-suggestions-label i {
    color: var(--clr-primary);
    animation: starSpin 3s linear infinite;
}

@keyframes starSpin {
    0% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-20deg); }
    100% { transform: rotate(0deg); }
}

.connectly-suggestions-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    justify-content: center;
}

.connectly-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 0.55rem 1.3rem;
    background: var(--clr-glass);
    backdrop-filter: blur(8px) saturate(1.2);
    -webkit-backdrop-filter: blur(8px) saturate(1.2);
    border: 1.5px solid rgba(37, 99, 235, 0.1);
    border-radius: 50px;
    color: var(--clr-muted);
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
}

.connectly-tag i {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.connectly-tag::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gradient-primary);
    opacity: 0;
    transition: opacity 0.35s ease;
    border-radius: 50px;
}

.connectly-tag:hover {
    border-color: transparent;
    color: #fff;
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
}

.connectly-tag:hover::before {
    opacity: 1;
}

.connectly-tag:hover i {
    transform: rotate(-15deg);
}

.connectly-tag > * {
    position: relative;
    z-index: 2;
}

/* ===== RESULTS SECTION ===== */
.connectly-results {
    padding: 0 0 3rem;
    animation: resultsEntrance 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s backwards;
}

@keyframes resultsEntrance {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ===== TABS ===== */
.connectly-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    padding: 0.35rem;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: var(--radius-md);
    border: 1px solid rgba(37, 99, 235, 0.06);
    width: fit-content;
}

.connectly-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.65rem 1.2rem;
    border: none;
    background: transparent;
    color: var(--clr-muted);
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
}

.connectly-tab i {
    font-size: 1rem;
}

.connectly-tab:hover {
    color: var(--clr-primary);
    background: rgba(37, 99, 235, 0.04);
}

.connectly-tab.active {
    background: #fff;
    color: var(--clr-primary);
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
}

.connectly-tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    background: rgba(37, 99, 235, 0.1);
    color: var(--clr-primary);
    font-size: 0.72rem;
    font-weight: 700;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.connectly-tab.active .connectly-tab-badge {
    background: var(--clr-primary);
    color: #fff;
}

/* ===== RESULTS PANELS ===== */
.connectly-results-panel {
    display: none;
    animation: panelSlideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

.connectly-results-panel.active {
    display: block;
}

@keyframes panelSlideIn {
    0% { opacity: 0; transform: translateY(16px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ===== USERS GRID ===== */
.connectly-users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 0.8rem;
}

/* ===== USER CARD ===== */
.connectly-user-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--clr-surface);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(37, 99, 235, 0.06);
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    animation: cardEntrance 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
}

@keyframes cardEntrance {
    0% { opacity: 0; transform: translateY(20px) scale(0.97); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.connectly-user-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3.5px;
    background: transparent;
    transition: background 0.4s ease;
    border-radius: 0 2px 2px 0;
}

.connectly-user-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: var(--shadow-lg);
    border-color: rgba(37, 99, 235, 0.15);
    background: rgba(255, 255, 255, 0.95);
}

.connectly-user-card:hover::before {
    background: var(--clr-primary);
}

/* Card glow effect */
.connectly-card-glow {
    position: absolute;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.08), transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    opacity: 0;
    transition: all 0.5s ease;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
}

.connectly-user-card:hover .connectly-card-glow,
.connectly-post-card:hover .connectly-card-glow {
    opacity: 1;
    transform: translate(-50%, -50%) scale(3);
}

.connectly-user-avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.connectly-user-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid #EEF2F8;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.connectly-user-card:hover .connectly-user-avatar {
    transform: scale(1.1);
    border-color: #DBEAFE;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.connectly-user-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    color: #fff;
    background: var(--gradient-primary);
}

.connectly-user-online {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 12px;
    height: 12px;
    background: #10B981;
    border: 2.5px solid #fff;
    border-radius: 50%;
    animation: onlinePulse 2s ease-in-out infinite;
}

@keyframes onlinePulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
    50% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
}

.connectly-user-info {
    flex: 1;
    min-width: 0;
}

.connectly-user-name {
    display: block;
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--clr-text);
    margin-bottom: 2px;
    transition: all 0.3s ease;
}

.connectly-user-card:hover .connectly-user-name {
    color: var(--clr-primary);
}

.connectly-user-email {
    display: block;
    font-size: 0.8rem;
    color: var(--clr-soft);
}

.connectly-user-arrow {
    color: #D1D5DB;
    font-size: 0.9rem;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    flex-shrink: 0;
    position: relative;
    z-index: 2;
}

.connectly-user-card:hover .connectly-user-arrow {
    color: var(--clr-primary);
    transform: translateX(6px);
}

/* ===== POSTS LIST ===== */
.connectly-posts-list {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

/* ===== POST CARD ===== */
.connectly-post-card {
    position: relative;
    display: block;
    padding: 1.35rem 1.5rem;
    background: var(--clr-surface);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(37, 99, 235, 0.06);
    border-radius: var(--radius-lg);
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    animation: cardEntrance 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
}

.connectly-post-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3.5px;
    background: transparent;
    transition: background 0.4s ease;
    border-radius: 0 2px 2px 0;
}

.connectly-post-card:hover {
    transform: translateY(-6px) scale(1.005);
    box-shadow: var(--shadow-lg);
    border-color: rgba(37, 99, 235, 0.15);
    background: rgba(255, 255, 255, 0.95);
}

.connectly-post-card:hover::before {
    background: var(--clr-primary);
}

.connectly-post-header {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 0.8rem;
}

.connectly-post-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid #EEF2F8;
    flex-shrink: 0;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.connectly-post-card:hover .connectly-post-avatar {
    transform: scale(1.1);
    border-color: #DBEAFE;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.connectly-post-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
    color: #fff;
    background: var(--gradient-primary);
    flex-shrink: 0;
}

.connectly-post-meta {
    flex: 1;
    min-width: 0;
}

.connectly-post-author {
    display: block;
    font-weight: 600;
    font-size: 0.92rem;
    color: var(--clr-dark);
    transition: color 0.3s ease;
}

.connectly-post-card:hover .connectly-post-author {
    color: var(--clr-primary);
}

.connectly-post-time {
    font-size: 0.78rem;
    color: var(--clr-soft);
}

.connectly-post-content {
    font-size: 0.95rem;
    color: #475569;
    line-height: 1.7;
    margin-bottom: 0.6rem;
    word-wrap: break-word;
}

.connectly-post-image-wrap {
    margin: 0.75rem 0;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 1px solid #EEF2F8;
    transition: box-shadow 0.35s ease;
}

.connectly-post-card:hover .connectly-post-image-wrap {
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
}

.connectly-post-image {
    width: 100%;
    max-height: 280px;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: block;
}

.connectly-post-card:hover .connectly-post-image {
    transform: scale(1.04);
}

.connectly-post-stats {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    margin-top: 0.6rem;
    position: relative;
    z-index: 2;
}

.connectly-post-stat {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.82rem;
    color: var(--clr-soft);
    font-weight: 500;
    transition: all 0.3s ease;
}

.connectly-post-card:hover .connectly-post-stat {
    color: var(--clr-muted);
}

.connectly-post-stat i {
    font-size: 0.9rem;
}

/* ===== EMPTY STATE ===== */
.connectly-empty {
    text-align: center;
    padding: 4rem 1rem;
    animation: fadeInUp 0.6s ease-out;
}

.connectly-empty-icon {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.connectly-empty-icon i {
    font-size: 3rem;
    color: var(--clr-primary);
    z-index: 2;
    animation: emptyBounce 2.5s ease-in-out infinite;
}

@keyframes emptyBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

.connectly-empty-ring {
    position: absolute;
    inset: -3px;
    border: 2.5px dashed rgba(37, 99, 235, 0.15);
    border-radius: 50%;
    animation: ringRotate 12s linear infinite;
}

.connectly-empty-ring-2 {
    inset: -9px;
    border-color: rgba(96, 165, 250, 0.1);
    animation-duration: 16s;
    animation-direction: reverse;
}

@keyframes ringRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.connectly-empty-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--clr-text);
    margin-bottom: 0.5rem;
}

.connectly-empty-text {
    font-size: 0.95rem;
    color: var(--clr-muted);
    max-width: 420px;
    margin: 0 auto 1.5rem;
    line-height: 1.7;
}

.connectly-empty-tips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    justify-content: center;
    max-width: 450px;
    margin: 0 auto;
}

.connectly-tip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.6rem 1.2rem;
    background: var(--clr-glass);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(37, 99, 235, 0.06);
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    color: var(--clr-muted);
    font-weight: 500;
    transition: all 0.3s ease;
}

.connectly-tip i {
    color: var(--clr-primary);
    font-size: 0.9rem;
}

.connectly-tip:hover {
    background: rgba(255, 255, 255, 0.95);
    border-color: rgba(37, 99, 235, 0.12);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* ===== SPINNER ===== */
.connectly-spinner {
    width: 22px;
    height: 22px;
    border: 2.5px solid rgba(255, 255, 255, 0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spinnerRotate 0.6s linear infinite;
}

@keyframes spinnerRotate {
    to { transform: rotate(360deg); }
}

/* ===== KEYFRAMES ===== */
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(16px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .connectly-hero {
        padding: 2rem 0.5rem 1.5rem;
    }

    .connectly-hero-title {
        font-size: 1.7rem;
    }

    .connectly-hero-subtitle {
        font-size: 0.9rem;
    }

    .connectly-hero-icon-wrap {
        width: 70px;
        height: 70px;
    }

    .connectly-hero-icon-wrap i {
        font-size: 2rem;
    }

    .connectly-search-input {
        padding: 0.85rem 3.5rem 0.85rem 3rem;
        font-size: 0.95rem;
    }

    .connectly-search-icon-prefix {
        left: 16px;
        font-size: 1rem;
    }

    .connectly-search-placeholder {
        left: 3rem;
        font-size: 0.95rem;
    }

    .connectly-search-submit {
        width: 42px;
        height: 42px;
    }

    .connectly-search-clear {
        right: 52px;
    }

    .connectly-users-grid {
        grid-template-columns: 1fr;
    }

    .connectly-post-card {
        padding: 1rem 1.2rem;
    }

    .connectly-empty {
        padding: 3rem 0.5rem;
    }

    .connectly-tabs {
        width: 100%;
        justify-content: center;
    }

    .connectly-empty-tips {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .connectly-hero-title {
        font-size: 1.4rem;
    }

    .connectly-suggestions {
        display: none;
    }

    .connectly-user-card {
        padding: 0.8rem 1rem;
    }

    .connectly-user-avatar {
        width: 44px;
        height: 44px;
    }

    .connectly-tab {
        padding: 0.5rem 0.9rem;
        font-size: 0.82rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    const submitBtn = document.getElementById('searchSubmitBtn');

    // ===== 1. Cursor position on load =====
    if (searchInput) {
        const val = searchInput.value;
        if (val) {
            searchInput.setSelectionRange(val.length, val.length);
        }

        // ===== 2. Ripple effect on submit button =====
        submitBtn.addEventListener('click', function (e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255,255,255,0.3);
                border-radius: 50%;
                pointer-events: none;
                animation: rippleEffect 0.6s ease-out forwards;
            `;
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    }

    // ===== 3. Form submit spinner =====
    if (searchForm) {
        searchForm.addEventListener('submit', function () {
            const btn = this.querySelector('.connectly-search-submit');
            if (btn) {
                btn.innerHTML = '<div class="connectly-spinner"></div>';
                btn.disabled = true;
            }
        });
    }

    // ===== 4. Tab switching =====
    const tabs = document.querySelectorAll('.connectly-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.dataset.tab;

            // Update tabs
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Update panels
            document.querySelectorAll('.connectly-results-panel').forEach(p => {
                p.classList.remove('active');
            });
            const panel = document.getElementById(target + 'Panel');
            if (panel) {
                panel.classList.add('active');
                // Re-trigger animation
                panel.style.animation = 'none';
                panel.offsetHeight;
                panel.style.animation = '';
            }
        });
    });

    // ===== 5. Intersection Observer for staggered card animations =====
    const cards = document.querySelectorAll('.connectly-user-card, .connectly-post-card');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const delay = parseInt(card.dataset.delay) || 0;
                    card.style.animationDelay = delay + 'ms';
                    card.style.opacity = '1';
                    observer.unobserve(card);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px 50px 0px' });

        cards.forEach(card => {
            card.style.opacity = '0';
            observer.observe(card);
        });
    } else {
        // Fallback: just show all cards
        cards.forEach(card => {
            const delay = parseInt(card.dataset.delay) || 0;
            card.style.animationDelay = delay + 'ms';
        });
    }

    // ===== 6. Magnetic hover effect on submit button =====
    if (submitBtn) {
        submitBtn.addEventListener('mousemove', function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const dist = Math.sqrt(x * x + y * y);
            const maxDist = 30;
            if (dist < maxDist) {
                const strength = (1 - dist / maxDist) * 6;
                this.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px) scale(1.05)`;
            }
        });

        submitBtn.addEventListener('mouseleave', function () {
            this.style.transform = '';
        });
    }

    // ===== 7. Parallax tilt on user cards =====
    const userCards = document.querySelectorAll('.connectly-user-card, .connectly-post-card');
    userCards.forEach(card => {
        card.addEventListener('mousemove', function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            // Position the glow
            const glow = this.querySelector('.connectly-card-glow');
            if (glow) {
                glow.style.left = x + 'px';
                glow.style.top = y + 'px';
                glow.style.transform = 'translate(-50%, -50%) scale(2.5)';
            }
        });

        card.addEventListener('mouseleave', function () {
            const glow = this.querySelector('.connectly-card-glow');
            if (glow) {
                glow.style.left = '50%';
                glow.style.top = '50%';
                glow.style.transform = 'translate(-50%, -50%) scale(0)';
            }
        });
    });
});

// Add ripple animation keyframes dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes rippleEffect {
        0% { transform: scale(0); opacity: 1; }
        100% { transform: scale(4); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>

@endsection
