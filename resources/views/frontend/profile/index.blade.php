@extends('frontend.app')

@section('content')

<div class="cl-profile">

    {{-- ===== HERO BANNER ===== --}}
    <div class="cl-profile-hero">
        <div class="cl-profile-hero-bg">
            <div class="cl-profile-hero-grid"></div>
            <div class="cl-profile-hero-orb cl-profile-hero-orb-1"></div>
            <div class="cl-profile-hero-orb cl-profile-hero-orb-2"></div>
            <div class="cl-profile-hero-orb cl-profile-hero-orb-3"></div>
            <div class="cl-profile-hero-orb cl-profile-hero-orb-4"></div>
        </div>
        <div class="cl-profile-hero-particles" id="heroParticles"></div>
        <div class="cl-profile-hero-glow"></div>
        <div class="cl-profile-hero-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path d="M0,60 C360,120 720,0 1440,60 L1440,120 L0,120 Z" fill="var(--cl-profile-bg)"/></svg>
        </div>
    </div>

    <div class="cl-profile-container">

        @if (session('success'))
            <div class="cl-profile-toast" id="successToast">
                <div class="cl-profile-toast-icon"><i class="bi bi-check-circle-fill"></i></div>
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        {{-- ===== PROFILE HEADER ===== --}}
        <div class="cl-profile-header">
            <div class="cl-profile-avatar-wrap">
                @if ($user->avatar_path)
                    <img src="{{ route('media.show', ['path' => $user->avatar_path]) }}" alt="{{ $user->name }}" class="cl-profile-avatar" loading="lazy">
                @else
                    <div class="cl-profile-avatar cl-profile-avatar-fallback">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
                <div class="cl-profile-avatar-ring"></div>
                <div class="cl-profile-avatar-ring-2"></div>
                <div class="cl-profile-avatar-ring-3"></div>
                @if($isOwner)
                    <div class="cl-profile-avatar-badge" title="Edit Profile">
                        <i class="bi bi-camera-fill"></i>
                    </div>
                @endif
            </div>

            <h1 class="cl-profile-name">{{ $user->name }}</h1>
            <p class="cl-profile-email">{{ $user->email }}</p>

            <div class="cl-profile-meta">
                <span class="cl-profile-meta-item">
                    <i class="bi bi-calendar3"></i>
                    Joined {{ $user->created_at->format('M Y') }}
                </span>
                <span class="cl-profile-meta-dot"></span>
                <span class="cl-profile-meta-item">
                    <i class="bi bi-geo-alt"></i>
                    Connectly
                </span>
                <span class="cl-profile-meta-dot"></span>
                <span class="cl-profile-meta-item">
                    <i class="bi bi-clock"></i>
                    {{ $user->created_at->diffForHumans() }}
                </span>
            </div>

            {{-- Bio / About --}}
            @if($user->bio)
            <p class="cl-profile-bio">
                <i class="bi bi-quote"></i>
                {{ $user->bio }}
            </p>
            @endif
        </div>

        {{-- ===== SETTINGS GEAR (OWNER ONLY) ===== --}}
        @if($isOwner)
        <a href="{{ route('profile.settings', $user->id) }}" class="cl-profile-settings-btn" title="Profile Settings">
            <i class="bi bi-gear-fill"></i>
        </a>
        @endif

        {{-- ===== STATS ROW ===== --}}
        <div class="cl-profile-stats">
            <div class="cl-profile-stat" data-count="{{ $posts->count() }}">
                <span class="cl-profile-stat-value cl-profile-stat-animated">{{ $posts->count() }}</span>
                <span class="cl-profile-stat-label">
                    <i class="bi bi-journal-text"></i> Posts
                </span>
            </div>
            <div class="cl-profile-stat" data-count="{{ $posts->where('is_pinned', true)->count() }}">
                <span class="cl-profile-stat-value cl-profile-stat-animated">{{ $posts->where('is_pinned', true)->count() }}</span>
                <span class="cl-profile-stat-label">
                    <i class="bi bi-pin-angle-fill"></i> Pinned
                </span>
            </div>
            <div class="cl-profile-stat" data-count="{{ $friendsCount }}">
                <span class="cl-profile-stat-value cl-profile-stat-animated cl-profile-friend-count">{{ $friendsCount }}</span>
                <span class="cl-profile-stat-label">
                    <i class="bi bi-people-fill"></i> Friends
                </span>
            </div>
            <div class="cl-profile-stat" data-count="{{ $posts->sum('reactions_count') }}">
                <span class="cl-profile-stat-value cl-profile-stat-animated">{{ $posts->sum('reactions_count') }}</span>
                <span class="cl-profile-stat-label">
                    <i class="bi bi-heart-fill"></i> Reactions
                </span>
            </div>
        </div>

        {{-- ===== FRIEND ACTIONS ===== --}}
        @unless($isOwner)
        <div class="cl-profile-actions">
            @php
                $frSentByMe = $friendRequest && (int) $friendRequest->sender_id === (int) auth()->id();
                $frSentByThem = $friendRequest && (int) $friendRequest->sender_id === (int) $user->id;
            @endphp

            @if (!$friendRequest)
                <form action="{{ route('friend-request.send', $user->id) }}" method="POST" class="cl-profile-action-form">
                    @csrf
                    <button type="submit" class="cl-profile-btn cl-profile-btn-primary">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Add Friend</span>
                    </button>
                </form>
            @elseif ($friendStatus === 'pending' && $frSentByMe)
                <div class="cl-profile-btn-group">
                    <span class="cl-profile-status-badge cl-profile-status-pending">
                        <i class="bi bi-hourglass-split"></i> Request Sent
                    </span>
                    <form action="{{ route('friend-request.cancel', $friendRequest->id) }}" method="POST" class="cl-profile-cancel-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-danger" title="Cancel Request"><i class="bi bi-x-lg"></i></button>
                    </form>
                </div>
            @elseif ($friendStatus === 'pending' && $frSentByThem)
                <div class="cl-profile-btn-group">
                    <form action="{{ route('friend-request.accept', $friendRequest->id) }}" method="POST" class="flex-grow-1 cl-profile-accept-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                        @csrf @method('PUT')
                        <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-check-lg"></i> Accept Request</button>
                    </form>
                    <form action="{{ route('friend-request.reject', $friendRequest->id) }}" method="POST" class="cl-profile-reject-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                        @csrf @method('PUT')
                        <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-danger" title="Reject"><i class="bi bi-x-lg"></i></button>
                    </form>
                </div>
            @elseif ($friendStatus === 'accepted')
                <div class="cl-profile-btn-group">
                    <span class="cl-profile-status-badge cl-profile-status-friends">
                        <i class="bi bi-people-fill"></i> Friends
                    </span>
                    <form action="{{ route('friend-request.unfriend', $user->id) }}" method="POST" class="cl-profile-unfriend-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-danger" title="Unfriend"><i class="bi bi-person-dash-fill"></i></button>
                    </form>
                </div>
            @elseif ($friendStatus === 'rejected' && $frSentByMe)
                <form action="{{ route('friend-request.send', $user->id) }}" method="POST" class="cl-profile-action-form">
                    @csrf
                    <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-person-plus-fill"></i> Add Friend</button>
                </form>
            @elseif ($friendStatus === 'rejected' && $frSentByThem)
                <div class="cl-profile-btn-group">
                    <span class="cl-profile-status-badge cl-profile-status-rejected"><i class="bi bi-x-circle"></i> Request Rejected</span>
                    <form action="{{ route('friend-request.send', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-primary" title="Send Again"><i class="bi bi-arrow-clockwise"></i></button>
                    </form>
                </div>
            @endif

            <a href="{{ route('message', $user->id) }}" class="cl-profile-btn cl-profile-btn-secondary">
                <i class="bi bi-chat-dots-fill"></i>
                <span>Send Message</span>
            </a>
        </div>
        @endunless

        {{-- ===== POSTS SECTION ===== --}}
        <div class="cl-profile-posts">
            <div class="cl-profile-posts-header">
                <div class="cl-profile-posts-header-icon">
                    <i class="bi bi-journal-richtext"></i>
                </div>
                <div>
                    <span class="cl-profile-posts-header-title">Posts</span>
                    <span class="cl-profile-posts-header-sub">Latest from {{ $isOwner ? 'you' : $user->name }}</span>
                </div>
                <span class="cl-profile-posts-count">{{ $posts->count() }}</span>
            </div>

            <div class="cl-profile-posts-divider"></div>

            <div class="cl-profile-posts-list">
                @forelse ($posts as $post)
                    @include('frontend.partials.post', ['post' => $post, 'showPinButton' => $isOwner])
                @empty
                    <div class="cl-profile-empty">
                        <div class="cl-profile-empty-graphic">
                            <div class="cl-profile-empty-icon-bg">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="cl-profile-empty-dot-1"></div>
                            <div class="cl-profile-empty-dot-2"></div>
                        </div>
                        <h5>No posts yet</h5>
                        <p>
                            @if($isOwner)
                                Share your first post with the community!
                            @else
                                {{ $user->name }} hasn't posted anything yet.
                            @endif
                        </p>
                        @if($isOwner)
                            <a href="{{ route('feed') }}" class="cl-profile-btn cl-profile-btn-primary" style="max-width:200px;margin:1rem auto 0;">
                                <i class="bi bi-plus-lg"></i> Create Post
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
/* ============================================================
   CL-PROFILE — PREMIUM REDESIGN
   ============================================================ */

