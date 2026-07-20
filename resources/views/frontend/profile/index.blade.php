@extends('frontend.app')

@section('content')

<div class="cl-profile">

    {{-- ===== HERO BANNER ===== --}}
    <div class="cl-profile-hero">
        <div class="cl-profile-hero-bg">
            <div class="cl-profile-hero-orb cl-profile-hero-orb-1"></div>
            <div class="cl-profile-hero-orb cl-profile-hero-orb-2"></div>
            <div class="cl-profile-hero-orb cl-profile-hero-orb-3"></div>
        </div>
        <div class="cl-profile-hero-particles" id="heroParticles"></div>
        <div class="cl-profile-hero-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path d="M0,60 C360,120 720,0 1440,60 L1440,120 L0,120 Z" fill="var(--cl-profile-bg)"/></svg>
        </div>
    </div>

    <div class="cl-profile-container">

        @if (session('success'))
            <div class="cl-profile-toast" id="successToast">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        {{-- ===== PROFILE HEADER ===== --}}
        <div class="cl-profile-header">
            <div class="cl-profile-avatar-wrap">
                @if ($user->avatar_path)
                    <img src="{{ route('media.show', ['path' => $user->avatar_path]) }}" alt="{{ $user->name }}" class="cl-profile-avatar">
                @else
                    <div class="cl-profile-avatar cl-profile-avatar-fallback">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
                <div class="cl-profile-avatar-ring"></div>
                <div class="cl-profile-avatar-ring-2"></div>
            </div>

            <h1 class="cl-profile-name">{{ $user->name }}</h1>
            <p class="cl-profile-email">{{ $user->email }}</p>

            <div class="cl-profile-meta">
                <span class="cl-profile-meta-item">
                    <i class="bi bi-calendar3"></i>
                    Joined {{ $user->created_at->format('M Y') }}
                </span>
                <span class="cl-profile-meta-divider"></span>
                <span class="cl-profile-meta-item">
                    <i class="bi bi-geo-alt"></i>
                    Connectly
                </span>
            </div>
        </div>

        {{-- ===== STATS ROW ===== --}}
        <div class="cl-profile-stats">
            <div class="cl-profile-stat">
                <span class="cl-profile-stat-value">{{ $posts->count() }}</span>
                <span class="cl-profile-stat-label">Posts</span>
            </div>
            <div class="cl-profile-stat">
                <span class="cl-profile-stat-value">{{ $posts->where('is_pinned', true)->count() }}</span>
                <span class="cl-profile-stat-label">Pinned</span>
            </div>
            <div class="cl-profile-stat">
                <span class="cl-profile-stat-value cl-profile-friend-count">{{ $friendsCount }}</span>
                <span class="cl-profile-stat-label">Friends</span>
            </div>
            <div class="cl-profile-stat">
                <span class="cl-profile-stat-value">{{ $posts->sum('reactions_count') }}</span>
                <span class="cl-profile-stat-label">Reactions</span>
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
                <form action="{{ route('friend-request.send', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="cl-profile-btn cl-profile-btn-primary">
                        <i class="bi bi-person-plus-fill"></i>
                        Add Friend
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
                <form action="{{ route('friend-request.send', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-person-plus-fill"></i> Add Friend</button>
                </form>
            @elseif ($friendStatus === 'rejected' && $frSentByThem)
                <div class="cl-profile-btn-group">
                    <span class="cl-profile-status-badge cl-profile-status-rejected"><i class="bi bi-x-circle"></i> Request Rejected</span>
                    <form action="{{ route('friend-request.send', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-primary" title="Send Again"><i class="bi bi-arrow-clockwise"></i></button>
                    </form>
                </div>
            @endif

            <a href="{{ route('message', $user->id) }}" class="cl-profile-btn cl-profile-btn-secondary">
                <i class="bi bi-chat-dots-fill"></i>
                Send Message
            </a>
        </div>
        @endunless

        {{-- ===== EDIT FORM (OWNER ONLY) ===== --}}
        @if($isOwner)
        <div class="cl-profile-edit-section">
            <div class="cl-profile-edit-header">
                <i class="bi bi-gear-fill"></i>
                <span>Profile Settings</span>
            </div>
            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="cl-profile-edit-grid">
                    <div class="cl-profile-edit-field">
                        <label><i class="bi bi-person"></i> Your Name</label>
                        <div class="cl-profile-input-wrap">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" maxlength="255" required placeholder="Enter your name" class="@error('name') is-invalid @enderror">
                            @error('name') <span class="cl-profile-field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="cl-profile-edit-field">
                        <label><i class="bi bi-image"></i> Profile Picture</label>
                        <div class="cl-profile-upload-wrap">
                            <input type="file" name="avatar" accept="image/*" id="avatarInput" class="cl-profile-upload-input">
                            <label for="avatarInput" class="cl-profile-upload-label">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <span>Choose an image</span>
                            </label>
                        </div>
                        <span class="cl-profile-field-hint">Max 5MB. JPEG, PNG, GIF, WebP.</span>
                        @error('avatar') <span class="cl-profile-field-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if ($user->avatar_path)
                <label class="cl-profile-checkbox">
                    <input type="checkbox" name="remove_avatar" value="1">
                    <i class="bi bi-trash"></i> Remove current picture
                </label>
                @endif

                <button type="submit" class="cl-profile-btn cl-profile-btn-primary cl-profile-btn-save">
                    <i class="bi bi-check2"></i> Update Profile
                </button>
            </form>
        </div>
        @endif

        {{-- ===== POSTS SECTION ===== --}}
        <div class="cl-profile-posts">
            <div class="cl-profile-posts-header">
                <i class="bi bi-journal-text"></i>
                <span>Posts</span>
                <span class="cl-profile-posts-count">{{ $posts->count() }}</span>
            </div>

            <div class="cl-profile-posts-list">
                @forelse ($posts as $post)
                    @include('frontend.partials.post', ['post' => $post, 'showPinButton' => $isOwner])
                @empty
                    <div class="cl-profile-empty">
                        <div class="cl-profile-empty-icon"><i class="bi bi-journal-text"></i></div>
                        <h5>No posts yet</h5>
                        <p>
                            @if($isOwner)
                                Share your first post with the community!
                            @else
                                {{ $user->name }} hasn't posted anything yet.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
