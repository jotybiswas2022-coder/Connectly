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
    /* ============================================
       ===== CONNECTLY PROFILE PAGE THEME =====
       ============================================ */
    :root {
        --clr-primary: #2563EB;
        --clr-light: #60A5FA;
        --clr-dark: #1E40AF;
        --clr-bg: #F0F5FF;
        --clr-surface: #FFFFFF;
        --clr-text: #0F172A;
        --clr-border: rgba(37, 99, 235, 0.08);
        --clr-gradient: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 18px;
    }

    /* ===== PAGE ===== */
    .connectly-profile-page,
    .chatbox-profile-page {
        min-height: 100%;
        background: var(--clr-bg, #F0F5FF);
        padding-bottom: 2rem;
        animation: connectlyProfileFadeIn 0.5s ease-out;
    }

    @keyframes connectlyProfileFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ===== ALERT ===== */
    .connectly-profile-alert,
    .chatbox-profile-alert {
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

    /* ===== PROFILE CARD ===== */
    .connectly-profile-card,
    .chatbox-profile-card {
        background: var(--clr-surface, #FFFFFF);
        border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
        border-radius: var(--radius-lg, 18px);
        padding: 1.8rem;
        box-shadow: 0 8px 28px rgba(15, 23, 42, 0.06);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        animation: connectlyCardSlideUp 0.5s ease-out;
    }

    .connectly-profile-card:hover,
    .chatbox-profile-card:hover {
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1);
        transform: translateY(-2px);
    }

    @keyframes connectlyCardSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Desktop: profile card stays sticky while posts scroll naturally */
    @media (min-width: 1200px) {
        .chatbox-profile-sticky,
        .connectly-profile-card-sticky {
            position: sticky;
            top: 1rem;
        }

        .connectly-profile-posts-container {
            padding-bottom: 1rem;
        }
    }

    /* ===== AVATAR SECTION ===== */
    .connectly-profile-avatar-section,
    .chatbox-profile-avatar-section {
        text-align: center;
        padding-bottom: 1.2rem;
    }

    .connectly-profile-avatar,
    .chatbox-profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #dbeafe;
        box-shadow: 0 8px 28px rgba(37, 99, 235, 0.18);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease;
    }

    .connectly-profile-avatar:hover,
    .chatbox-profile-avatar:hover {
        transform: scale(1.06);
        box-shadow: 0 14px 36px rgba(37, 99, 235, 0.28);
    }

    .connectly-profile-avatar-fallback,
    .chatbox-profile-avatar-fallback {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2.8rem;
        color: #fff;
        background: var(--clr-gradient, linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%));
    }

    .connectly-profile-name,
    .chatbox-profile-name {
        color: var(--clr-text, #0F172A);
        font-size: 1.25rem;
        font-weight: 700;
    }

    .connectly-profile-email {
        font-size: 0.82rem;
        color: #64748b;
    }

    .connectly-profile-badge,
    .chatbox-profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #eff6ff;
        color: var(--clr-primary, #2563eb);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid #dbeafe;
    }

    /* ===== FRIEND REQUEST UI ===== */
    .connectly-friend-status-badge,
    .chatbox-friend-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        border: 1.5px solid;
        transition: all 0.25s ease;
    }

    .chatbox-friend-pending {
        background: #fffbeb;
        color: #b45309;
        border-color: #fde68a;
    }

    .chatbox-friend-accepted {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }

    .chatbox-friend-rejected {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .chatbox-friend-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .chatbox-friend-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .chatbox-friend-cancel-btn:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .chatbox-friend-reject-btn:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .chatbox-friend-unfriend-btn:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .chatbox-friend-send-again-btn:hover {
        background: #eff6ff;
        border-color: #dbeafe;
        color: var(--clr-primary, #2563eb);
    }

    /* ===== STATS ROW ===== */
    .connectly-profile-stats-row,
    .chatbox-profile-stats-row {
        display: flex;
        justify-content: center;
        gap: 2px;
        background: linear-gradient(135deg, #f8fafc, #f0f4ff);
        border-radius: 14px;
        padding: 0.75rem;
        border: 1px solid #eef2f8;
        margin: 0.5rem 0 0.2rem;
    }

    .connectly-profile-stat-item,
    .chatbox-profile-stat-item {
        flex: 1;
        text-align: center;
        padding: 0.25rem 0.5rem;
        border-right: 1px solid #e5e9f0;
    }

    .connectly-profile-stat-item:last-child,
    .chatbox-profile-stat-item:last-child {
        border-right: none;
    }

    .connectly-profile-stat-value,
    .chatbox-profile-stat-value {
        display: block;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--clr-text, #0F172A);
        line-height: 1.3;
    }

    .connectly-profile-stat-label,
    .chatbox-profile-stat-label {
        display: block;
        font-size: 0.7rem;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== DIVIDER ===== */
    .connectly-profile-divider,
    .chatbox-profile-divider {
        margin: 1.2rem 0;
        border-color: #eef2f8;
        opacity: 1;
    }

    /* ===== FORM STYLES ===== */
    .connectly-profile-form,
    .chatbox-profile-form {
        text-align: left;
    }

    .connectly-form-label,
    .chatbox-form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--clr-text, #0F172A);
        margin-bottom: 0.5rem;
    }

    .chatbox-input-group {
        position: relative;
    }

    .connectly-form-control,
    .chatbox-form-control {
        width: 100%;
        padding: 0.7rem 2.5rem 0.7rem 1rem;
        font-size: 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: var(--radius-sm, 10px);
        background: #f8fafc;
        color: var(--clr-text, #0F172A);
        transition: all 0.25s;
        outline: none;
    }

    .connectly-form-control:focus,
    .chatbox-form-control:focus {
        border-color: var(--clr-primary, #2563eb);
        background: #ffffff;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.1);
    }

    .chatbox-form-control::placeholder {
        color: #9ca3af;
    }

    .chatbox-input-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
        pointer-events: none;
    }

    .chatbox-form-control:focus ~ .chatbox-input-icon {
        color: var(--clr-primary, #2563eb);
    }

    .chatbox-invalid-feedback {
        color: #dc2626;
        font-size: 0.78rem;
        margin-top: 4px;
        font-weight: 500;
    }

    .chatbox-form-control.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }

    /* File Input */
    .connectly-file-input-wrapper,
    .chatbox-file-input-wrapper {
        position: relative;
    }

    .chatbox-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .connectly-file-label,
    .chatbox-file-label {
        display: flex;
        align-items: center;
        padding: 0.7rem 1rem;
        border: 1.5px dashed #cbd5e1;
        border-radius: var(--radius-sm, 10px);
        background: #f8fafc;
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.25s;
        cursor: pointer;
    }

    .connectly-file-label:hover,
    .chatbox-file-label:hover {
        border-color: var(--clr-primary, #2563eb);
        background: #eff6ff;
        color: var(--clr-primary, #2563eb);
    }

    .chatbox-file-input.has-file ~ .chatbox-file-label span {
        color: var(--clr-primary, #2563eb);
    }

    .chatbox-form-text {
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Checkbox */
    .chatbox-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chatbox-checkbox-input {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: 2px solid #d1d5db;
        accent-color: #dc2626;
        cursor: pointer;
    }

    .chatbox-checkbox-label {
        font-size: 0.85rem;
        color: #dc2626;
        font-weight: 500;
        cursor: pointer;
        user-select: none;
    }

    /* Buttons */
    .connectly-btn-primary,
    .chatbox-profile-page .chatbox-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0.75rem 1.5rem;
        background: var(--clr-gradient, linear-gradient(135deg, #2563eb, #1d4ed8));
        color: #fff;
        font-size: 0.9rem;
        font-weight: 600;
        border: none;
        border-radius: var(--radius-sm, 10px);
        cursor: pointer;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        text-decoration: none;
    }

    .connectly-btn-primary:hover,
    .chatbox-profile-page .chatbox-btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        color: #fff;
    }

    .connectly-btn-primary:active,
    .chatbox-profile-page .chatbox-btn-primary:active {
        transform: translateY(0);
    }

    .chatbox-btn-full {
        width: 100%;
    }

    /* ===== POSTS HEADER ===== */
    .connectly-profile-posts-header,
    .chatbox-profile-posts-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--clr-surface, #FFFFFF);
        border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
        border-radius: var(--radius-md, 16px);
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        animation: connectlyCardSlideUp 0.5s ease-out;
    }

    .connectly-posts-header-icon,
    .chatbox-posts-header-icon {
        font-size: 1.3rem;
        color: var(--clr-primary, #2563eb);
    }

    .connectly-posts-header-title {
        font-size: 1rem;
        color: var(--clr-text, #0F172A);
    }

    .connectly-posts-count-badge,
    .chatbox-posts-count-badge {
        background: #eff6ff;
        color: var(--clr-primary, #2563eb);
        font-size: 0.78rem;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid #dbeafe;
        flex-shrink: 0;
    }

    /* ===== PROFILE SEARCH BAR ===== */
    .chatbox-profile-search-form {
        display: flex;
        align-items: center;
    }

    .connectly-profile-search-group,
    .chatbox-profile-search-group {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: var(--radius-sm, 10px);
        transition: all 0.25s ease;
        width: 180px;
    }

    .connectly-profile-search-group:focus-within,
    .chatbox-profile-search-group:focus-within {
        border-color: var(--clr-primary, #2563eb);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        width: 220px;
    }

    .chatbox-profile-search-icon {
        position: absolute;
        left: 10px;
        color: #94a3b8;
        font-size: 0.82rem;
        pointer-events: none;
        transition: color 0.25s ease;
    }

    .chatbox-profile-search-group:focus-within .chatbox-profile-search-icon {
        color: var(--clr-primary, #2563eb);
    }

    .chatbox-profile-search-input {
        border: none;
        outline: none;
        padding: 0.45rem 0.75rem 0.45rem 2rem;
        font-size: 0.82rem;
        color: var(--clr-text, #0F172A);
        background: transparent;
        border-radius: 8px;
        width: 100%;
    }

    .chatbox-profile-search-input::placeholder {
        color: #94a3b8;
    }

    /* ===== PROFILE POST CARDS ===== */
    .connectly-profile-posts-container .chatbox-feed-post-card,
    .chatbox-profile-posts-container .chatbox-feed-post-card {
        padding: 1.25rem 1.35rem;
        border-radius: var(--radius-md, 16px);
        border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
        background: var(--clr-surface, #ffffff);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: connectlyCardSlideUp 0.5s ease-out backwards;
    }

    .connectly-profile-posts-container .chatbox-feed-post-card:nth-child(1) { animation-delay: 0.05s; }
    .connectly-profile-posts-container .chatbox-feed-post-card:nth-child(2) { animation-delay: 0.1s; }
    .connectly-profile-posts-container .chatbox-feed-post-card:nth-child(3) { animation-delay: 0.15s; }
    .connectly-profile-posts-container .chatbox-feed-post-card:nth-child(4) { animation-delay: 0.2s; }
    .connectly-profile-posts-container .chatbox-feed-post-card:nth-child(5) { animation-delay: 0.25s; }

    /* Blue accent bar on the left */
    .connectly-profile-posts-container .chatbox-feed-post-card::before,
    .chatbox-profile-posts-container .chatbox-feed-post-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: transparent;
        transition: background 0.3s ease;
        border-radius: 0 2px 2px 0;
    }

    .connectly-profile-posts-container .chatbox-feed-post-card:hover,
    .chatbox-profile-posts-container .chatbox-feed-post-card:hover {
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        border-color: #c7d9f0;
    }

    .connectly-profile-posts-container .chatbox-feed-post-card:hover::before,
    .chatbox-profile-posts-container .chatbox-feed-post-card:hover::before {
        background: var(--clr-primary, #2563eb);
    }

    /* Pinned post indicator */
    .connectly-profile-posts-container .chatbox-feed-post-card[data-pinned="true"],
    .chatbox-profile-posts-container .chatbox-feed-post-card[data-pinned="true"] {
        border-color: #fde68a;
        background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%);
        box-shadow: 0 6px 18px rgba(245, 158, 11, 0.08);
    }

    .connectly-profile-posts-container .chatbox-feed-post-card[data-pinned="true"]::before,
    .chatbox-profile-posts-container .chatbox-feed-post-card[data-pinned="true"]::before {
        background: #f59e0b;
    }

    /* Avatar styling within profile posts */
    .connectly-profile-posts-container .chatbox-feed-avatar,
    .chatbox-profile-posts-container .chatbox-feed-avatar {
        width: 42px;
        height: 42px;
        border: 2px solid #eef2f8;
        transition: border-color 0.3s ease, transform 0.3s ease;
        background: linear-gradient(135deg, var(--clr-primary, #2563eb) 0%, #1d4ed8 100%);
    }

    .connectly-profile-posts-container .chatbox-feed-avatar-alt,
    .chatbox-profile-posts-container .chatbox-feed-avatar-alt {
        background: linear-gradient(135deg, #64748b 0%, #334155 100%);
    }

    .connectly-profile-posts-container .chatbox-feed-post-card:hover .chatbox-feed-avatar,
    .chatbox-profile-posts-container .chatbox-feed-post-card:hover .chatbox-feed-avatar {
        border-color: #dbeafe;
        transform: scale(1.05);
    }

    .connectly-profile-posts-container .chatbox-feed-avatar-image,
    .chatbox-profile-posts-container .chatbox-feed-avatar-image {
        border-color: #eef2f8;
    }

    .connectly-profile-posts-container .chatbox-feed-post-card:hover .chatbox-feed-avatar-image,
    .chatbox-profile-posts-container .chatbox-feed-post-card:hover .chatbox-feed-avatar-image {
        border-color: #dbeafe;
    }

    /* Post text */
    .connectly-profile-posts-container .chatbox-feed-post-text,
    .chatbox-profile-posts-container .chatbox-feed-post-text {
        font-size: 0.95rem;
        line-height: 1.75;
        color: var(--clr-text, #0F172A);
    }

    /* Post image */
    .connectly-profile-posts-container .chatbox-feed-post-image,
    .chatbox-profile-posts-container .chatbox-feed-post-image {
        border-radius: var(--radius-sm, 14px);
        border: 1px solid #eef2f8;
        transition: transform 0.3s ease;
    }

    .connectly-profile-posts-container .chatbox-feed-post-card:hover .chatbox-feed-post-image,
    .chatbox-profile-posts-container .chatbox-feed-post-card:hover .chatbox-feed-post-image {
        transform: scale(1.01);
    }

    /* Buttons within profile posts */
    .connectly-profile-posts-container .btn-sm,
    .chatbox-profile-posts-container .btn-sm {
        font-size: 0.78rem;
        border-radius: var(--radius-sm, 8px);
        padding: 0.25rem 0.7rem;
        transition: all 0.25s ease;
    }

    .connectly-profile-posts-container .btn-outline-secondary,
    .chatbox-profile-posts-container .btn-outline-secondary {
        border-color: #e2e8f0;
        color: #64748b;
    }

    .connectly-profile-posts-container .btn-outline-secondary:hover,
    .chatbox-profile-posts-container .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #334155;
    }

    .connectly-profile-posts-container .btn-outline-danger:hover,
    .chatbox-profile-posts-container .btn-outline-danger:hover {
        background: #fef2f2;
    }

    .connectly-profile-posts-container .btn-outline-warning:hover,
    .chatbox-profile-posts-container .btn-outline-warning:hover {
        background: #fffbeb;
    }

    /* Name link in posts */
    .connectly-profile-posts-container .chatbox-profile-link,
    .chatbox-profile-posts-container .chatbox-profile-link {
        font-weight: 600;
        color: var(--clr-dark, #1E40AF);
        transition: color 0.25s ease;
    }

    .connectly-profile-posts-container .chatbox-profile-link:hover,
    .chatbox-profile-posts-container .chatbox-profile-link:hover {
        color: var(--clr-primary, #2563eb);
    }

    /* ===== PINNED BADGE ===== */
    .chatbox-pinned-badge {
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
        animation: chatboxPinnedFadeIn 0.4s ease;
    }

    @keyframes chatboxPinnedFadeIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* ===== REACTION PICKER (POST) ===== */
    .chatbox-reaction-picker {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .chatbox-reaction-options {
        position: absolute;
        left: 0;
        bottom: calc(100% + 4px);
        display: flex;
        gap: 0.35rem;
        padding: 0.35rem 0.45rem;
        background: #ffffff;
        border: 1px solid #dbe4ef;
        border-radius: 999px;
        box-shadow: 0 12px 25px rgba(15, 23, 42, 0.12);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(8px);
        transition: opacity 0.18s ease, transform 0.18s ease;
        z-index: 25;
    }

    .chatbox-reaction-options::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -12px;
        height: 12px;
    }

    .chatbox-reaction-picker:hover .chatbox-reaction-options,
    .chatbox-reaction-picker:focus-within .chatbox-reaction-options,
    .chatbox-reaction-options:hover {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0);
    }

    .chatbox-reaction-option {
        border: none;
        background: transparent;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        font-size: 1.05rem;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    .chatbox-reaction-option:hover {
        transform: scale(1.18);
        background: #eff6ff;
    }

    .chatbox-reaction-option.active {
        background: #dbeafe;
    }

    /* ===== COMMENT MODAL ===== */
    .chatbox-comment-item {
        padding: 0.75rem;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .chatbox-comment-replies {
        margin-left: 1rem;
        padding-left: 0.9rem;
        border-left: 2px solid #dbe4ef;
    }

    .chatbox-comment-reply-item {
        padding: 0.65rem;
        border-radius: 10px;
        border: 1px solid #dde7f2;
        background: #fdfefe;
    }

    .chatbox-comment-image {
        width: 100%;
        max-width: 320px;
        max-height: 260px;
        object-fit: cover;
        border: 1px solid #dbe4ef;
    }

    /* ===== COMMENT REACTION PICKER ===== */
    .chatbox-comment-reaction-picker {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .chatbox-comment-reaction-options {
        position: absolute;
        left: 0;
        bottom: calc(100% + 4px);
        display: flex;
        gap: 0.35rem;
        padding: 0.35rem 0.45rem;
        background: #ffffff;
        border: 1px solid #dbe4ef;
        border-radius: 999px;
        box-shadow: 0 12px 25px rgba(15, 23, 42, 0.12);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(8px);
        transition: opacity 0.18s ease, transform 0.18s ease;
        z-index: 35;
    }

    .chatbox-comment-reaction-options::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -12px;
        height: 12px;
    }

    .chatbox-comment-reaction-picker:hover .chatbox-comment-reaction-options,
    .chatbox-comment-reaction-picker:focus-within .chatbox-comment-reaction-options,
    .chatbox-comment-reaction-options:hover {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0);
    }

    .chatbox-comment-reaction-option {
        border: none;
        background: transparent;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        font-size: 1rem;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    .chatbox-comment-reaction-option:hover {
        transform: scale(1.18);
        background: #eff6ff;
    }

    .chatbox-comment-reaction-option.active {
        background: #dbeafe;
    }

    /* ===== COMMENT MODAL ENHANCEMENTS ===== */
    .connectly-profile-posts-container .modal-content,
    .chatbox-profile-posts-container .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.15);
    }

    .connectly-profile-posts-container .modal-header,
    .chatbox-profile-posts-container .modal-header {
        border-bottom: 1px solid #eef2f8;
        padding: 1rem 1.25rem;
        background: #f8fafc;
        border-radius: 20px 20px 0 0;
    }

    .connectly-profile-posts-container .modal-header .modal-title,
    .chatbox-profile-posts-container .modal-header .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--clr-text, #0F172A);
    }

    .connectly-profile-posts-container .modal-body,
    .chatbox-profile-posts-container .modal-body {
        padding: 1.25rem;
    }

    .connectly-profile-posts-container .modal-footer,
    .chatbox-profile-posts-container .modal-footer {
        border-top: 1px solid #eef2f8;
        padding: 0.75rem 1.25rem;
    }

    .connectly-profile-posts-container .modal-dialog-scrollable .modal-body,
    .chatbox-profile-posts-container .modal-dialog-scrollable .modal-body {
        max-height: 70vh;
    }

    /* Comment form styling */
    .connectly-profile-posts-container .modal-body textarea.form-control,
    .chatbox-profile-posts-container .modal-body textarea.form-control {
        border-radius: var(--radius-md, 12px);
        border: 1.5px solid #e2e8f0;
        resize: none;
        font-size: 0.88rem;
        transition: all 0.25s ease;
    }

    .connectly-profile-posts-container .modal-body textarea.form-control:focus,
    .chatbox-profile-posts-container .modal-body textarea.form-control:focus {
        border-color: var(--clr-primary, #2563eb);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .connectly-profile-posts-container .modal-body .btn-primary,
    .connectly-profile-posts-container .chatbox-comment-submit-btn,
    .chatbox-profile-posts-container .modal-body .btn-primary,
    .chatbox-profile-posts-container .chatbox-comment-submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1.25rem;
        background: var(--clr-gradient, linear-gradient(135deg, #2563eb, #1d4ed8));
        color: #fff;
        font-size: 0.85rem;
        font-weight: 600;
        border: none;
        border-radius: var(--radius-sm, 10px);
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .connectly-profile-posts-container .modal-body .btn-primary:hover,
    .connectly-profile-posts-container .chatbox-comment-submit-btn:hover,
    .chatbox-profile-posts-container .modal-body .btn-primary:hover,
    .chatbox-profile-posts-container .chatbox-comment-submit-btn:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        color: #fff;
    }

    .connectly-profile-posts-container .modal-body .btn-primary:active,
    .connectly-profile-posts-container .chatbox-comment-submit-btn:active,
    .chatbox-profile-posts-container .modal-body .btn-primary:active,
    .chatbox-profile-posts-container .chatbox-comment-submit-btn:active {
        transform: translateY(0);
    }

    /* Reply indicator styling */
    .connectly-profile-posts-container .chatbox-reply-indicator,
    .chatbox-profile-posts-container .chatbox-reply-indicator {
        border-radius: var(--radius-sm, 10px);
        font-size: 0.82rem;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: var(--clr-dark, #1e40af);
    }

    /* Comment reaction badge text */
    .connectly-profile-posts-container .chatbox-reaction-badge-emoji,
    .connectly-profile-posts-container .chatbox-comment-reaction-badge-emoji,
    .chatbox-profile-posts-container .chatbox-reaction-badge-emoji,
    .chatbox-profile-posts-container .chatbox-comment-reaction-badge-emoji {
        font-size: 0.75rem;
    }

    .connectly-profile-posts-container .chatbox-reaction-badge-count,
    .connectly-profile-posts-container .chatbox-comment-reaction-badge-count,
    .chatbox-profile-posts-container .chatbox-reaction-badge-count,
    .chatbox-profile-posts-container .chatbox-comment-reaction-badge-count {
        font-size: 0.68rem;
        font-weight: 600;
    }

    /* Comment cards hover effect */
    .connectly-profile-posts-container .chatbox-comment-item:hover,
    .chatbox-profile-posts-container .chatbox-comment-item:hover {
        border-color: #d1dff0;
        transition: border-color 0.2s ease;
    }

    .connectly-profile-posts-container .chatbox-comment-reply-item:hover,
    .chatbox-profile-posts-container .chatbox-comment-reply-item:hover {
        border-color: #cbddee;
        transition: border-color 0.2s ease;
    }

    /* File input in comment form */
    .connectly-profile-posts-container .modal-body input[type="file"].form-control,
    .chatbox-profile-posts-container .modal-body input[type="file"].form-control {
        font-size: 0.82rem;
        padding: 0.4rem 0.7rem;
        border-radius: var(--radius-sm, 8px);
        border: 1.5px solid #e2e8f0;
    }

    /* ===== EMPTY STATE ===== */
    .connectly-profile-empty-state,
    .chatbox-profile-empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: var(--clr-surface, #ffffff);
        border: 1px solid var(--clr-border, rgba(37, 99, 235, 0.08));
        border-radius: var(--radius-md, 16px);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        animation: connectlyCardSlideUp 0.5s ease-out;
    }

    .connectly-profile-empty-icon,
    .chatbox-profile-empty-icon {
        width: 64px;
        height: 64px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        border-radius: 50%;
        font-size: 1.6rem;
        color: var(--clr-primary, #2563eb);
        margin-bottom: 1rem;
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 767.98px) {
        .connectly-profile-avatar,
        .chatbox-profile-avatar {
            width: 100px;
            height: 100px;
        }

        .connectly-profile-avatar-fallback,
        .chatbox-profile-avatar-fallback {
            font-size: 2.2rem;
        }

        .connectly-profile-card,
        .chatbox-profile-card {
            padding: 1.25rem;
        }

        .connectly-profile-stats-row,
        .chatbox-profile-stats-row {
            padding: 0.5rem;
        }

        .connectly-profile-stat-value,
        .chatbox-profile-stat-value {
            font-size: 1rem;
        }

        .connectly-profile-posts-container .chatbox-feed-post-card,
        .chatbox-profile-posts-container .chatbox-feed-post-card {
            padding: 1rem;
            border-radius: var(--radius-md, 14px);
        }
    }

    @media (max-width: 575.98px) {
        .connectly-profile-posts-header,
        .chatbox-profile-posts-header {
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }

        .connectly-profile-search-group,
        .chatbox-profile-search-group {
            width: 100%;
            max-width: 100%;
        }

        .connectly-profile-search-group:focus-within,
        .chatbox-profile-search-group:focus-within {
            width: 100%;
        }
    }

    /* ===== TOAST NOTIFICATION ===== */
    .chatbox-toast-popup {
        border-radius: var(--radius-md, 12px) !important;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12) !important;
        font-family: inherit !important;
    }

    .chatbox-toast-popup .swal2-title {
        font-size: 0.88rem !important;
        font-weight: 500 !important;
        color: var(--clr-text, #0F172A) !important;
    }

    .chatbox-toast-popup .swal2-timer-progress-bar {
        background: #dbeafe !important;
        height: 3px !important;
    }

    .chatbox-toast-popup.swal2-icon-success {
        border-left: 4px solid #10b981 !important;
    }

    .chatbox-toast-popup.swal2-icon-error {
        border-left: 4px solid #ef4444 !important;
    }
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