:root {
    --cl-profile-bg: #f0f2f5;
    --cl-profile-surface: #ffffff;
    --cl-profile-surface-alt: #f8f9fa;
    --cl-profile-border: #e4e6eb;
    --cl-profile-border-light: #f0f0f2;
    --cl-profile-text: #050505;
    --cl-profile-text-secondary: #65676b;
    --cl-profile-text-muted: #8a8d91;
    --cl-profile-primary: #2563eb;
    --cl-profile-primary-dark: #1d4ed8;
    --cl-profile-primary-light: #60a5fa;
    --cl-profile-primary-subtle: rgba(37,99,235,0.08);
    --cl-profile-primary-glow: rgba(37,99,235,0.15);
    --cl-profile-success: #10b981;
    --cl-profile-success-subtle: rgba(16,185,129,0.1);
    --cl-profile-danger: #ef4444;
    --cl-profile-danger-subtle: rgba(239,68,68,0.08);
    --cl-profile-warning: #f59e0b;
    --cl-profile-radius: 20px;
    --cl-profile-radius-sm: 14px;
    --cl-profile-radius-xs: 10px;
    --cl-profile-radius-pill: 9999px;
    --cl-profile-shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
    --cl-profile-shadow: 0 2px 8px rgba(0,0,0,0.04);
    --cl-profile-shadow-md: 0 8px 24px rgba(0,0,0,0.06);
    --cl-profile-shadow-lg: 0 16px 48px rgba(0,0,0,0.08);
    --cl-profile-shadow-xl: 0 24px 64px rgba(0,0,0,0.10);
    --cl-profile-transition: 0.3s cubic-bezier(.4,0,.2,1);
    --cl-profile-spring: 0.5s cubic-bezier(.34,1.56,.64,1);
    --cl-profile-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.cl-profile {
    min-height: 100dvh;
    background: var(--cl-profile-bg);
    position: relative;
    font-family: var(--cl-profile-font);
}

/* ===== HERO BANNER ===== */
.cl-profile-hero {
    position: relative;
    height: 300px;
    overflow: hidden;
    background: linear-gradient(135deg, #0b1120 0%, #162a4a 35%, #1a3a6b 60%, #0f172a 100%);
}

.cl-profile-hero-bg {
    position: absolute;
    inset: 0;
    overflow: hidden;
}

.cl-profile-hero-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    mask-image: radial-gradient(ellipse at 50% 60%, black 30%, transparent 70%);
    -webkit-mask-image: radial-gradient(ellipse at 50% 60%, black 30%, transparent 70%);
}

.cl-profile-hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.35;
}

.cl-profile-hero-orb-1 {
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(37,99,235,0.3), transparent);
    top: -200px; right: -150px;
    animation: heroOrbFloat1 16s ease-in-out infinite;
}

.cl-profile-hero-orb-2 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(96,165,250,0.2), transparent);
    bottom: -160px; left: -100px;
    animation: heroOrbFloat2 14s ease-in-out infinite reverse;
}

.cl-profile-hero-orb-3 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(139,92,246,0.15), transparent);
    top: 40%; left: 55%;
    animation: heroOrbFloat3 18s ease-in-out infinite;
}

.cl-profile-hero-orb-4 {
    width: 250px; height: 250px;
    background: radial-gradient(circle, rgba(16,185,129,0.1), transparent);
    bottom: 20%; right: 30%;
    animation: heroOrbFloat4 12s ease-in-out infinite;
}

@keyframes heroOrbFloat1 {
    0%,100%{ transform: translate(0,0) scale(1); }
    50%{ transform: translate(50px,-50px) scale(1.1); }
}
@keyframes heroOrbFloat2 {
    0%,100%{ transform: translate(0,0) scale(1); }
    50%{ transform: translate(-40px,40px) scale(1.15); }
}
@keyframes heroOrbFloat3 {
    0%,100%{ transform: translate(0,0) scale(1); opacity: 0.3; }
    50%{ transform: translate(30px,-30px) scale(1.2); opacity: 0.5; }
}
@keyframes heroOrbFloat4 {
    0%,100%{ transform: translate(0,0) scale(1); opacity: 0.15; }
    50%{ transform: translate(-20px,20px) scale(1.3); opacity: 0.3; }
}

