@extends('frontend.app')

@section('content')

<div class="chatbox-profile-page connectly-profile-page">
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show chatbox-profile-alert connectly-profile-alert" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Profile Card -->
            <div class="col-xl-4">
                <div class="chatbox-profile-card chatbox-profile-sticky connectly-profile-card connectly-profile-card-sticky">
                    <!-- Avatar Section -->
                    <div class="chatbox-profile-avatar-section connectly-profile-avatar-section">
                        @if ($user->avatar_path)
                            <img
                                src="{{ route('media.show', ['path' => $user->avatar_path]) }}"
                                alt="Profile picture"
                                class="chatbox-profile-avatar mb-3 connectly-profile-avatar"
                            >
                        @else
                            <div class="chatbox-profile-avatar chatbox-profile-avatar-fallback mb-3 connectly-profile-avatar connectly-profile-avatar-fallback">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <h4 class="mb-1 fw-bold chatbox-profile-name connectly-profile-name">{{ $user->name }}</h4>
                        <p class="text-muted small mb-2 connectly-profile-email">{{ $user->email }}</p>

                        <span class="chatbox-profile-badge connectly-profile-badge">
                            <i class="bi bi-calendar3 me-1"></i>
                            Joined {{ $user->created_at->format('M Y') }}
                        </span>

                        @unless($isOwner)
                            {{-- Friend Request Button --}}
                            @php
                                $frSentByMe = $friendRequest && (int) $friendRequest->sender_id === (int) auth()->id();
                                $frSentByThem = $friendRequest && (int) $friendRequest->sender_id === (int) $user->id;
                            @endphp

                            @if (!$friendRequest)
                                {{-- No request yet --}}
                                <form action="{{ route('friend-request.send', $user->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="chatbox-btn-primary chatbox-btn-full chatbox-profile-message-btn connectly-btn-primary">
                                        <i class="bi bi-person-plus-fill me-2"></i>
                                        Add Friend
                                    </button>
                                </form>
                            @elseif ($friendStatus === 'pending' && $frSentByMe)
                                {{-- Request sent by current user --}}
                                <div class="d-flex gap-2 w-100 mt-3">
                                    <span class="chatbox-friend-status-badge chatbox-friend-pending flex-grow-1 connectly-friend-status-badge">
                                        <i class="bi bi-hourglass-split me-1"></i> Friend Request Sent
                                    </span>
                                    <form action="{{ route('friend-request.cancel', $friendRequest->id) }}" method="POST" class="chatbox-cancel-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="chatbox-friend-action-btn chatbox-friend-cancel-btn" title="Cancel Request">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif ($friendStatus === 'pending' && $frSentByThem)
                                {{-- Request received from this user --}}
                                <div class="d-flex gap-2 w-100 mt-3">
                                    <form action="{{ route('friend-request.accept', $friendRequest->id) }}" method="POST" class="flex-grow-1 chatbox-profile-accept-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="chatbox-btn-primary chatbox-btn-full connectly-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.82rem;">
                                            <i class="bi bi-check-lg me-1"></i> Accept Request
                                        </button>
                                    </form>
                                    <form action="{{ route('friend-request.reject', $friendRequest->id) }}" method="POST" class="chatbox-reject-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="chatbox-friend-action-btn chatbox-friend-reject-btn" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif ($friendStatus === 'accepted')
                                {{-- Already friends --}}
                                <div class="d-flex gap-2 w-100 mt-2">
                                    <span class="chatbox-friend-status-badge chatbox-friend-accepted flex-grow-1">
                                        <i class="bi bi-people-fill me-1"></i> Friends
                                    </span>
                                    <form action="{{ route('friend-request.unfriend', $user->id) }}" method="POST" class="chatbox-unfriend-form" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="chatbox-friend-action-btn chatbox-friend-unfriend-btn" title="Unfriend">
                                            <i class="bi bi-person-dash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif ($friendStatus === 'rejected' && $frSentByMe)
                                {{-- Was rejected --}}
                                <form action="{{ route('friend-request.send', $user->id) }}" method="POST" class="w-100 mt-3">
                                    @csrf
                                    <button type="submit" class="chatbox-btn-primary chatbox-btn-full chatbox-profile-message-btn connectly-btn-primary">
                                        <i class="bi bi-person-plus-fill me-2"></i>
                                        Add Friend
                                    </button>
                                </form>
                            @elseif ($friendStatus === 'rejected' && $frSentByThem)
                                {{-- I rejected their request --}}
                                <div class="d-flex gap-2 w-100 mt-3">
                                    <span class="chatbox-friend-status-badge chatbox-friend-rejected flex-grow-1">
                                        <i class="bi bi-x-circle me-1"></i> Request Rejected
                                    </span>
                                    <form action="{{ route('friend-request.send', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="chatbox-friend-action-btn chatbox-friend-send-again-btn" title="Send Request Again">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif

                            {{-- Send Message button --}}
                            <a href="{{ route('message', $user->id) }}" class="chatbox-btn-primary chatbox-btn-full mt-2 connectly-btn-primary">
                                <i class="bi bi-chat-dots-fill me-2"></i>
                                Send Message
                            </a>
                        @endunless
                    </div>

                    <!-- Stats Row -->
                    <div class="chatbox-profile-stats-row connectly-profile-stats-row">
                        <div class="chatbox-profile-stat-item connectly-profile-stat-item">
                            <span class="chatbox-profile-stat-value connectly-profile-stat-value">{{ $posts->count() }}</span>
                            <span class="chatbox-profile-stat-label connectly-profile-stat-label">Posts</span>
                        </div>
                        <div class="chatbox-profile-stat-item connectly-profile-stat-item">
                            <span class="chatbox-profile-stat-value connectly-profile-stat-value">{{ $posts->where('is_pinned', true)->count() }}</span>
                            <span class="chatbox-profile-stat-label connectly-profile-stat-label">Pinned</span>
                        </div>
                        <div class="chatbox-profile-stat-item connectly-profile-stat-item">
                            <span class="chatbox-profile-stat-value chatbox-friend-count-stat">{{ $friendsCount }}</span>
                            <span class="chatbox-profile-stat-label connectly-profile-stat-label">Friends</span>
                        </div>
                        <div class="chatbox-profile-stat-item connectly-profile-stat-item">
                            <span class="chatbox-profile-stat-value connectly-profile-stat-value">{{ $posts->sum('reactions_count') }}</span>
                            <span class="chatbox-profile-stat-label connectly-profile-stat-label">Reactions</span>
                        </div>
                    </div>

                    <!-- Edit Form (only for profile owner) -->
                    @if($isOwner)
                    <hr class="chatbox-profile-divider connectly-profile-divider">

                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="chatbox-profile-form connectly-profile-form">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="chatbox-form-label connectly-form-label">
                                <i class="bi bi-person me-1"></i> Your Name
                            </label>
                            <div class="chatbox-input-group">
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="chatbox-form-control connectly-form-control @error('name') is-invalid @enderror"
                                    maxlength="255"
                                    required
                                    placeholder="Enter your name"
                                >
                                <i class="bi bi-pencil chatbox-input-icon"></i>
                            </div>
                            @error('name')
                                <div class="chatbox-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="chatbox-form-label connectly-form-label">
                                <i class="bi bi-image me-1"></i> Profile Picture
                            </label>
                            <div class="chatbox-file-input-wrapper connectly-file-input-wrapper">
                                <input
                                    type="file"
                                    name="avatar"
                                    accept="image/*"
                                    class="chatbox-file-input @error('avatar') is-invalid @enderror"
                                    id="avatarInput"
                                >
                                <label for="avatarInput" class="chatbox-file-label connectly-file-label">
                                    <i class="bi bi-cloud-arrow-up me-2"></i>
                                    <span>Choose an image</span>
                                </label>
                            </div>
                            @error('avatar')
                                <div class="chatbox-invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="chatbox-form-text">Max 5MB. JPEG, PNG, GIF, or WebP.</div>
                        </div>

                        @if ($user->avatar_path)
                            <div class="mb-3">
                                <div class="chatbox-checkbox-wrapper">
                                    <input class="chatbox-checkbox-input" type="checkbox" value="1" name="remove_avatar" id="removeAvatar">
                                    <label class="chatbox-checkbox-label" for="removeAvatar">
                                        <i class="bi bi-trash me-1"></i> Remove current picture
                                    </label>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="chatbox-btn-primary chatbox-btn-full connectly-btn-primary">
                            <i class="bi bi-check2 me-1"></i> Update Profile
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Right Column: Posts -->
            <div class="col-xl-8">
                <div class="chatbox-profile-posts-header connectly-profile-posts-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-text-fill chatbox-posts-header-icon connectly-posts-header-icon"></i>
                        <h5 class="mb-0 fw-bold connectly-posts-header-title">Posts</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('search') }}" method="GET" class="chatbox-profile-search-form">
                            <div class="chatbox-profile-search-group connectly-profile-search-group">
                                <i class="bi bi-search chatbox-profile-search-icon"></i>
                                <input
                                    type="text"
                                    name="q"
                                    class="chatbox-profile-search-input"
                                    placeholder="Search..."
                                    autocomplete="off"
                                >
                            </div>
                        </form>
                        <span class="chatbox-posts-count-badge connectly-posts-count-badge">{{ $posts->count() }} posts</span>
                    </div>
                </div>

                <div class="chatbox-profile-posts-container connectly-profile-posts-container">
                    <div class="d-flex flex-column gap-3 mt-3">
                        @forelse ($posts as $post)
                            @include('frontend.partials.post', ['post' => $post, 'showPinButton' => $isOwner])
                        @empty
                            <div class="chatbox-profile-empty-state connectly-profile-empty-state">
                                <div class="chatbox-profile-empty-icon connectly-profile-empty-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <h6 class="fw-bold mb-1">No posts yet</h6>
                                <p class="text-muted small mb-0">
                                    @if($isOwner)
                                        Share your first post from the Feed page!
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
    </div>