:root {
    --cl-profile-bg: #f0f2f5;
    --cl-profile-surface: #ffffff;
    --cl-profile-border: #e4e6eb;
    --cl-profile-text: #050505;
    --cl-profile-text-secondary: #65676b;
    --cl-profile-text-muted: #8a8d91;
    --cl-profile-primary: #2563eb;
    --cl-profile-primary-dark: #1d4ed8;
    --cl-profile-primary-light: #60a5fa;
    --cl-profile-primary-subtle: rgba(37,99,235,0.08);
    --cl-profile-success: #10b981;
    --cl-profile-danger: #ef4444;
    --cl-profile-radius: 20px;
    --cl-profile-radius-sm: 14px;
    --cl-profile-radius-xs: 10px;
    --cl-profile-shadow: 0 2px 8px rgba(0,0,0,0.04);
    --cl-profile-shadow-md: 0 8px 24px rgba(0,0,0,0.06);
    --cl-profile-shadow-lg: 0 16px 48px rgba(0,0,0,0.08);
    --cl-profile-transition: 0.3s cubic-bezier(.4,0,.2,1);
}

.cl-profile {
    min-height: 100dvh;
    background: var(--cl-profile-bg);
    position: relative;
}

/* ===== HERO BANNER ===== */
.cl-profile-hero {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #1e40af 70%, #0f172a 100%);
}

.cl-profile-hero-bg {
    position: absolute;
    inset: 0;
    overflow: hidden;
}

.cl-profile-hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.4;
}

.cl-profile-hero-orb-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(37,99,235,0.3), transparent);
    top: -150px; right: -100px;
    animation: heroOrbFloat1 14s ease-in-out infinite;
}

.cl-profile-hero-orb-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(96,165,250,0.2), transparent);
    bottom: -120px; left: -80px;
    animation: heroOrbFloat2 12s ease-in-out infinite reverse;
}

.cl-profile-hero-orb-3 {
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(124,58,237,0.15), transparent);
    top: 50%; left: 60%;
    animation: heroOrbFloat3 16s ease-in-out infinite;
}

@keyframes heroOrbFloat1 {
    0%,100%{ transform: translate(0,0) scale(1); }
    50%{ transform: translate(40px,-40px) scale(1.1); }
}
@keyframes heroOrbFloat2 {
    0%,100%{ transform: translate(0,0) scale(1); }
    50%{ transform: translate(-30px,30px) scale(1.15); }
}
@keyframes heroOrbFloat3 {
    0%,100%{ transform: translate(0,0) scale(1); opacity: 0.3; }
    50%{ transform: translate(20px,-20px) scale(1.2); opacity: 0.5; }
}