.cl-profile-hero-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.cl-profile-hero-glow {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 50% 80%, rgba(37,99,235,0.08) 0%, transparent 60%);
    pointer-events: none;
}

.cl-profile-hero-wave {
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 80px;
    z-index: 2;
}

.cl-profile-hero-wave svg {
    display: block;
    width: 100%;
    height: 100%;
    filter: drop-shadow(0 -4px 12px rgba(0,0,0,0.05));
}

/* ===== CONTAINER ===== */
.cl-profile-container {
    max-width: 820px;
    margin: -90px auto 2rem;
    padding: 0 1rem;
    position: relative;
    z-index: 3;
}

/* ===== TOAST ===== */
.cl-profile-toast {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    background: var(--cl-profile-surface);
    border-radius: var(--cl-profile-radius-sm);
    box-shadow: var(--cl-profile-shadow-lg);
    border: 1px solid rgba(16,185,129,0.2);
    margin-bottom: 1.25rem;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--cl-profile-text);
    animation: toastSlideIn 0.5s cubic-bezier(.16,1,.3,1) backwards;
    position: relative;
    overflow: hidden;
}

.cl-profile-toast::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--cl-profile-success), #059669);
    border-radius: 0 4px 4px 0;
}

.cl-profile-toast-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--cl-profile-success-subtle);
    color: var(--cl-profile-success);
    font-size: 1rem;
    flex-shrink: 0;
}

.cl-profile-toast span { flex: 1; }

.cl-profile-toast button {
    background: none;
    border: none;
    font-size: 1.3rem;
    color: var(--cl-profile-text-muted);
    cursor: pointer;
    padding: 0 4px;
    border-radius: 6px;
    transition: all 0.2s ease;
    line-height: 1;
}

.cl-profile-toast button:hover {
    background: var(--cl-profile-primary-subtle);
    color: var(--cl-profile-primary);
}

@keyframes toastSlideIn {
    from { opacity: 0; transform: translateY(-20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* ===== PROFILE HEADER ===== */
.cl-profile-header {
    text-align: center;
    padding: 0.5rem 1.5rem 0;
    position: relative;
}

.cl-profile-avatar-wrap {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 1.25rem;
}

.cl-profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--cl-profile-surface);
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    position: relative;
    z-index: 2;
    transition: transform var(--cl-profile-spring);
}

.cl-profile-avatar:hover {
    transform: scale(1.03);
}

.cl-profile-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, var(--cl-profile-primary), var(--cl-profile-purple));
}

.cl-profile-avatar-ring {
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    border: 2.5px solid rgba(37,99,235,0.15);
    animation: avatarRingPulse 4s ease-in-out infinite;
    z-index: 1;
}

.cl-profile-avatar-ring-2 {
    inset: -15px;
    border-width: 1.5px;
    border-color: rgba(139,92,246,0.1);
    animation-delay: 1.33s;
    z-index: 1;
}

.cl-profile-avatar-ring-3 {
    inset: -22px;
    border-width: 1px;
    border-color: rgba(16,185,129,0.08);
    animation-delay: 2.66s;
    z-index: 1;
}

@keyframes avatarRingPulse {
    0%,100%{ transform: scale(1); opacity: 0.5; }
    50%{ transform: scale(1.06); opacity: 0.15; }
}

.cl-profile-avatar-badge {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--cl-profile-primary), var(--cl-profile-primary-dark));
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    border: 3px solid var(--cl-profile-surface);
    z-index: 3;
    cursor: default;
    box-shadow: 0 2px 12px rgba(37,99,235,0.3);
    transition: all var(--cl-profile-spring);
}

.cl-profile-avatar-badge:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 20px rgba(37,99,235,0.4);
}

.cl-profile-name {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--cl-profile-text);
    letter-spacing: -0.03em;
    margin: 0 0 4px;
    line-height: 1.2;
}

.cl-profile-email {
    font-size: 0.92rem;
    color: var(--cl-profile-text-secondary);
    margin: 0 0 0.75rem;
}

.cl-profile-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.cl-profile-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    color: var(--cl-profile-text-muted);
    background: var(--cl-profile-surface);
    padding: 4px 12px;
    border-radius: var(--cl-profile-radius-pill);
    border: 1px solid var(--cl-profile-border-light);
    transition: all var(--cl-profile-transition);
}

.cl-profile-meta-item:hover {
    border-color: var(--cl-profile-border);
    background: var(--cl-profile-surface-alt);
}

.cl-profile-meta-item i { font-size: 0.8rem; color: var(--cl-profile-primary); }
.cl-profile-meta-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--cl-profile-border); }

.cl-profile-bio {
    max-width: 480px;
    margin: 1rem auto 0;
    font-size: 0.88rem;
    color: var(--cl-profile-text-secondary);
    line-height: 1.6;
    font-style: italic;
    padding: 0.75rem 1.25rem;
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border-light);
    border-radius: var(--cl-profile-radius-sm);
}

.cl-profile-bio i {
    color: var(--cl-profile-primary);
    font-size: 0.9rem;
    margin-right: 4px;
    opacity: 0.6;
}

/* ===== SETTINGS GEAR BUTTON ===== */
.cl-profile-settings-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: var(--cl-profile-surface);
    color: var(--cl-profile-text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    cursor: pointer;
    box-shadow: var(--cl-profile-shadow);
    transition: all var(--cl-profile-spring);
    z-index: 10;
}
.cl-profile-settings-btn:hover {
    background: var(--cl-profile-primary);
    color: #fff;
    transform: rotate(60deg) scale(1.05);
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}

/* ===== STATS ===== */
.cl-profile-stats {
    display: flex;
    justify-content: center;
    gap: 0;
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    padding: 0.85rem;
    margin: 1.25rem auto;
    max-width: 520px;
    box-shadow: var(--cl-profile-shadow);
    position: relative;
    overflow: hidden;
}

.cl-profile-stats::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--cl-profile-primary), var(--cl-profile-purple), var(--cl-profile-primary-light));
    opacity: 0.6;
}

.cl-profile-stat {
    flex: 1;
    text-align: center;
    padding: 0.5rem 0.75rem;
    border-right: 1px solid var(--cl-profile-border);
    transition: all var(--cl-profile-transition);
    position: relative;
}

.cl-profile-stat:last-child { border-right: none; }

.cl-profile-stat:hover {
    transform: translateY(-3px);
}

.cl-profile-stat:hover .cl-profile-stat-value {
    color: var(--cl-profile-primary);
}