</div>

<style>
:root {
    --profile-bg: #f5f5f7;
    --profile-surface: #ffffff;
    --profile-surface-hover: #fafbfc;
    --profile-border: #e5e7eb;
    --profile-border-light: #f0f0f2;
    --profile-border-focus: #0071e3;
    --profile-text: #1d1d1f;
    --profile-text-secondary: #424245;
    --profile-muted: #86868b;
    --profile-muted-light: #aeaeb2;
    --profile-primary: #0071e3;
    --profile-primary-light: #40a9ff;
    --profile-primary-dark: #0058b3;
    --profile-primary-subtle: rgba(0,113,227,0.06);
    --profile-primary-glow: rgba(0,113,227,0.15);
    --profile-radius: 24px;
    --profile-radius-sm: 16px;
    --profile-radius-xs: 12px;
    --profile-shadow-sm: 0 1px 3px rgba(0,0,0,0.03);
    --profile-shadow: 0 2px 8px rgba(0,0,0,0.04);
    --profile-shadow-md: 0 4px 16px rgba(0,0,0,0.05);
    --profile-shadow-lg: 0 8px 30px rgba(0,0,0,0.06);
    --profile-shadow-xl: 0 16px 48px rgba(0,0,0,0.08);
    --profile-transition: 0.35s cubic-bezier(.4,0,.2,1);
}

.connectly-profile-page {
    min-height: 100dvh;
    background: var(--profile-bg);
    padding-bottom: 2rem;
    position: relative;
}

.connectly-profile-page::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 280px;
    background: linear-gradient(180deg, rgba(0,113,227,0.04) 0%, transparent 100%);
    pointer-events: none;
    z-index: 0;
}

.connectly-profile-page > .container {
    position: relative;
    z-index: 1;
}

.connectly-profile-alert {
    border-radius: var(--profile-radius-xs);
    border: none;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    font-weight: 500;
    box-shadow: 0 4px 16px rgba(16,185,129,0.15);
    backdrop-filter: blur(8px);
}

.connectly-profile-card {
    background: var(--profile-surface);
    border: 1px solid var(--profile-border);
    border-radius: var(--profile-radius);
    padding: 1.75rem;
    box-shadow: var(--profile-shadow-sm);
    transition: box-shadow var(--profile-transition), transform var(--profile-transition);
    position: relative;
    overflow: hidden;
}

.connectly-profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--profile-primary), var(--profile-primary-light), var(--profile-primary));
    opacity: 0.6;
}

.connectly-profile-card:hover {
    box-shadow: var(--profile-shadow-md);
    transform: translateY(-2px);
}

@media (min-width: 1200px) {
    .connectly-profile-card-sticky {
        position: sticky;
        top: 1.5rem;
    }
}

.connectly-profile-avatar-section {
    text-align: center;
    padding-bottom: 1.25rem;
}

.connectly-profile-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--profile-surface);
    box-shadow: 0 0 0 2px var(--profile-border), 0 8px 24px rgba(0,0,0,0.06);
    transition: transform var(--profile-transition), box-shadow var(--profile-transition);
}

.connectly-profile-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 0 0 2px var(--profile-primary-subtle), 0 12px 32px rgba(0,0,0,0.08);
}