.cl-profile-hero-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
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
}

/* ===== CONTAINER ===== */
.cl-profile-container {
    max-width: 820px;
    margin: -80px auto 2rem;
    padding: 0 1rem;
    position: relative;
    z-index: 3;
}

/* ===== TOAST ===== */
.cl-profile-toast {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    background: #fff;
    border-radius: var(--cl-profile-radius-sm);
    box-shadow: var(--cl-profile-shadow-lg);
    border-left: 4px solid var(--cl-profile-success);
    margin-bottom: 1.25rem;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--cl-profile-text);
    animation: toastSlideIn 0.4s cubic-bezier(.16,1,.3,1) backwards;
}

.cl-profile-toast i { color: var(--cl-profile-success); font-size: 1.2rem; }
.cl-profile-toast button {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 1.3rem;
    color: var(--cl-profile-text-muted);
    cursor: pointer;
    padding: 0 4px;
}

@keyframes toastSlideIn {
    from { opacity: 0; transform: translateY(-20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* ===== PROFILE HEADER ===== */
.cl-profile-header {
    text-align: center;
    padding: 1rem 1.5rem 0;
}

.cl-profile-avatar-wrap {
    position: relative;
    width: 140px;
    height: 140px;
    margin: 0 auto 1rem;
}

.cl-profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    position: relative;
    z-index: 2;
}

.cl-profile-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.2rem;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, var(--cl-profile-primary), var(--cl-profile-primary-dark));
}

.cl-profile-avatar-ring {
    position: absolute;
    inset: -6px;
    border-radius: 50%;
    border: 2px solid rgba(37,99,235,0.15);
    animation: avatarRingPulse 3s ease-in-out infinite;
    z-index: 1;
}

.cl-profile-avatar-ring-2 {
    inset: -12px;
    border-width: 1.5px;
    border-color: rgba(37,99,235,0.08);
    animation-delay: 1.5s;
}

@keyframes avatarRingPulse {
    0%,100%{ transform: scale(1); opacity: 0.6; }
    50%{ transform: scale(1.05); opacity: 0.2; }
}

.cl-profile-name {
    font-size: 1.65rem;
    font-weight: 800;
    color: var(--cl-profile-text);
    letter-spacing: -0.02em;
    margin: 0 0 4px;
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
    gap: 12px;
    flex-wrap: wrap;
}

.cl-profile-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    color: var(--cl-profile-text-muted);
}

.cl-profile-meta-item i { font-size: 0.85rem; }
.cl-profile-meta-divider { width: 4px; height: 4px; border-radius: 50%; background: var(--cl-profile-border); }

/* ===== STATS ===== */
.cl-profile-stats {
    display: flex;
    justify-content: center;
    gap: 0;
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    padding: 0.75rem;
    margin: 1.25rem auto;
    max-width: 480px;
    box-shadow: var(--cl-profile-shadow);
}

.cl-profile-stat {
    flex: 1;
    text-align: center;
    padding: 0.35rem 0.5rem;
    border-right: 1px solid var(--cl-profile-border);
    transition: transform var(--cl-profile-transition);
}

.cl-profile-stat:last-child { border-right: none; }
.cl-profile-stat:hover { transform: translateY(-2px); }
.cl-profile-stat:hover .cl-profile-stat-value { color: var(--cl-profile-primary); }

.cl-profile-stat-value {
    display: block;
    font-size: 1.2rem;
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
    letter-spacing: 0.5px;
}

/* ===== ACTIONS ===== */
.cl-profile-actions {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    max-width: 400px;
    margin: 0 auto 1.5rem;
}

.cl-profile-btn-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.cl-profile-btn-group .flex-grow-1 { flex: 1; }
.cl-profile-btn-group .flex-grow-1 button { width: 100%; }

.cl-profile-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 0.7rem 1.25rem;
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
}

.cl-profile-btn-primary {
    background: var(--cl-profile-primary);
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.25);
}

.cl-profile-btn-primary:hover {
    background: var(--cl-profile-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.35);
    color: #fff;
}

.cl-profile-btn-primary:active { transform: translateY(0); }

.cl-profile-btn-secondary {
    background: var(--cl-profile-surface);
    color: var(--cl-profile-primary);
    border: 1.5px solid var(--cl-profile-primary);
}

.cl-profile-btn-secondary:hover {
    background: var(--cl-profile-primary-subtle);
    transform: translateY(-2px);
}