.cl-profile-stat-value {
    display: block;
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--cl-profile-text);
    line-height: 1.3;
    transition: color var(--cl-profile-transition);
    font-variant-numeric: tabular-nums;
}

.cl-profile-stat-label {
    display: block;
    font-size: 0.65rem;
    color: var(--cl-profile-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-top: 2px;
}

.cl-profile-stat-label i {
    font-size: 0.65rem;
    margin-right: 2px;
}

/* ===== ACTIONS ===== */
.cl-profile-actions {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
    max-width: 420px;
    margin: 0 auto 1.5rem;
}

.cl-profile-action-form {
    width: 100%;
}

.cl-profile-btn-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    width: 100%;
}

.cl-profile-btn-group .flex-grow-1 { flex: 1; }
.cl-profile-btn-group .flex-grow-1 button { width: 100%; }

.cl-profile-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 0.75rem 1.25rem;
    border: none;
    border-radius: var(--cl-profile-radius-xs);
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--cl-profile-transition);
    text-decoration: none;
    font-family: inherit;
    position: relative;
    overflow: hidden;
    -webkit-font-smoothing: antialiased;
}

.cl-profile-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.cl-profile-btn:hover::after {
    opacity: 1;
}

.cl-profile-btn-primary {
    background: linear-gradient(135deg, var(--cl-profile-primary), var(--cl-profile-primary-dark));
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.25);
}

.cl-profile-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.35);
    color: #fff;
}

.cl-profile-btn-primary:active {
    transform: translateY(0);
}

.cl-profile-btn-secondary {
    background: var(--cl-profile-surface);
    color: var(--cl-profile-primary);
    border: 2px solid var(--cl-profile-primary);
}

.cl-profile-btn-secondary:hover {
    background: rgba(37,99,235,0.04);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(37,99,235,0.12);
}

.cl-profile-status-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0.65rem 1rem;
    border-radius: var(--cl-profile-radius-xs);
    font-size: 0.82rem;
    font-weight: 600;
    border: 1.5px solid;
    flex: 1;
}

.cl-profile-status-pending {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    color: #b45309;
    border-color: #fde68a;
}

.cl-profile-status-friends {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #047857;
    border-color: #a7f3d0;
}

.cl-profile-status-rejected {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #b91c1c;
    border-color: #fecaca;
}

.cl-profile-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: var(--cl-profile-radius-xs);
    border: 1.5px solid var(--cl-profile-border);
    background: var(--cl-profile-surface);
    color: var(--cl-profile-text-muted);
    cursor: pointer;
    transition: all var(--cl-profile-spring);
    font-size: 0.95rem;
    flex-shrink: 0;
}

.cl-profile-icon-btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.cl-profile-icon-btn:active {
    transform: scale(0.95);
}

.cl-profile-icon-btn-danger:hover {
    background: #fef2f2;
    border-color: #fecaca;
    color: var(--cl-profile-danger);
    box-shadow: 0 4px 12px rgba(239,68,68,0.15);
}

.cl-profile-icon-btn-primary:hover {
    background: var(--cl-profile-primary-subtle);
    border-color: rgba(37,99,235,0.2);
    color: var(--cl-profile-primary);
    box-shadow: 0 4px 12px rgba(37,99,235,0.15);
}

/* ===== EDIT SECTION ===== */
.cl-profile-edit-section {
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    margin-bottom: 1.5rem;
    box-shadow: var(--cl-profile-shadow);
    overflow: hidden;
    transition: box-shadow var(--cl-profile-transition);
}

.cl-profile-edit-section.is-open {
    box-shadow: var(--cl-profile-shadow-md);
    border-color: rgba(37,99,235,0.15);
}

/* Toggle Button */
.cl-profile-edit-toggle {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 1.25rem 1.5rem;
    border: none;
    background: var(--cl-profile-surface);
    cursor: pointer;
    font-family: inherit;
    text-align: left;
    transition: background 0.25s ease;
    position: relative;
}

.cl-profile-edit-toggle:hover {
    background: var(--cl-profile-surface-alt);
}

.cl-profile-edit-toggle:active {
    transform: scale(0.998);
}

.cl-profile-edit-toggle-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--cl-profile-radius-xs);
    background: var(--cl-profile-primary-subtle);
    color: var(--cl-profile-primary);
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.cl-profile-edit-toggle:hover .cl-profile-edit-toggle-icon {
    background: rgba(37,99,235,0.12);
    transform: scale(1.05);
}

.cl-profile-edit-toggle-text {
    flex: 1;
    min-width: 0;
}

.cl-profile-edit-toggle-title {
    display: block;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--cl-profile-text);
    line-height: 1.3;
}

.cl-profile-edit-toggle-sub {
    display: block;
    font-size: 0.75rem;
    color: var(--cl-profile-text-muted);
    font-weight: 400;
    margin-top: 1px;
}

.cl-profile-edit-toggle-arrow {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: var(--cl-profile-text-muted);
    font-size: 0.85rem;
    flex-shrink: 0;
    transition: all 0.4s cubic-bezier(.4,0,.2,1);
    background: var(--cl-profile-bg);
}

.cl-profile-edit-toggle[aria-expanded="true"] .cl-profile-edit-toggle-arrow {
    transform: rotate(180deg);
    color: var(--cl-profile-primary);
    background: var(--cl-profile-primary-subtle);
}

/* Collapsible Container */
.cl-profile-edit-collapse {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows 0.4s cubic-bezier(.4,0,.2,1);
}

.cl-profile-edit-collapse.is-open {
    grid-template-rows: 1fr;
}

.cl-profile-edit-collapse-inner {
    overflow: hidden;
    min-height: 0;
}

.cl-profile-edit-divider {
    height: 1px;
    background: var(--cl-profile-border);
    margin: 0 1.5rem;
}

.cl-profile-edit-collapse.is-open .cl-profile-edit-grid {
    animation: editFadeIn 0.4s ease 0.1s backwards;
}

@keyframes editFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes sectionSlideUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.cl-profile-edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 1.25rem 1.5rem 0;
}

.cl-profile-edit-field label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--cl-profile-text-secondary);
    margin-bottom: 6px;
}

.cl-profile-edit-field label i { color: var(--cl-profile-primary); font-size: 0.8rem; }

.cl-profile-input-wrap {
    position: relative;
}

.cl-profile-input-wrap input {
    width: 100%;
    padding: 0.65rem 0.85rem;
    border: 1.5px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius-xs);
    background: var(--cl-profile-bg);
    color: var(--cl-profile-text);
    font-size: 0.88rem;
    transition: all 0.25s ease;
    outline: none;
    font-family: inherit;
    box-sizing: border-box;
    position: relative;
    z-index: 1;
}