.connectly-profile-avatar-fallback {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 2.8rem;
    color: #fff;
    background: linear-gradient(135deg, #0071e3 0%, #0058b3 100%);
    letter-spacing: -0.02em;
}

.connectly-profile-name {
    color: var(--profile-text);
    font-size: 1.3rem;
    font-weight: 700;
    letter-spacing: -0.01em;
}

.connectly-profile-email {
    font-size: 0.8rem;
    color: var(--profile-muted);
}

.connectly-profile-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: linear-gradient(135deg, var(--profile-primary-subtle), rgba(0,113,227,0.03));
    color: var(--profile-primary);
    font-size: 0.7rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 999px;
    border: 1px solid rgba(0,113,227,0.1);
}

.connectly-friend-status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: var(--profile-radius-xs);
    border: 1.5px solid;
    transition: all 0.25s ease;
}

.connectly-friend-pending {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    color: #b45309;
    border-color: #fde68a;
}

.connectly-friend-accepted {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #047857;
    border-color: #a7f3d0;
}

.connectly-friend-rejected {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #b91c1c;
    border-color: #fecaca;
}

.connectly-friend-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: var(--profile-radius-xs);
    border: 1.5px solid var(--profile-border);
    background: var(--profile-surface);
    color: var(--profile-muted);
    cursor: pointer;
    transition: all 0.25s ease;
    font-size: 0.85rem;
    text-decoration: none;
}

.connectly-friend-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}

.connectly-friend-cancel-btn:hover,
.connectly-friend-reject-btn:hover,
.connectly-friend-unfriend-btn:hover {
    background: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
}

.connectly-friend-send-again-btn:hover {
    background: var(--profile-primary-subtle);
    border-color: rgba(0,113,227,0.15);
    color: var(--profile-primary);
}

.connectly-profile-stats-row {
    display: flex;
    justify-content: center;
    gap: 0;
    background: var(--profile-surface-hover);
    border-radius: var(--profile-radius-sm);
    padding: 0.75rem;
    border: 1px solid var(--profile-border-light);
    margin: 0.75rem 0 0.25rem;
    position: relative;
    overflow: hidden;
}

.connectly-profile-stats-row::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,113,227,0.08), transparent);
}

.connectly-profile-stat-item {
    flex: 1;
    text-align: center;
    padding: 0.25rem 0.4rem;
    border-right: 1px solid var(--profile-border-light);
    position: relative;
}

.connectly-profile-stat-item:last-child {
    border-right: none;
}

.connectly-profile-stat-item:hover .connectly-profile-stat-value {
    color: var(--profile-primary);
}

.connectly-profile-stat-value {
    display: block;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--profile-text);
    line-height: 1.3;
    transition: color 0.25s ease;
    font-variant-numeric: tabular-nums;
}

.connectly-profile-stat-label {
    display: block;
    font-size: 0.65rem;
    color: var(--profile-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.connectly-profile-divider {
    margin: 1.25rem 0;
    border-color: var(--profile-border-light);
    opacity: 1;
    position: relative;
}

.connectly-profile-form {
    text-align: left;
}

.connectly-form-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--profile-text);
    margin-bottom: 0.4rem;
    letter-spacing: 0.01em;
}

.connectly-input-group {
    position: relative;
}

.connectly-form-control {
    width: 100%;
    padding: 0.7rem 2.5rem 0.7rem 0.9rem;
    font-size: 0.85rem;
    border: 1.5px solid var(--profile-border);
    border-radius: var(--profile-radius-xs);
    background: var(--profile-surface-hover);
    color: var(--profile-text);
    transition: all 0.25s ease;
    outline: none;
    font-family: inherit;
    line-height: 1.5;
}

.connectly-form-control:focus {
    border-color: var(--profile-border-focus);
    background: var(--profile-surface);
    box-shadow: 0 0 0 4px rgba(0,113,227,0.08);
}

.connectly-form-control::placeholder {
    color: var(--profile-muted-light);
}

.connectly-input-icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--profile-muted-light);
    font-size: 0.85rem;
    pointer-events: none;
    transition: color 0.25s ease;
}

.connectly-form-control:focus ~ .connectly-input-icon {
    color: var(--profile-primary);
}

.connectly-invalid-feedback {
    color: #dc2626;
    font-size: 0.72rem;
    margin-top: 5px;
    font-weight: 500;
}

.connectly-form-control.is-invalid {
    border-color: #dc2626;
    background: #fef2f2;
}

.connectly-file-input-wrapper {
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
    padding: 0.7rem 0.9rem;
    border: 1.5px dashed var(--profile-border);
    border-radius: var(--profile-radius-xs);
    background: var(--profile-surface-hover);
    color: var(--profile-muted);
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
    gap: 8px;
}

.connectly-file-label:hover {
    border-color: var(--profile-primary);
    background: var(--profile-primary-subtle);
    color: var(--profile-primary);
}

.connectly-file-input.has-file ~ .connectly-file-label span {
    color: var(--profile-primary);
}

.connectly-form-text {
    font-size: 0.68rem;
    color: var(--profile-muted-light);
    margin-top: 5px;
}

.connectly-checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.connectly-checkbox-input {
    width: 18px;
    height: 18px;
    border-radius: 5px;
    border: 2px solid var(--profile-border);
    accent-color: #dc2626;
    cursor: pointer;
    transition: border-color 0.2s ease;
}

.connectly-checkbox-input:hover {
    border-color: #dc2626;
}

.connectly-checkbox-label {
    font-size: 0.82rem;
    color: #dc2626;
    font-weight: 500;
    cursor: pointer;
    user-select: none;
}

.connectly-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 0.7rem 1.35rem;
    background: var(--profile-primary);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    border-radius: var(--profile-radius-xs);
    cursor: pointer;
    transition: all var(--profile-transition);
    box-shadow: 0 4px 14px rgba(0,113,227,0.2);
    text-decoration: none;
    font-family: inherit;
    position: relative;
    overflow: hidden;
}

.connectly-btn-primary::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
    pointer-events: none;
}

.connectly-btn-primary:hover {
    background: var(--profile-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(0,113,227,0.28);
    color: #fff;
}

.connectly-btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(0,113,227,0.2);
}

.connectly-btn-full {
    width: 100%;
}

.connectly-profile-posts-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--profile-surface);
    border: 1px solid var(--profile-border);
    border-radius: var(--profile-radius);
    padding: 1.1rem 1.35rem;
    box-shadow: var(--profile-shadow-sm);
    transition: box-shadow var(--profile-transition);
}

.connectly-profile-posts-header:hover {
    box-shadow: var(--profile-shadow);
}