.cl-profile-status-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0.6rem 1rem;
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
    width: 42px;
    height: 42px;
    border-radius: var(--cl-profile-radius-xs);
    border: 1.5px solid var(--cl-profile-border);
    background: var(--cl-profile-surface);
    color: var(--cl-profile-text-muted);
    cursor: pointer;
    transition: all 0.25s ease;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.cl-profile-icon-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
.cl-profile-icon-btn-danger:hover { background: #fef2f2; border-color: #fecaca; color: var(--cl-profile-danger); }
.cl-profile-icon-btn-primary:hover { background: var(--cl-profile-primary-subtle); border-color: rgba(37,99,235,0.2); color: var(--cl-profile-primary); }

/* ===== EDIT SECTION ===== */
.cl-profile-edit-section {
    background: var(--cl-profile-surface);
    border: 1px solid var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--cl-profile-shadow);
}

.cl-profile-edit-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--cl-profile-text);
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--cl-profile-border);
}

.cl-profile-edit-header i { color: var(--cl-profile-primary); }

.cl-profile-edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
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
}

.cl-profile-input-wrap input:focus {
    border-color: var(--cl-profile-primary);
    background: var(--cl-profile-surface);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
}

.cl-profile-input-wrap input.is-invalid {
    border-color: var(--cl-profile-danger);
    background: #fef2f2;
}

.cl-profile-field-error {
    display: block;
    color: var(--cl-profile-danger);
    font-size: 0.72rem;
    font-weight: 500;
    margin-top: 4px;
}

.cl-profile-field-hint {
    display: block;
    font-size: 0.68rem;
    color: var(--cl-profile-text-muted);
    margin-top: 4px;
}

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
    gap: 8px;
    padding: 0.65rem 0.85rem;
    border: 1.5px dashed var(--cl-profile-border);
    border-radius: var(--cl-profile-radius-xs);
    background: var(--cl-profile-bg);
    color: var(--cl-profile-text-muted);
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
}

.cl-profile-upload-label:hover {
    border-color: var(--cl-profile-primary);
    background: var(--cl-profile-primary-subtle);
    color: var(--cl-profile-primary);
}

.cl-profile-checkbox {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    color: var(--cl-profile-danger);
    font-weight: 500;
    cursor: pointer;
    margin-bottom: 1rem;
    padding: 6px 12px;
    border-radius: 8px;
    transition: background 0.2s ease;
}

.cl-profile-checkbox:hover { background: rgba(239,68,68,0.06); }
.cl-profile-checkbox input { accent-color: var(--cl-profile-danger); width: 16px; height: 16px; }

.cl-profile-btn-save {
    max-width: 220px;
}

/* ===== POSTS SECTION ===== */
.cl-profile-posts {
    margin-top: 0.5rem;
}

.cl-profile-posts-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    font-weight: 700;
    color: var(--cl-profile-text);
    margin-bottom: 1rem;
    padding: 0 0.25rem;
}

.cl-profile-posts-header i { color: var(--cl-profile-primary); }

.cl-profile-posts-count {
    margin-left: auto;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--cl-profile-text-muted);
    background: var(--cl-profile-border);
    padding: 2px 10px;
    border-radius: 999px;
}

.cl-profile-posts-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
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
    border-color: var(--cl-profile-primary);
}

/* ===== EMPTY STATE ===== */
.cl-profile-empty {
    text-align: center;
    padding: 3.5rem 1.5rem;
    background: var(--cl-profile-surface);
    border: 2px dashed var(--cl-profile-border);
    border-radius: var(--cl-profile-radius);
}

.cl-profile-empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--cl-profile-primary-subtle);
    border-radius: 50%;
    font-size: 1.5rem;
    color: var(--cl-profile-primary);
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
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .cl-profile-hero { height: 200px; }
    .cl-profile-container { margin-top: -60px; }
    .cl-profile-avatar-wrap { width: 110px; height: 110px; }
    .cl-profile-avatar { width: 110px; height: 110px; }
    .cl-profile-avatar-fallback { font-size: 2.6rem; }
    .cl-profile-name { font-size: 1.35rem; }
    .cl-profile-stats { max-width: 100%; }
    .cl-profile-edit-grid { grid-template-columns: 1fr; }
    .cl-profile-actions { max-width: 100%; }
}