.cl-profile-input-focus-ring {
    position: absolute;
    inset: -3px;
    border-radius: calc(var(--cl-profile-radius-xs) + 3px);
    border: 2px solid var(--cl-profile-primary);
    opacity: 0;
    transition: opacity 0.25s ease;
    pointer-events: none;
}

.cl-profile-input-wrap input:focus {
    border-color: var(--cl-profile-primary);
    background: var(--cl-profile-surface);
}

.cl-profile-input-wrap input:focus ~ .cl-profile-input-focus-ring {
    opacity: 0.3;
}

.cl-profile-input-wrap input.is-invalid {
    border-color: var(--cl-profile-danger);
    background: #fef2f2;
}

.cl-profile-field-error {
    display: flex;
    align-items: center;
    gap: 4px;
    color: var(--cl-profile-danger);
    font-size: 0.72rem;
    font-weight: 500;
    margin-top: 4px;
}

.cl-profile-field-error i { font-size: 0.7rem; }

/* Upload */
.cl-profile-upload-wrap {
    position: relative;
}

.cl-profile-upload-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.cl-profile-upload-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.85rem 1rem;
    border: 1.5px dashed var(--cl-profile-border);
    border-radius: var(--cl-profile-radius-xs);
    background: var(--cl-profile-bg);
    color: var(--cl-profile-text-muted);
    transition: all 0.25s ease;
    cursor: pointer;
}

.cl-profile-upload-label:hover {
    border-color: var(--cl-profile-primary);
    background: var(--cl-profile-primary-subtle);
}

.cl-profile-upload-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--cl-profile-primary-subtle);
    color: var(--cl-profile-primary);
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.cl-profile-upload-label:hover .cl-profile-upload-icon {
    transform: scale(1.05);
    background: rgba(37,99,235,0.12);
}

.cl-profile-upload-title {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--cl-profile-text);
}

.cl-profile-upload-hint {
    display: block;
    font-size: 0.68rem;
    color: var(--cl-profile-text-muted);
    margin-top: 2px;
}

/* Image Preview */
.cl-profile-upload-preview {
    display: none;
    margin-top: 0.75rem;
    position: relative;
    border-radius: var(--cl-profile-radius-sm);
    overflow: hidden;
    border: 2px solid var(--cl-profile-border);
    background: var(--cl-profile-bg);
    animation: previewAppear 0.3s cubic-bezier(.16,1,.3,1);
}

.cl-profile-upload-preview.is-visible {
    display: block;
}

.cl-profile-upload-preview img {
    width: 100%;
    max-height: 200px;
    object-fit: contain;
    display: block;
    background: var(--cl-profile-bg);
}

.cl-profile-upload-preview-remove {
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

.cl-profile-upload-preview-remove:hover {
    background: rgba(239,68,68,0.85);
    transform: scale(1.1);
}

.cl-profile-upload-preview-remove:active {
    transform: scale(0.95);
}

@keyframes previewAppear {
    from { opacity: 0; transform: translateY(8px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* Checkbox */
.cl-profile-checkbox {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.82rem;
    color: var(--cl-profile-danger);
    font-weight: 500;
    cursor: pointer;
    margin-bottom: 1rem;
    padding: 8px 14px;
    border-radius: var(--cl-profile-radius-xs);
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.cl-profile-checkbox:hover {
    background: var(--cl-profile-danger-subtle);
    border-color: rgba(239,68,68,0.15);
}

.cl-profile-checkbox input {
    display: none;
}

.cl-profile-checkbox-mark {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid var(--cl-profile-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    transition: all 0.2s ease;
    color: transparent;
    flex-shrink: 0;
}

.cl-profile-checkbox input:checked + .cl-profile-checkbox-mark {
    background: var(--cl-profile-danger);
    border-color: var(--cl-profile-danger);
    color: #fff;
}

/* Edit footer */
.cl-profile-edit-footer {
    display: flex;
    justify-content: flex-end;
    padding: 0 1.5rem 1.25rem;
}

.cl-profile-edit-footer .cl-profile-btn {
    max-width: 220px;
}

.cl-profile-edit-collapse .cl-profile-checkbox {
    margin-left: 1.5rem;
    margin-right: 1.5rem;
}

/* ===== POSTS SECTION ===== */
.cl-profile-posts {
    margin-top: 0.25rem;
    animation: sectionSlideUp 0.5s ease-out 0.1s backwards;
}

.cl-profile-posts-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.25rem 0;
}

.cl-profile-posts-header-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--cl-profile-radius-xs);
    background: rgba(37,99,235,0.08);
    color: var(--cl-profile-primary);
    font-size: 1.05rem;
    flex-shrink: 0;
}

.cl-profile-posts-header-title {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: var(--cl-profile-text);
    line-height: 1.3;
}

.cl-profile-posts-header-sub {
    display: block;
    font-size: 0.72rem;
    color: var(--cl-profile-text-muted);
}

.cl-profile-posts-count {
    margin-left: auto;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--cl-profile-text-muted);
    background: var(--cl-profile-bg);
    padding: 4px 12px;
    border-radius: var(--cl-profile-radius-pill);
    border: 1px solid var(--cl-profile-border);
}

.cl-profile-posts-divider {
    height: 1px;
    background: var(--cl-profile-border);
    margin: 0.75rem 0 1rem;
}

.cl-profile-posts-list {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}

.cl-profile-posts-list > .connectly-post-card {
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    padding: 1.25rem;
    box-shadow: var(--cl-profile-shadow);
    transition: all var(--cl-profile-transition);
}

.cl-profile-posts-list > .connectly-post-card:hover {
    box-shadow: var(--cl-profile-shadow-md);
    border-color: rgba(37,99,235,0.15);
    transform: translateY(-2px);
}

/* ===== EMPTY STATE ===== */
.cl-profile-empty {
    text-align: center;
    padding: 3.5rem 1.5rem;
    background: var(--cl-profile-surface);
    border: 2px dashed var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    position: relative;
    overflow: hidden;
}

.cl-profile-empty-graphic {
    position: relative;
    width: 72px;
    height: 72px;
    margin: 0 auto 1rem;
}

.cl-profile-empty-icon-bg {
    width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(139,92,246,0.08));
    border-radius: 50%;
    font-size: 1.7rem;
    color: var(--cl-profile-text-muted);
}

.cl-profile-empty-dot-1,
.cl-profile-empty-dot-2 {
    position: absolute;
    border-radius: 50%;
    animation: emptyDotFloat 3s ease-in-out infinite;
}

.cl-profile-empty-dot-1 {
    width: 10px;
    height: 10px;
    background: rgba(37,99,235,0.1);
    top: -4px;
    right: -4px;
}

.cl-profile-empty-dot-2 {
    width: 6px;
    height: 6px;
    background: rgba(139,92,246,0.1);
    bottom: 4px;
    left: -8px;
    animation-delay: 1.5s;
}

@keyframes emptyDotFloat {
    0%,100%{ transform: translateY(0); }
    50%{ transform: translateY(-6px); }
}

.cl-profile-empty h5 {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--cl-profile-text);
    margin: 0 0 6px;
}