.connectly-posts-header-icon {
    font-size: 1.25rem;
    color: var(--profile-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    background: var(--profile-primary-subtle);
    border-radius: 10px;
}

.connectly-posts-header-title {
    font-size: 0.95rem;
    color: var(--profile-text);
    letter-spacing: -0.01em;
}

.connectly-posts-count-badge {
    background: linear-gradient(135deg, var(--profile-primary-subtle), rgba(0,113,227,0.03));
    color: var(--profile-primary);
    font-size: 0.72rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 999px;
    border: 1px solid rgba(0,113,227,0.1);
    flex-shrink: 0;
}

.connectly-profile-search-form {
    display: flex;
    align-items: center;
}

.connectly-profile-search-group {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--profile-surface-hover);
    border: 1.5px solid var(--profile-border);
    border-radius: var(--profile-radius-xs);
    transition: all 0.25s ease;
    width: 180px;
}

.connectly-profile-search-group:focus-within {
    border-color: var(--profile-border-focus);
    background: var(--profile-surface);
    box-shadow: 0 0 0 4px rgba(0,113,227,0.08);
    width: 220px;
}

.connectly-profile-search-icon {
    position: absolute;
    left: 12px;
    color: var(--profile-muted-light);
    font-size: 0.8rem;
    pointer-events: none;
    transition: color 0.25s ease;
}

.connectly-profile-search-group:focus-within .connectly-profile-search-icon {
    color: var(--profile-primary);
}

.connectly-profile-search-input {
    border: none;
    outline: none;
    padding: 0.45rem 0.75rem 0.45rem 2.1rem;
    font-size: 0.8rem;
    color: var(--profile-text);
    background: transparent;
    border-radius: 10px;
    width: 100%;
    font-family: inherit;
}

.connectly-profile-search-input::placeholder {
    color: var(--profile-muted-light);
}

.connectly-profile-posts-container .connectly-post-card,
.connectly-profile-posts-container .chatbox-feed-post-card {
    padding: 1.25rem;
    border-radius: var(--profile-radius);
    border: 1px solid var(--profile-border);
    background: var(--profile-surface);
    box-shadow: var(--profile-shadow-sm);
    transition: box-shadow var(--profile-transition), border-color var(--profile-transition), transform var(--profile-transition);
    position: relative;
    overflow: hidden;
}

.connectly-profile-posts-container .connectly-post-card::before,
.connectly-profile-posts-container .chatbox-feed-post-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,113,227,0.06), transparent);
    opacity: 0;
    transition: opacity var(--profile-transition);
}

.connectly-profile-posts-container .connectly-post-card:hover,
.connectly-profile-posts-container .chatbox-feed-post-card:hover {
    box-shadow: var(--profile-shadow);
    border-color: #d2d2d7;
    transform: translateY(-1px);
}

.connectly-profile-posts-container .connectly-post-card:hover::before,
.connectly-profile-posts-container .chatbox-feed-post-card:hover::before {
    opacity: 1;
}

.connectly-profile-posts-container .connectly-post-card.pinned,
.connectly-profile-posts-container .chatbox-feed-post-card[data-pinned="true"] {
    border-color: #fde68a;
    background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%);
}

.connectly-profile-posts-container > div {
    animation: profileStaggerIn 0.5s ease-out both;
}

.connectly-profile-posts-container > div:nth-child(1) { animation-delay: 0.03s; }
.connectly-profile-posts-container > div:nth-child(2) { animation-delay: 0.06s; }
.connectly-profile-posts-container > div:nth-child(3) { animation-delay: 0.09s; }

@keyframes profileStaggerIn {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.connectly-pinned-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #b45309;
    font-size: 0.65rem;
    font-weight: 600;
    padding: 3px 11px;
    border-radius: 999px;
    border: 1px solid #fde68a;
    letter-spacing: 0.01em;
}

.connectly-profile-empty-state {
    text-align: center;
    padding: 3.5rem 1.5rem;
    background: var(--profile-surface);
    border: 1px solid var(--profile-border);
    border-radius: var(--profile-radius);
    box-shadow: var(--profile-shadow-sm);
    animation: profileStaggerIn 0.5s ease-out;
}

.connectly-profile-empty-icon {
    width: 64px;
    height: 64px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--profile-primary-subtle), rgba(0,113,227,0.02));
    border-radius: 50%;
    font-size: 1.5rem;
    color: var(--profile-primary);
    margin-bottom: 1rem;
    border: 1px solid rgba(0,113,227,0.08);
    transition: transform 0.3s ease;
}

.connectly-profile-empty-state:hover .connectly-profile-empty-icon {
    transform: scale(1.08);
}

.connectly-toast-popup {
    border-radius: var(--profile-radius-xs) !important;
    box-shadow: var(--profile-shadow-lg) !important;
    font-family: inherit !important;
}

.connectly-toast-popup .swal2-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--profile-text) !important;
}

.connectly-toast-popup .swal2-timer-progress-bar {
    background: rgba(0,113,227,0.12) !important;
    height: 3px !important;
}

.connectly-toast-popup.swal2-icon-success {
    border-left: 4px solid #10b981 !important;
}

.connectly-toast-popup.swal2-icon-error {
    border-left: 4px solid #ef4444 !important;
}

.post-actions-wrap {
    position: relative;
}

.post-actions-trigger {
    width: 34px;
    height: 34px;
    border: none;
    background: transparent;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--profile-muted-light);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}

.post-actions-trigger:hover {
    background: var(--profile-surface-hover);
    color: var(--profile-text);
}

.post-actions-trigger:active {
    transform: scale(0.92);
}

.post-actions-trigger[aria-expanded="true"] {
    background: var(--profile-primary-subtle);
    color: var(--profile-primary);
}

.post-actions-dropdown {
    border-radius: var(--profile-radius-sm);
    border: 1px solid var(--profile-border);
    padding: 0.35rem;
    box-shadow: var(--profile-shadow-lg);
    min-width: 150px;
    animation: profileDropdownIn 0.2s ease-out;
    transform-origin: top right;
}