@media (max-width: 480px) {
    .cl-profile-hero { height: 160px; }
    .cl-profile-container { margin-top: -50px; padding: 0 0.75rem; }
    .cl-profile-avatar-wrap { width: 90px; height: 90px; }
    .cl-profile-avatar { width: 90px; height: 90px; }
    .cl-profile-avatar-fallback { font-size: 2rem; }
    .cl-profile-name { font-size: 1.15rem; }
    .cl-profile-email { font-size: 0.82rem; }
    .cl-profile-stat-value { font-size: 1rem; }
    .cl-profile-posts-list > .connectly-post-card { padding: 1rem; border-radius: var(--cl-profile-radius-sm); }
    .cl-profile-edit-section { padding: 1.15rem; border-radius: var(--cl-profile-radius-sm); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Particle generation for hero
    const container = document.getElementById('heroParticles');
    if (container) {
        for (let i = 0; i < 30; i++) {
            const dot = document.createElement('div');
            const size = 2 + Math.random() * 4;
            dot.style.cssText = `
                position:absolute;
                width:${size}px;height:${size}px;
                background:rgba(255,255,255,${0.1 + Math.random() * 0.3});
                border-radius:50%;
                left:${Math.random() * 100}%;
                top:${Math.random() * 100}%;
                animation:heroParticleFloat ${8 + Math.random() * 12}s linear infinite;
                animation-delay:${Math.random() * 5}s;
                pointer-events:none;
            `;
            container.appendChild(dot);
        }
    }

    // File input label update
    document.addEventListener('change', function (e) {
        const input = e.target.closest('.cl-profile-upload-input');
        if (!input) return;
        const label = input.parentElement.querySelector('.cl-profile-upload-label span');
        if (label && input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else if (label) {
            label.textContent = 'Choose an image';
        }
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

                if (action === 'unfriend') {
                    container.innerHTML = `
                        <form action="${window.location.origin}/friend-request/${userId}/send" method="POST" style="width:100%">
                            <input type="hidden" name="_token" value="${csrf}">
                            <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-person-plus-fill"></i> Add Friend</button>
                        </form>`;
                    const countEl = document.querySelector('.cl-profile-friend-count');
                    if (countEl) countEl.textContent = Math.max(0, (parseInt(countEl.textContent, 10) || 0) - 1);
                    chatboxToast('success', `Unfriended ${userName}`);
                } else if (action === 'cancel') {
                    container.innerHTML = `
                        <form action="${window.location.origin}/friend-request/${userId}/send" method="POST" style="width:100%">
                            <input type="hidden" name="_token" value="${csrf}">
                            <button type="submit" class="cl-profile-btn cl-profile-btn-primary"><i class="bi bi-person-plus-fill"></i> Add Friend</button>
                        </form>`;
                    chatboxToast('success', `Request to ${userName} cancelled`);
                } else if (action === 'accept') {
                    container.innerHTML = `
                        <div class="cl-profile-btn-group">
                            <span class="cl-profile-status-badge cl-profile-status-friends"><i class="bi bi-people-fill"></i> Friends</span>
                            <form action="${window.location.origin}/friend-request/${userId}/unfriend" method="POST" class="cl-profile-unfriend-form" data-user-name="${userName}" data-user-id="${userId}">
                                <input type="hidden" name="_token" value="${csrf}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-danger" title="Unfriend"><i class="bi bi-person-dash-fill"></i></button>
                            </form>
                        </div>`;
                    const countEl = document.querySelector('.cl-profile-friend-count');
                    if (countEl) countEl.textContent = (parseInt(countEl.textContent, 10) || 0) + 1;
                    chatboxToast('success', `Accepted ${userName}'s request`);
                } else if (action === 'reject') {
                    container.innerHTML = `
                        <div class="cl-profile-btn-group">
                            <span class="cl-profile-status-badge cl-profile-status-rejected"><i class="bi bi-x-circle"></i> Request Rejected</span>
                            <form action="${window.location.origin}/friend-request/send" method="POST" style="display:inline">
                                <input type="hidden" name="_method" value="POST">
                                <button type="submit" class="cl-profile-icon-btn cl-profile-icon-btn-primary" title="Send Again"><i class="bi bi-arrow-clockwise"></i></button>
                            </form>
                        </div>`;
                    chatboxToast('success', `Rejected ${userName}'s request`);
                }
            });
        });
    }

    // Attach handlers
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
    font-family: inherit !important;
}
.connectly-toast-popup .swal2-title {
    font-size: 0.88rem !important;
    font-weight: 600 !important;
    color: var(--cl-profile-text) !important;
}
</style>

@endsection