.cl-profile-empty p {
    font-size: 0.88rem;
    color: var(--cl-profile-text-muted);
    margin: 0;
    max-width: 300px;
    margin: 0 auto;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .cl-profile-hero { height: 220px; }
    .cl-profile-container { margin-top: -70px; }
    .cl-profile-avatar-wrap { width: 120px; height: 120px; }
    .cl-profile-avatar { width: 120px; height: 120px; }
    .cl-profile-avatar-fallback { font-size: 2.8rem; }
    .cl-profile-name { font-size: 1.45rem; }
    .cl-profile-stats { max-width: 100%; border-radius: var(--cl-profile-radius-sm); }
    .cl-profile-edit-grid { grid-template-columns: 1fr; }
    .cl-profile-actions { max-width: 100%; }
    .cl-profile-bio { font-size: 0.82rem; padding: 0.65rem 1rem; }
    .cl-profile-avatar-ring-3 { display: none; }
}

@media (max-width: 480px) {
    .cl-profile-hero { height: 180px; }
    .cl-profile-container { margin-top: -55px; padding: 0 0.75rem; }
    .cl-profile-avatar-wrap { width: 100px; height: 100px; }
    .cl-profile-avatar { width: 100px; height: 100px; }
    .cl-profile-avatar-fallback { font-size: 2.2rem; }
    .cl-profile-avatar-ring-2 { display: none; }
    .cl-profile-name { font-size: 1.25rem; }
    .cl-profile-email { font-size: 0.82rem; }
    .cl-profile-stat-value { font-size: 1.1rem; }
    .cl-profile-meta-item { font-size: 0.72rem; padding: 3px 10px; }
    .cl-profile-meta-dot { display: none; }
    .cl-profile-posts-list > .connectly-post-card { padding: 1rem; border-radius: var(--cl-profile-radius-sm); }
    .cl-profile-hero-grid { background-size: 40px 40px; }
    .cl-profile-settings-btn { top: 0.75rem; right: 0.75rem; width: 34px; height: 34px; font-size: 1rem; }
}

/* ============================================================
   POST CARD STYLES (for profile page)
   ============================================================ */

.connectly-post-card {
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    padding: 1.25rem 1.35rem;
    position: relative;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    box-shadow: var(--cl-profile-shadow);
}

.connectly-post-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, rgba(37,99,235,0.08), transparent);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.connectly-post-card:hover {
    border-color: rgba(37,99,235,0.15);
    box-shadow: var(--cl-profile-shadow-md);
    transform: translateY(-2px);
}

.connectly-post-card:hover::before {
    opacity: 1;
}

.connectly-post-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    background: var(--cl-profile-surface);
}

.connectly-post-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
    color: #ffffff;
    background: linear-gradient(135deg, var(--cl-profile-primary), var(--cl-profile-purple));
    box-shadow: 0 2px 8px rgba(37,99,235,0.12);
}

.connectly-post-user-name {
    font-size: 0.9rem;
}

.connectly-post-user-name a {
    color: var(--cl-profile-text);
    font-weight: 700;
    transition: color 0.2s ease;
}

.connectly-post-user-name a:hover {
    color: var(--cl-profile-primary);
}

.connectly-post-time {
    font-size: 0.75rem;
    color: var(--cl-profile-text-muted);
    font-weight: 400;
}

.connectly-post-time-dot {
    color: var(--cl-profile-border);
    font-size: 0.6rem;
}

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

.connectly-post-actions-dropdown {
    position: relative;
    flex-shrink: 0;
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
    color: var(--cl-profile-text-muted);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    font-size: 1rem;
}

.connectly-post-actions-trigger:hover {
    background: var(--cl-profile-bg);
    color: var(--cl-profile-text);
}

.connectly-post-actions-trigger:active {
    transform: scale(0.92);
}

.connectly-post-actions-trigger[aria-expanded="true"] {
    background: rgba(37,99,235,0.08);
    color: var(--cl-profile-primary);
}

.connectly-post-dropdown {
    border-radius: 14px !important;
    border: 1px solid var(--cl-profile-border) !important;
    padding: 0.35rem !important;
    box-shadow: var(--cl-profile-shadow-lg) !important;
    min-width: 160px;
    animation: connectlyDropdownSlide 0.15s ease-out;
    transform-origin: top right;
    background: var(--cl-profile-surface) !important;
}

@keyframes connectlyDropdownSlide {
    from { opacity: 0; transform: scale(0.92) translateY(-4px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.connectly-dropdown-item {
    border-radius: 10px !important;
    padding: 0.5rem 0.9rem !important;
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--cl-profile-text) !important;
    transition: all 0.15s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 2px;
}

.connectly-dropdown-item:hover {
    background: rgba(37,99,235,0.06) !important;
    color: var(--cl-profile-primary) !important;
}

.connectly-dropdown-item i {
    font-size: 0.9rem;
}

.connectly-dropdown-danger {
    color: var(--cl-profile-danger) !important;
}

.connectly-dropdown-danger:hover {
    background: var(--cl-profile-danger-subtle) !important;
    color: var(--cl-profile-danger) !important;
}

.connectly-post-dropdown .dropdown-divider {
    margin: 0.2rem 0 !important;
    border-top-color: var(--cl-profile-border) !important;
}

.connectly-post-text {
    color: var(--cl-profile-text-secondary);
    line-height: 1.7;
    white-space: pre-line;
    font-size: 0.92rem;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

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
    background: var(--cl-profile-bg);
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
    animation: imageShimmer 0.8s ease;
}

@keyframes imageShimmer {
    from { transform: translateX(-100%); }
    to { transform: translateX(100%); }
}

.connectly-post-image-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    backdrop-filter: blur(4px);
}

.connectly-post-actions-bar {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.1rem;
}

.connectly-react-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 1rem;
    border-radius: 999px;
    border: 1.5px solid var(--cl-profile-border);
    background: var(--cl-profile-surface);
    color: var(--cl-profile-text-muted);
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
    font-family: inherit;
}

.connectly-react-btn:hover {
    border-color: var(--cl-profile-primary);
    color: var(--cl-profile-primary);
    background: var(--cl-profile-primary-subtle);
    transform: translateY(-1px);
}