@keyframes profileDropdownIn {
    from { opacity: 0; transform: scale(0.92) translateY(-4px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.post-dropdown-item {
    border-radius: 8px;
    padding: 0.45rem 0.85rem;
    font-size: 0.82rem;
    font-weight: 500;
    color: var(--profile-text);
    transition: all 0.15s ease;
}

.post-dropdown-item:hover {
    background: var(--profile-primary-subtle);
    color: var(--profile-primary);
}

.post-dropdown-item i {
    font-size: 0.9rem;
}

.post-dropdown-danger {
    color: #dc2626 !important;
}

.post-dropdown-danger:hover {
    background: rgba(239,68,68,0.08) !important;
    color: #dc2626 !important;
}

.post-actions-dropdown .dropdown-divider {
    margin: 0.25rem 0;
    border-top-color: var(--profile-border-light);
}

@media (max-width: 991.98px) {
    .connectly-profile-card {
        margin-bottom: 1rem;
    }
}

@media (max-width: 767.98px) {
    .connectly-profile-avatar {
        width: 100px;
        height: 100px;
    }

    .connectly-profile-avatar-fallback {
        font-size: 2.2rem;
    }

    .connectly-profile-card {
        padding: 1.25rem;
        border-radius: 20px;
    }

    .connectly-profile-stats-row {
        padding: 0.5rem;
        border-radius: var(--profile-radius-xs);
    }

    .connectly-profile-stat-value {
        font-size: 1rem;
    }

    .connectly-profile-posts-header {
        border-radius: 20px;
        padding: 0.9rem 1rem;
    }
}

@media (max-width: 575.98px) {
    .connectly-profile-page {
        padding-bottom: 1rem;
    }

    .connectly-profile-posts-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
        border-radius: 16px;
    }

    .connectly-profile-search-group,
    .connectly-profile-search-group:focus-within {
        width: 100%;
    }

    .connectly-profile-empty-state {
        padding: 2.5rem 1rem;
        border-radius: 20px;
    }

    .connectly-profile-card {
        border-radius: 16px;
    }
}

.chatbox-profile-page { min-height: 100%; padding-bottom: 2rem; }
.chatbox-profile-alert { border-radius: 14px; border: none; font-weight: 500; }
.chatbox-profile-card { background: var(--profile-surface); border: 1px solid var(--profile-border); border-radius: var(--profile-radius); padding: 1.5rem; box-shadow: var(--profile-shadow); }
.chatbox-profile-sticky { position: sticky; top: 1rem; }
.chatbox-profile-avatar-section { text-align: center; padding-bottom: 1rem; }
.chatbox-profile-avatar { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--profile-border-light); box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
.chatbox-profile-avatar-fallback { display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2.6rem; color: #fff; background: linear-gradient(135deg, var(--profile-primary) 0%, var(--profile-primary-dark) 100%); }
.chatbox-profile-name { font-size: 1.2rem; font-weight: 700; color: var(--profile-text); }
.chatbox-profile-badge { display: inline-flex; align-items: center; gap: 4px; background: var(--profile-primary-subtle); color: var(--profile-primary); font-size: 0.72rem; font-weight: 600; padding: 4px 12px; border-radius: 999px; border: 1px solid rgba(0,113,227,0.12); }
.chatbox-friend-status-badge { display: inline-flex; align-items: center; justify-content: center; gap: 4px; font-size: 0.8rem; font-weight: 600; padding: 0.5rem 1rem; border-radius: var(--profile-radius-xs); border: 1.5px solid; }
.chatbox-friend-pending { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.chatbox-friend-accepted { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
.chatbox-friend-rejected { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
.chatbox-friend-action-btn { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: var(--profile-radius-xs); border: 1.5px solid var(--profile-border); background: var(--profile-surface); color: var(--profile-muted); cursor: pointer; transition: all 0.2s ease; font-size: 0.85rem; }
.chatbox-profile-stats-row { display: flex; justify-content: center; gap: 1px; background: var(--profile-surface-hover); border-radius: var(--profile-radius-sm); padding: 0.65rem; border: 1px solid var(--profile-border-light); margin: 0.5rem 0 0.2rem; }
.chatbox-profile-stat-item { flex: 1; text-align: center; padding: 0.2rem 0.4rem; border-right: 1px solid var(--profile-border-light); }
.chatbox-profile-stat-item:last-child { border-right: none; }
.chatbox-profile-stat-value { display: block; font-size: 1.1rem; font-weight: 700; color: var(--profile-text); line-height: 1.3; }
.chatbox-profile-stat-label { display: block; font-size: 0.68rem; color: var(--profile-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.4px; }
.chatbox-profile-divider { margin: 1rem 0; border-color: var(--profile-border-light); opacity: 1; }
.chatbox-profile-form { text-align: left; }
.chatbox-form-label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--profile-text); margin-bottom: 0.4rem; }
.chatbox-input-group { position: relative; }
.chatbox-form-control { width: 100%; padding: 0.65rem 2.5rem 0.65rem 0.9rem; font-size: 0.85rem; border: 1.5px solid var(--profile-border); border-radius: var(--profile-radius-xs); background: var(--profile-surface-hover); color: var(--profile-text); transition: all 0.2s; outline: none; }
.chatbox-form-control:focus { border-color: var(--profile-border-focus); background: var(--profile-surface); box-shadow: 0 0 0 3px rgba(0,113,227,0.1); }
.chatbox-input-icon { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--profile-muted-light); font-size: 0.85rem; pointer-events: none; }
.chatbox-invalid-feedback { color: #dc2626; font-size: 0.75rem; margin-top: 4px; font-weight: 500; }
.chatbox-file-input-wrapper { position: relative; }
.chatbox-file-input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
.chatbox-file-label { display: flex; align-items: center; padding: 0.65rem 0.9rem; border: 1.5px dashed var(--profile-border); border-radius: var(--profile-radius-xs); background: var(--profile-surface-hover); color: var(--profile-muted); font-size: 0.82rem; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.chatbox-file-label:hover { border-color: var(--profile-primary); background: var(--profile-primary-subtle); color: var(--profile-primary); }
.chatbox-form-text { font-size: 0.7rem; color: var(--profile-muted-light); margin-top: 4px; }
.chatbox-checkbox-wrapper { display: flex; align-items: center; gap: 8px; }
.chatbox-checkbox-input { width: 18px; height: 18px; border-radius: 4px; border: 2px solid var(--profile-border); accent-color: #dc2626; cursor: pointer; }
.chatbox-checkbox-label { font-size: 0.82rem; color: #dc2626; font-weight: 500; cursor: pointer; user-select: none; }
.chatbox-btn-primary { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 0.65rem 1.25rem; background: var(--profile-primary); color: #fff; font-size: 0.85rem; font-weight: 600; border: none; border-radius: var(--profile-radius-xs); cursor: pointer; transition: all 0.25s cubic-bezier(.4,0,.2,1); box-shadow: 0 4px 12px rgba(0,113,227,0.2); text-decoration: none; }
.chatbox-btn-primary:hover { background: var(--profile-primary-dark); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(0,113,227,0.28); color: #fff; }
.chatbox-btn-full { width: 100%; }
.chatbox-profile-posts-header { display: flex; align-items: center; justify-content: space-between; background: var(--profile-surface); border: 1px solid var(--profile-border); border-radius: var(--profile-radius); padding: 1rem 1.25rem; box-shadow: var(--profile-shadow); }
.chatbox-posts-header-icon { font-size: 1.2rem; color: var(--profile-primary); }
.chatbox-posts-count-badge { background: var(--profile-primary-subtle); color: var(--profile-primary); font-size: 0.75rem; font-weight: 600; padding: 4px 12px; border-radius: 999px; border: 1px solid rgba(0,113,227,0.12); }
.chatbox-profile-search-form { display: flex; align-items: center; }
.chatbox-profile-search-group { position: relative; display: flex; align-items: center; background: var(--profile-surface-hover); border: 1.5px solid var(--profile-border); border-radius: var(--profile-radius-xs); transition: all 0.2s ease; width: 180px; }
.chatbox-profile-search-group:focus-within { border-color: var(--profile-border-focus); background: var(--profile-surface); box-shadow: 0 0 0 3px rgba(0,113,227,0.1); width: 220px; }
.chatbox-profile-search-icon { position: absolute; left: 10px; color: var(--profile-muted-light); font-size: 0.8rem; pointer-events: none; }
.chatbox-profile-search-input { border: none; outline: none; padding: 0.4rem 0.7rem 0.4rem 2rem; font-size: 0.8rem; color: var(--profile-text); background: transparent; border-radius: 8px; width: 100%; }
.chatbox-profile-empty-state { text-align: center; padding: 3rem 1.5rem; background: var(--profile-surface); border: 1px solid var(--profile-border); border-radius: var(--profile-radius); box-shadow: var(--profile-shadow); }
.chatbox-profile-empty-icon { width: 56px; height: 56px; display: inline-flex; align-items: center; justify-content: center; background: var(--profile-primary-subtle); border-radius: 50%; font-size: 1.4rem; color: var(--profile-primary); margin-bottom: 0.75rem; }
.chatbox-toast-popup { border-radius: var(--profile-radius-xs) !important; box-shadow: var(--profile-shadow-lg) !important; font-family: inherit !important; }
.chatbox-toast-popup .swal2-title { font-size: 0.85rem !important; font-weight: 500 !important; color: var(--profile-text) !important; }
.chatbox-toast-popup .swal2-timer-progress-bar { background: rgba(0,113,227,0.12) !important; height: 3px !important; }
.chatbox-toast-popup.swal2-icon-success { border-left: 4px solid #10b981 !important; }
.chatbox-toast-popup.swal2-icon-error { border-left: 4px solid #ef4444 !important; }
.chatbox-pinned-badge { display: inline-flex; align-items: center; gap: 3px; background: #fef3c7; color: #b45309; font-size: 0.68rem; font-weight: 600; padding: 2px 10px; border-radius: 999px; border: 1px solid #fde68a; }
.chatbox-reaction-picker { position: relative; display: inline-flex; align-items: center; }
.chatbox-reaction-options { position: absolute; left: 0; bottom: calc(100% + 4px); display: flex; gap: 0.35rem; padding: 0.35rem 0.45rem; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 999px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); opacity: 0; visibility: hidden; pointer-events: none; transform: translateY(8px); transition: all 0.18s ease; z-index: 25; }
.chatbox-reaction-options::after { content: ''; position: absolute; left: 0; right: 0; bottom: -12px; height: 12px; }
.chatbox-reaction-picker:hover .chatbox-reaction-options, .chatbox-reaction-picker:focus-within .chatbox-reaction-options, .chatbox-reaction-options:hover { opacity: 1; visibility: visible; pointer-events: auto; transform: translateY(0); }
.chatbox-reaction-option { border: none; background: transparent; border-radius: 50%; width: 34px; height: 34px; font-size: 1.05rem; line-height: 1; display: inline-flex; align-items: center; justify-content: center; transition: transform 0.15s ease, background-color 0.15s ease; cursor: pointer; }
.chatbox-reaction-option:hover { transform: scale(1.18); background: rgba(0,113,227,0.06); }
.chatbox-reaction-option.active { background: rgba(0,113,227,0.1); }
.chatbox-comment-reaction-picker { position: relative; display: inline-flex; align-items: center; }
.chatbox-comment-reaction-options { position: absolute; left: 0; bottom: calc(100% + 4px); display: flex; gap: 0.35rem; padding: 0.35rem 0.45rem; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 999px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); opacity: 0; visibility: hidden; pointer-events: none; transform: translateY(8px); transition: all 0.18s ease; z-index: 35; }
.chatbox-comment-reaction-options::after { content: ''; position: absolute; left: 0; right: 0; bottom: -12px; height: 12px; }
.chatbox-comment-reaction-picker:hover .chatbox-comment-reaction-options, .chatbox-comment-reaction-picker:focus-within .chatbox-comment-reaction-options, .chatbox-comment-reaction-options:hover { opacity: 1; visibility: visible; pointer-events: auto; transform: translateY(0); }
.chatbox-comment-reaction-option { border: none; background: transparent; border-radius: 50%; width: 32px; height: 32px; font-size: 1rem; line-height: 1; display: inline-flex; align-items: center; justify-content: center; transition: transform 0.15s ease, background-color 0.15s ease; cursor: pointer; }
.chatbox-comment-reaction-option:hover { transform: scale(1.18); background: rgba(0,113,227,0.06); }
.chatbox-comment-reaction-option.active { background: rgba(0,113,227,0.1); }
.chatbox-comment-item { padding: 0.75rem; border-radius: var(--profile-radius-xs); border: 1px solid var(--profile-border); background: var(--profile-surface-hover); }
.chatbox-comment-replies { margin-left: 1rem; padding-left: 0.9rem; border-left: 2px solid var(--profile-border); }
.chatbox-comment-reply-item { padding: 0.65rem; border-radius: var(--profile-radius-xs); border: 1px solid var(--profile-border); background: var(--profile-surface); }
.chatbox-comment-image { max-width: 320px; max-height: 260px; object-fit: cover; border: 1px solid var(--profile-border); }
.chatbox-reply-indicator { border-radius: var(--profile-radius-xs); font-size: 0.82rem; background: var(--profile-primary-subtle); border: 1px solid rgba(0,113,227,0.12); color: var(--profile-primary); }
.chatbox-reaction-badge-emoji { font-size: 0.75rem; }
.chatbox-reaction-badge-count { font-size: 0.68rem; font-weight: 600; }
.chatbox-comment-reaction-badge-emoji { font-size: 0.75rem; }
.chatbox-comment-reaction-badge-count { font-size: 0.68rem; font-weight: 600; }
.chatbox-profile-link { font-weight: 600; color: var(--profile-primary-dark); transition: color 0.2s ease; }
.chatbox-profile-link:hover { color: var(--profile-primary); }
.chatbox-feed-avatar { width: 42px; height: 42px; border: 2px solid var(--profile-border-light); background: linear-gradient(135deg, var(--profile-primary) 0%, var(--profile-primary-dark) 100%); }
.chatbox-feed-avatar-alt { background: linear-gradient(135deg, #6b7280 0%, #374151 100%); }
.chatbox-feed-avatar-image { border-color: var(--profile-border-light); }
.chatbox-feed-post-card { padding: 1.25rem; border-radius: var(--profile-radius); border: 1px solid var(--profile-border); background: var(--profile-surface); box-shadow: var(--profile-shadow); transition: box-shadow 0.25s ease, border-color 0.25s ease; }
.chatbox-feed-post-card:hover { box-shadow: var(--profile-shadow-md); border-color: #d2d2d7; }
.chatbox-feed-post-text { font-size: 0.95rem; line-height: 1.75; color: var(--profile-text); }
.chatbox-feed-post-image { border-radius: var(--profile-radius-xs); border: 1px solid var(--profile-border-light); }
.chatbox-pinned-badge { display: inline-flex; align-items: center; gap: 3px; background: #fef3c7; color: #b45309; font-size: 0.68rem; font-weight: 600; padding: 2px 10px; border-radius: 999px; border: 1px solid #fde68a; }
.chatbox-main-reaction-input { }
.chatbox-main-reaction-button { }
.chatbox-main-reaction-emoji { }
.chatbox-main-reaction-label { }
.chatbox-main-reaction-count { }
.chatbox-comment-main-reaction-input { }
.chatbox-comment-main-reaction-button { }
.chatbox-comment-main-reaction-emoji { }
.chatbox-comment-main-reaction-label { }
.chatbox-comment-main-reaction-count { }
.chatbox-reply-trigger { }
.chatbox-reply-cancel { }
.chatbox-file-input.has-file ~ .chatbox-file-label span { color: var(--profile-primary); }
</style>

<script>
    // Update file input label when a file is selected
    document.addEventListener('change', function(e) {
        if (e.target.matches('.chatbox-file-input')) {
            const label = e.target.closest('.chatbox-file-input-wrapper')?.querySelector('.chatbox-file-label span');
            if (label && e.target.files.length > 0) {
                label.textContent = e.target.files[0].name;
                e.target.classList.add('has-file');
            } else if (label) {
                label.textContent = 'Choose an image';
                e.target.classList.remove('has-file');
            }
        }
    });

    // ===== SWEET ALERT BEFORE UNFRIEND =====
    document.addEventListener('submit', function(e) {
        const unfriendForm = e.target.closest('.chatbox-unfriend-form');
        if (!unfriendForm) return;

        e.preventDefault();

        const userName = unfriendForm.dataset.userName || 'this user';

        Swal.fire({
            title: 'Are you sure?',
            text: `You will no longer be friends with ${userName}. This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="bi bi-person-dash-fill me-1"></i> Yes, Unfriend',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'chatbox-toast-popup',
                confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1',
                cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border'
            },
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const response = await fetch(unfriendForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(unfriendForm),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to unfriend.');
                    }

                    return data;
                } catch (error) {
                    Swal.showValidationMessage(error.message);
                    throw error;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Replace the friend status area with "Add Friend" button
                const container = unfriendForm.closest('.d-flex');
                if (container) {
                    const userId = unfriendForm.dataset.userId;
                    const addFriendUrl = `{{ url('/friend-request') }}/${userId}/send`;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    container.outerHTML = `
                        <form action="${addFriendUrl}" method="POST" class="w-100">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="chatbox-btn-primary chatbox-btn-full chatbox-profile-message-btn">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Add Friend
                            </button>
                        </form>
                    `;
                }

                // Update friend count in sidebar stat
                const friendCountEl = document.querySelector('.chatbox-friend-count-stat');
                if (friendCountEl) {
                    const currentCount = parseInt(friendCountEl.textContent, 10) || 0;
                    friendCountEl.textContent = Math.max(0, currentCount - 1);
                }

                chatboxToast('success', `Unfriended ${userName}`);
            }
        });
    });

    // ===== SWEET ALERT BEFORE CANCEL REQUEST =====
    document.addEventListener('submit', function(e) {
        const cancelForm = e.target.closest('.chatbox-cancel-form');
        if (!cancelForm) return;

        e.preventDefault();

        const userName = cancelForm.dataset.userName || 'this user';

        Swal.fire({
            title: 'Cancel Request?',
            text: `Cancel your friend request to ${userName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Yes, Cancel',
            cancelButtonText: 'Keep Request',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'chatbox-toast-popup',
                confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1',
                cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border'
            },
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const response = await fetch(cancelForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(cancelForm),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to cancel request.');
                    }

                    return data;
                } catch (error) {
                    Swal.showValidationMessage(error.message);
                    throw error;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const container = cancelForm.closest('.d-flex');
                if (container) {
                    const userId = cancelForm.dataset.userId;
                    const addFriendUrl = '{{ url("/friend-request") }}';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    container.outerHTML = `
                        <form action="${addFriendUrl}/${userId}/send" method="POST" class="w-100">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="chatbox-btn-primary chatbox-btn-full chatbox-profile-message-btn">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Add Friend
                            </button>
                        </form>
                    `;
                }

                chatboxToast('success', `Request to ${userName} cancelled`);
            }
        });
    });

    // ===== SWEET ALERT BEFORE ACCEPT REQUEST =====
    document.addEventListener('submit', function(e) {
        const acceptForm = e.target.closest('.chatbox-profile-accept-form');
        if (!acceptForm) return;

        e.preventDefault();

        const userName = acceptForm.dataset.userName || 'this user';

        Swal.fire({
            title: 'Accept Request?',
            text: `You will become friends with ${userName}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Yes, Accept',
            cancelButtonText: 'Not Now',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'chatbox-toast-popup',
                confirmButton: 'btn btn-success px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1',
                cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border'
            },
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const response = await fetch(acceptForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(acceptForm),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to accept request.');
                    }

                    return data;
                } catch (error) {
                    Swal.showValidationMessage(error.message);
                    throw error;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Replace the accept/reject area with "Friends" status + unfriend button
                const container = acceptForm.closest('.d-flex');
                if (container) {
                    const userId = acceptForm.dataset.userId;
                    const unfriendUrl = `{{ url('/friend-request') }}/${userId}/unfriend`;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    container.outerHTML = `
                        <div class="d-flex gap-2 w-100 mt-2">
                            <span class="chatbox-friend-status-badge chatbox-friend-accepted flex-grow-1">
                                <i class="bi bi-people-fill me-1"></i> Friends
                            </span>
                            <form action="${unfriendUrl}" method="POST" class="chatbox-unfriend-form" data-user-name="${acceptForm.dataset.userName}" data-user-id="${userId}">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="chatbox-friend-action-btn chatbox-friend-unfriend-btn" title="Unfriend">
                                    <i class="bi bi-person-dash-fill"></i>
                                </button>
                            </form>
                        </div>
                    `;
                }

                // Update friend count in sidebar stat
                const friendCountEl = document.querySelector('.chatbox-friend-count-stat');
                if (friendCountEl) {
                    const currentCount = parseInt(friendCountEl.textContent, 10) || 0;
                    friendCountEl.textContent = currentCount + 1;
                }

                chatboxToast('success', `Accepted ${userName}'s request`);
            }
        });
    });

    // ===== SWEET ALERT BEFORE REJECT REQUEST =====
    document.addEventListener('submit', function(e) {
        const rejectForm = e.target.closest('.chatbox-reject-form');
        if (!rejectForm) return;

        e.preventDefault();

        const userName = rejectForm.dataset.userName || 'this user';

        Swal.fire({
            title: 'Reject Request?',
            text: `Reject the friend request from ${userName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Yes, Reject',
            cancelButtonText: 'Keep Request',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'chatbox-toast-popup',
                confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1',
                cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border'
            },
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const response = await fetch(rejectForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(rejectForm),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to reject request.');
                    }

                    return data;
                } catch (error) {
                    Swal.showValidationMessage(error.message);
                    throw error;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const container = rejectForm.closest('.d-flex');
                if (container) {
                    const userId = rejectForm.dataset.userId;
                    const addFriendUrl = '{{ url("/friend-request") }}';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    container.outerHTML = `
                        <form action="${addFriendUrl}/${userId}/send" method="POST" class="w-100">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="chatbox-btn-primary chatbox-btn-full chatbox-profile-message-btn">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Add Friend
                            </button>
                        </form>
                    `;
                }

                chatboxToast('success', `Request from ${userName} rejected`);
            }
        });
    });

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
                popup: 'chatbox-toast-popup'
            }
        });
    }

    // ===== LIVE POST REACTIONS =====
    document.addEventListener('submit', async function (event) {
        const form = event.target;
        if (!form.matches('[data-reaction-form]')) {
            return;
        }

        event.preventDefault();

        const picker = form.closest('.chatbox-reaction-picker');
        if (!picker) {
            return;
        }

        const card = picker.closest('.chatbox-feed-post-card');
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

            picker.querySelectorAll('.chatbox-reaction-option').forEach((optionButton) => {
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

    // ===== COMMENT REACTION META =====
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
            ? `<div class="mt-2"><img src="${chatboxEscapeHtml(comment.image_url)}" alt="Comment image" class="img-fluid rounded chatbox-comment-image"></div>`
            : '';

        const reactionOptions = Object.entries(chatboxCommentReactionMeta).map(([key, meta]) => `
            <form action="/feed/comments/${comment.id}/react" method="POST" class="d-inline" data-comment-reaction-form="option">
                <input type="hidden" name="_token" value="${window.chatboxCsrfToken || ''}">
                <input type="hidden" name="reaction_type" value="${key}">
                <button type="submit" class="chatbox-comment-reaction-option" title="${meta.label}" aria-label="${meta.label}" data-reaction-key="${key}">
                    ${meta.emoji}
                </button>
            </form>
        `).join('');

        const reactionBadges = Object.entries(chatboxCommentReactionMeta).map(([key, meta]) => `
            <span class="badge rounded-pill text-bg-light border d-none" data-comment-reaction-badge="${key}">
                <span class="chatbox-comment-reaction-badge-emoji">${meta.emoji}</span>
                <span class="chatbox-comment-reaction-badge-count">0</span>
            </span>
        `).join('');

        return `
            <div class="${comment.parent_id ? 'chatbox-comment-reply-item mt-2' : 'chatbox-comment-item'}" data-comment-card="${comment.id}">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <strong>${safeName}</strong>
                    <span class="text-muted small">#${comment.user_id}</span>
                    <span class="text-muted small">${safeTime}</span>
                </div>
                ${safeText ? `<p class="mb-0 text-dark">${safeText}</p>` : ''}
                ${imageHtml}

                <div class="d-flex align-items-center gap-2 mt-2">
                    <div class="chatbox-comment-reaction-picker" data-comment-id="${comment.id}">
                        <form action="/feed/comments/${comment.id}/react" method="POST" class="d-inline" data-comment-reaction-form="main">
                            <input type="hidden" name="_token" value="${window.chatboxCsrfToken || ''}">
                            <input type="hidden" name="reaction_type" value="like" class="chatbox-comment-main-reaction-input">
                            <button type="submit" class="btn btn-sm chatbox-comment-main-reaction-button btn-outline-primary">
                                <span class="me-1 chatbox-comment-main-reaction-emoji">👍</span>
                                <span class="chatbox-comment-main-reaction-label">Like</span>
                                (<span class="chatbox-comment-main-reaction-count">0</span>)
                            </button>
                        </form>
                        <div class="chatbox-comment-reaction-options" aria-label="Comment reaction options">
                            ${reactionOptions}
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-secondary chatbox-reply-trigger"
                        data-form-id="commentForm${postId}"
                        data-parent-id="${parentForReply}"
                    >
                        Reply
                    </button>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                    ${reactionBadges}
                </div>

                ${comment.parent_id ? '' : `<div class="chatbox-comment-replies mt-3 d-none" data-replies-for="${comment.id}"></div>`}
            </div>
        `;
    }

    // ===== LIVE COMMENT SUBMISSION =====
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

    // ===== LIVE COMMENT REACTIONS =====
    document.addEventListener('submit', async function (event) {
        const form = event.target;
        if (!form.matches('[data-comment-reaction-form]')) {
            return;
        }

        event.preventDefault();

        const picker = form.closest('.chatbox-comment-reaction-picker');
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

            const meta = chatboxCommentReactionMeta[currentReaction] || chatboxCommentReactionMeta.like;
            if (mainEmoji) {
                mainEmoji.textContent = currentReaction ? meta.emoji : chatboxCommentReactionMeta.like.emoji;
            }
            if (mainLabel) {
                mainLabel.textContent = currentReaction ? meta.label : 'Like';
            }
            if (mainCount) {
                mainCount.textContent = String(data.total_reactions ?? 0);
            }

            picker.querySelectorAll('.chatbox-comment-reaction-option').forEach((optionButton) => {
                optionButton.classList.toggle('active', optionButton.dataset.reactionKey === currentReaction);
            });

            if (card && data.reaction_counts) {
                Object.keys(chatboxCommentReactionMeta).forEach((reactionKey) => {
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

    // ===== REPLY TRIGGER / CANCEL =====
    document.addEventListener('click', function (event) {
        const replyButton = event.target.closest('.chatbox-reply-trigger');
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
            const indicator = form.querySelector('.chatbox-reply-indicator');
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
            const indicator = form.querySelector('.chatbox-reply-indicator');

            if (parentInput) {
                parentInput.value = '';
            }

            if (indicator) {
                indicator.classList.add('d-none');
            }
        }
    });
</script>

<script>
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
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
});
</script>

@endsection