.connectly-react-btn.is-reacted {
    background: linear-gradient(135deg, var(--cl-profile-primary), var(--cl-profile-primary-dark));
    border-color: var(--cl-profile-primary);
    color: #fff;
    box-shadow: 0 3px 12px rgba(37,99,235,0.25);
}

.connectly-react-btn.is-reacted:hover {
    box-shadow: 0 5px 18px rgba(37,99,235,0.35);
    transform: translateY(-1px);
}

.connectly-react-btn:active {
    transform: scale(0.95);
}

.connectly-react-emoji {
    font-size: 0.95rem;
    line-height: 1;
}

.connectly-react-count {
    font-weight: 600;
    font-size: 0.78rem;
}

.connectly-react-float {
    position: absolute;
    left: 0;
    bottom: calc(100% + 8px);
    display: flex;
    gap: 0.1rem;
    padding: 0.4rem 0.5rem;
    background: var(--cl-profile-surface);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--cl-profile-border);
    border-radius: 999px;
    box-shadow: var(--cl-profile-shadow-lg);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(10px) scale(0.92);
    transition: all 0.2s cubic-bezier(.16,1,.3,1);
    z-index: 25;
}

.connectly-react-float::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: -14px;
    height: 14px;
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
    width: 36px;
    height: 36px;
    font-size: 1.3rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease, background 0.15s ease;
    cursor: pointer;
}

.connectly-react-emojibtn:hover {
    transform: scale(1.35);
    background: rgba(37,99,235,0.06);
}

.connectly-react-emojibtn:active {
    transform: scale(1.5);
}

.connectly-react-emojibtn.active {
    background: rgba(37,99,235,0.1);
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(37,99,235,0.12);
}

.connectly-comment-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 1rem;
    border-radius: 999px;
    border: 1.5px solid var(--cl-profile-border);
    background: var(--cl-profile-surface);
    color: var(--cl-profile-text-muted);
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}

.connectly-comment-link:hover {
    border-color: var(--cl-profile-primary);
    color: var(--cl-profile-primary);
    background: var(--cl-profile-primary-subtle);
    transform: translateY(-1px);
}

.connectly-comment-link:active {
    transform: scale(0.95);
}

.connectly-comment-link i {
    font-size: 0.9rem;
}

.connectly-comment-count {
    font-weight: 600;
    font-size: 0.78rem;
}

.connectly-reaction-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.6rem;
    padding-top: 0.6rem;
    border-top: 1px solid var(--cl-profile-border-light);
}

.connectly-reaction-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: var(--cl-profile-bg);
    border: 1px solid var(--cl-profile-border);
    color: var(--cl-profile-text-muted);
    font-weight: 500;
    font-size: 0.72rem;
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    transition: all 0.2s ease;
    cursor: default;
}

.connectly-reaction-badge:hover {
    background: var(--cl-profile-surface-alt);
    border-color: var(--cl-profile-text-muted);
}

.connectly-reaction-badge-emoji {
    line-height: 1;
}

.connectly-reaction-badge-count {
    font-weight: 600;
}

@media (max-width: 576px) {
    .connectly-post-card {
        padding: 1rem;
        border-radius: 18px;
    }
    .connectly-post-avatar {
        width: 40px;
        height: 40px;
    }
    .connectly-post-text {
        font-size: 0.88rem;
    }
    .connectly-react-btn,
    .connectly-comment-link {
        font-size: 0.75rem;
        padding: 0.35rem 0.85rem;
    }
    .connectly-react-emoji {
        font-size: 0.85rem;
    }
}

@media (max-width: 400px) {
    .connectly-post-card {
        padding: 0.85rem;
        border-radius: 16px;
    }
    .connectly-post-avatar {
        width: 36px;
        height: 36px;
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ===== PARTICLE GENERATION =====
    const container = document.getElementById('heroParticles');
    if (container) {
        for (let i = 0; i < 50; i++) {
            const dot = document.createElement('div');
            const size = 1.5 + Math.random() * 4;
            const alpha = 0.05 + Math.random() * 0.25;
            const duration = 10 + Math.random() * 18;
            const delay = Math.random() * 8;
            dot.style.cssText = `
                position:absolute;
                width:${size}px;height:${size}px;
                background:rgba(255,255,255,${alpha});
                border-radius:50%;
                left:${Math.random() * 100}%;
                top:${Math.random() * 100}%;
                animation:heroParticleFloat ${duration}s linear infinite;
                animation-delay:${delay}s;
                pointer-events:none;
            `;
            container.appendChild(dot);
        }
    }

    // ===== STAT COUNTER ANIMATION =====
    const animatedStats = document.querySelectorAll('.cl-profile-stat-animated');
    const observerOptions = { threshold: 0.5 };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.textContent.trim(), 10) || 0;
                animateCounter(el, target);
                observer.unobserve(el);
            }
        });
    }, observerOptions);

    animatedStats.forEach(stat => observer.observe(stat));

    function animateCounter(element, target) {
        const duration = 1200;
        const steps = 30;
        const stepTime = duration / steps;
        const increment = target / steps;
        let current = 0;
        let step = 0;

        const timer = setInterval(() => {
            step++;
            current = Math.min(Math.round(increment * step), target);
            element.textContent = current;
            if (step >= steps) {
                element.textContent = target;
                clearInterval(timer);
            }
        }, stepTime);
    }

    // ===== FILE INPUT LABEL UPDATE =====
    // ===== FILE INPUT LABEL + PREVIEW UPDATE =====
    document.addEventListener('change', function (e) {
        const input = e.target.closest('.cl-profile-upload-input');
        if (!input) return;

        const wrap = input.closest('.cl-profile-upload-wrap');
        const titleEl = wrap?.querySelector('.cl-profile-upload-title');
        const hintEl = wrap?.querySelector('.cl-profile-upload-hint');
        const preview = wrap?.querySelector('.cl-profile-upload-preview');
        const previewImg = wrap?.querySelector('.cl-profile-upload-preview img');

        if (input.files.length > 0) {
            const file = input.files[0];
            if (titleEl) titleEl.textContent = file.name;
            if (hintEl) hintEl.textContent = `${(file.size / 1024 / 1024).toFixed(1)} MB`;

            // Show image preview
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

    // ===== AVATAR PREVIEW REMOVE =====
    document.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('#avatarPreviewRemove');
        if (!removeBtn) return;

        const wrap = removeBtn.closest('.cl-profile-upload-wrap');
        const input = wrap?.querySelector('.cl-profile-upload-input');
        const preview = wrap?.querySelector('.cl-profile-upload-preview');
        const previewImg = wrap?.querySelector('.cl-profile-upload-preview img');
        const titleEl = wrap?.querySelector('.cl-profile-upload-title');
        const hintEl = wrap?.querySelector('.cl-profile-upload-hint');

        if (input) input.value = '';
        if (preview) preview.classList.remove('is-visible');
        if (previewImg) previewImg.src = '';
        if (titleEl) titleEl.textContent = 'Choose an image';
        if (hintEl) hintEl.textContent = 'JPEG, PNG, GIF, WebP (max 5MB)';
    });

    // ===== SWEET ALERT CONFIRMATIONS =====
    function handleSweetAlert(form, config) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const userName = form.dataset.userName || 'this user';

            Swal.fire({
                ...config,
                preConfirm: async () => {
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                            body: new FormData(form),
                        });
                        const data = await response.json();
                        if (!response.ok || !data.success) throw new Error(data.message || 'Action failed.');
                        return data;
                    } catch (error) {
                        Swal.showValidationMessage(error.message);
                        throw error;
                    }
                }
            }).then((result) => {
                if (!result.isConfirmed) return;
                const container = form.closest('.cl-profile-btn-group') || form.closest('.cl-profile-actions');
                const userId = form.dataset.userId;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const action = config._action || '';

                const baseUrl = window.location.origin;

                if (action === 'unfriend') {
                    container.innerHTML = `
                        <form action="${baseUrl}/friend-request/${userId}/send" method="POST" style="width:100%">
                            <input type="hidden" name="_token" value="${csrf}">
                            <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-person-plus-fill"></i> <span>Add Friend</span></button>
                        </form>`;
                    const countEl = document.querySelector('.cl-profile-friend-count');
                    if (countEl) {
                        const current = parseInt(countEl.textContent, 10) || 0;
                        countEl.textContent = Math.max(0, current - 1);
                    }
                    chatboxToast('success', `Unfriended ${userName}`);
                } else if (action === 'cancel') {
                    container.innerHTML = `
                        <form action="${baseUrl}/friend-request/${userId}/send" method="POST" style="width:100%">
                            <input type="hidden" name="_token" value="${csrf}">
                            <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-person-plus-fill"></i> <span>Add Friend</span></button>
                        </form>`;
                    chatboxToast('success', `Request to ${userName} cancelled`);
                } else if (action === 'accept') {
                    container.innerHTML = `
                        <div class="cl-profile-btn-group">
                            <span class="cl-profile-status-badge cl-profile-status-friends"><i class="bi bi-people-fill"></i> Friends</span>
                            <form action="${baseUrl}/friend-request/${userId}/unfriend" method="POST" class="cl-profile-unfriend-form" data-user-name="${userName}" data-user-id="${userId}">
                                <input type="hidden" name="_token" value="${csrf}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-danger" title="Unfriend"><i class="bi bi-person-dash-fill"></i></button>
                            </form>
                        </div>`;
                    const countEl = document.querySelector('.cl-profile-friend-count');
                    if (countEl) {
                        const current = parseInt(countEl.textContent, 10) || 0;
                        countEl.textContent = current + 1;
                    }
                    chatboxToast('success', `Accepted ${userName}'s request`);
                } else if (action === 'reject') {
                    container.innerHTML = `
                        <div class="cl-profile-btn-group">
                            <span class="cl-profile-status-badge cl-profile-status-rejected"><i class="bi bi-x-circle"></i> Request Rejected</span>
                            <form action="${baseUrl}/friend-request/send" method="POST" style="display:inline">
                                <input type="hidden" name="_token" value="${csrf}">
                                <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-primary" title="Send Again"><i class="bi bi-arrow-clockwise"></i></button>
                            </form>
                        </div>`;
                    chatboxToast('success', `Rejected ${userName}'s request`);
                }
            });
        });
    }

    // Attach handlers for SweetAlert forms
    document.querySelectorAll('.cl-profile-unfriend-form').forEach(f => handleSweetAlert(f, {
        title: 'Are you sure?',
        text: `You will no longer be friends with ${f.dataset.userName}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="bi bi-person-dash-fill me-1"></i> Yes, Unfriend',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true,
        customClass: { popup: 'connectly-toast-popup', confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1', cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border' },
        buttonsStyling: false,
        showLoaderOnConfirm: true,
        _action: 'unfriend',
    }));

    document.querySelectorAll('.cl-profile-cancel-form').forEach(f => handleSweetAlert(f, {
        title: 'Cancel Request?',
        text: `Cancel your friend request to ${f.dataset.userName}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Yes, Cancel',
        cancelButtonText: 'Keep Request',
        reverseButtons: true,
        focusCancel: true,
        customClass: { popup: 'connectly-toast-popup', confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1', cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border' },
        buttonsStyling: false,
        showLoaderOnConfirm: true,
        _action: 'cancel',
    }));

    document.querySelectorAll('.cl-profile-accept-form').forEach(f => handleSweetAlert(f, {
        title: 'Accept Request?',
        text: `You will become friends with ${f.dataset.userName}.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Yes, Accept',
        cancelButtonText: 'Not Now',
        reverseButtons: true,
        focusCancel: true,
        customClass: { popup: 'connectly-toast-popup', confirmButton: 'btn btn-success px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1', cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border' },
        buttonsStyling: false,
        showLoaderOnConfirm: true,
        _action: 'accept',
    }));

    document.querySelectorAll('.cl-profile-reject-form').forEach(f => handleSweetAlert(f, {
        title: 'Reject Request?',
        text: `Reject the friend request from ${f.dataset.userName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Yes, Reject',
        cancelButtonText: 'Keep Request',
        reverseButtons: true,
        focusCancel: true,
        customClass: { popup: 'connectly-toast-popup', confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1', cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border' },
        buttonsStyling: false,
        showLoaderOnConfirm: true,
        _action: 'reject',
    }));

    // ===== KEYFRAME for particles =====
    if (!document.getElementById('clProfileKeyframes')) {
        const s = document.createElement('style');
        s.id = 'clProfileKeyframes';
        s.textContent = `
            @keyframes heroParticleFloat {
                0% { transform: translateY(0) scale(0); opacity: 0; }
                10% { opacity: 1; }
                90% { opacity: 1; }
                100% { transform: translateY(-100vh) scale(1); opacity: 0; }
            }
        `;
        document.head.appendChild(s);
    }
});
</script>

<style>
.connectly-toast-popup {
    border-radius: var(--cl-profile-radius-sm) !important;
    box-shadow: var(--cl-profile-shadow-lg) !important;
    font-family: var(--cl-profile-font) !important;
    background: var(--cl-profile-surface) !important;
    border: 1px solid var(--cl-profile-border) !important;
    color: var(--cl-profile-text) !important;
}
.connectly-toast-popup .swal2-title {
    font-size: 0.88rem !important;
    font-weight: 600 !important;
    color: var(--cl-profile-text) !important;
}
</style>

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

// ===== Live Reaction AJAX handler =====
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
</script>

@endsection
