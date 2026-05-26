@extends('frontend.app')

@section('content')
<div class="chatbox-friends-page">
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show chatbox-friends-alert" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="chatbox-friends-header">
            <div class="d-flex align-items-center gap-3">
                <div class="chatbox-friends-header-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Friends</h4>
                    <p class="text-muted small mb-0">Manage your connections</p>
                </div>
            </div>
            <div class="chatbox-friends-header-stats">
                <span class="chatbox-friends-stat-badge">
                    <i class="bi bi-person-check me-1"></i>
                    {{ $friends->count() }} friends
                </span>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <!-- Incoming Requests -->
            @if($incomingRequests->isNotEmpty())
            <div class="col-12">
                <div class="chatbox-friends-section-card">
                    <div class="chatbox-friends-section-title">
                        <i class="bi bi-person-plus-fill text-warning me-2"></i>
                        Friend Requests
                        <span class="chatbox-friends-request-count">{{ $incomingRequests->count() }}</span>
                    </div>
                    <div class="chatbox-friends-grid">
                        @foreach($incomingRequests as $request)
                            @php $requester = $request->sender; @endphp
                            <div class="chatbox-friend-card chatbox-friend-request-card">
                                <a href="{{ route('profile.show', $requester->id) }}" class="chatbox-friend-avatar-link">
                                    @if ($requester->avatar_path)
                                        <img src="{{ route('media.show', ['path' => $requester->avatar_path]) }}"
                                             alt="{{ $requester->name }}" class="chatbox-friend-avatar">
                                    @else
                                        <div class="chatbox-friend-avatar chatbox-friend-avatar-fallback">
                                            {{ strtoupper(substr($requester->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                                <div class="chatbox-friend-info">
                                    <a href="{{ route('profile.show', $requester->id) }}" class="chatbox-friend-name">
                                        {{ $requester->name }}
                                    </a>
                                    <span class="chatbox-friend-email">{{ $requester->email }}</span>
                                </div>
                                <div class="chatbox-friend-actions">
                                    <form action="{{ route('friend-request.accept', $request->id) }}" method="POST" class="chatbox-fr-accept-form" data-requester-name="{{ $requester->name }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="chatbox-fr-btn chatbox-fr-accept-btn" title="Accept">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('friend-request.reject', $request->id) }}" method="POST" class="chatbox-fr-reject-form" data-requester-name="{{ $requester->name }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="chatbox-fr-btn chatbox-fr-reject-btn" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Outgoing Requests -->
            @if($outgoingRequests->isNotEmpty())
            <div class="col-12">
                <div class="chatbox-friends-section-card">
                    <div class="chatbox-friends-section-title">
                        <i class="bi bi-send-fill text-info me-2"></i>
                        Sent Requests
                        <span class="chatbox-friends-request-count">{{ $outgoingRequests->count() }}</span>
                    </div>
                    <div class="chatbox-friends-grid">
                        @foreach($outgoingRequests as $request)
                            @php $sentTo = $request->receiver; @endphp
                            <div class="chatbox-friend-card chatbox-friend-pending-card">
                                <a href="{{ route('profile.show', $sentTo->id) }}" class="chatbox-friend-avatar-link">
                                    @if ($sentTo->avatar_path)
                                        <img src="{{ route('media.show', ['path' => $sentTo->avatar_path]) }}"
                                             alt="{{ $sentTo->name }}" class="chatbox-friend-avatar">
                                    @else
                                        <div class="chatbox-friend-avatar chatbox-friend-avatar-fallback">
                                            {{ strtoupper(substr($sentTo->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                                <div class="chatbox-friend-info">
                                    <a href="{{ route('profile.show', $sentTo->id) }}" class="chatbox-friend-name">
                                        {{ $sentTo->name }}
                                    </a>
                                    <span class="chatbox-friend-email">{{ $sentTo->email }}</span>
                                </div>
                                <span class="chatbox-fr-status-badge">
                                    <i class="bi bi-hourglass-split me-1"></i> Pending
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Accepted Friends -->
            <div class="col-12">
                <div class="chatbox-friends-section-card">
                    <div class="chatbox-friends-section-title">
                        <i class="bi bi-people-fill text-success me-2"></i>
                        All Friends
                        <span class="chatbox-friends-count-badge">{{ $friends->count() }}</span>
                    </div>

                    @if($friends->isNotEmpty())
                        <div class="chatbox-friends-grid">
                            @foreach($friends as $friend)
                                <div class="chatbox-friend-card">
                                    <a href="{{ route('profile.show', $friend->id) }}" class="chatbox-friend-avatar-link">
                                        @if ($friend->avatar_path)
                                            <img src="{{ route('media.show', ['path' => $friend->avatar_path]) }}"
                                                 alt="{{ $friend->name }}" class="chatbox-friend-avatar">
                                        @else
                                            <div class="chatbox-friend-avatar chatbox-friend-avatar-fallback">
                                                {{ strtoupper(substr($friend->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </a>
                                    <div class="chatbox-friend-info">
                                        <a href="{{ route('profile.show', $friend->id) }}" class="chatbox-friend-name">
                                            {{ $friend->name }}
                                        </a>
                                        <span class="chatbox-friend-email">{{ $friend->email }}</span>
                                    </div>
                                    <div class="chatbox-friend-actions">
                                        <a href="{{ route('message', $friend->id) }}"
                                           class="chatbox-fr-btn chatbox-fr-message-btn" title="Send Message">
                                            <i class="bi bi-chat-dots-fill"></i>
                                        </a>
                                        <a href="{{ route('profile.show', $friend->id) }}"
                                           class="chatbox-fr-btn chatbox-fr-profile-btn" title="View Profile">
                                            <i class="bi bi-person"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="chatbox-friends-empty">
                            <div class="chatbox-friends-empty-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h6 class="fw-bold mb-1">No friends yet</h6>
                            <p class="text-muted small mb-0">
                                Search for people and send them friend requests to connect!
                            </p>
                            <a href="{{ route('search') }}" class="chatbox-btn-primary mt-3" style="display: inline-flex;">
                                <i class="bi bi-search me-1"></i> Find People
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== FRIENDS PAGE STYLES ===== */
    .chatbox-friends-page {
        min-height: 100%;
        background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
        padding-bottom: 2rem;
    }

    /* Alert */
    .chatbox-friends-alert {
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border-left: 4px solid #10b981;
        color: #065f46;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        animation: chatboxFriendsSlideDown 0.4s ease;
    }

    @keyframes chatboxFriendsSlideDown {
        from { transform: translateY(-10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* ===== HEADER ===== */
    .chatbox-friends-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        border: 1px solid #e3ebf4;
        border-radius: 18px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.05);
    }

    .chatbox-friends-header-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border-radius: 14px;
        font-size: 1.5rem;
        color: #fff;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
    }

    .chatbox-friends-header-stats {
        display: flex;
        gap: 8px;
    }

    .chatbox-friends-stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #ecfdf5;
        color: #047857;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 20px;
        border: 1px solid #a7f3d0;
    }

    /* ===== SECTION CARDS ===== */
    .chatbox-friends-section-card {
        background: #ffffff;
        border: 1px solid #e3ebf4;
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        transition: box-shadow 0.3s ease;
    }

    .chatbox-friends-section-card:hover {
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .chatbox-friends-section-title {
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1.5px solid #eef2f8;
    }

    .chatbox-friends-request-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fef3c7;
        color: #b45309;
        font-size: 0.72rem;
        font-weight: 700;
        min-width: 22px;
        height: 22px;
        border-radius: 20px;
        padding: 0 8px;
        margin-left: 8px;
        border: 1px solid #fde68a;
    }

    .chatbox-friends-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ecfdf5;
        color: #047857;
        font-size: 0.72rem;
        font-weight: 700;
        min-width: 22px;
        height: 22px;
        border-radius: 20px;
        padding: 0 8px;
        margin-left: 8px;
        border: 1px solid #a7f3d0;
    }

    /* ===== FRIENDS GRID ===== */
    .chatbox-friends-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 12px;
    }

    /* ===== FRIEND CARD ===== */
    .chatbox-friend-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.85rem 1rem;
        background: #f8fafc;
        border: 1px solid #eef2f8;
        border-radius: 14px;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .chatbox-friend-card::before {
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

    .chatbox-friend-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.07);
        border-color: #d1dff0;
        background: #ffffff;
    }

    .chatbox-friend-card:hover::before {
        background: #2563eb;
    }

    .chatbox-friend-request-card::before {
        background: #f59e0b;
    }

    .chatbox-friend-pending-card::before {
        background: #3b82f6;
    }

    /* Avatar */
    .chatbox-friend-avatar-link {
        flex-shrink: 0;
        text-decoration: none;
    }

    .chatbox-friend-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid #eef2f8;
        transition: all 0.3s ease;
    }

    .chatbox-friend-card:hover .chatbox-friend-avatar {
        border-color: #dbeafe;
        transform: scale(1.05);
    }

    .chatbox-friend-avatar-fallback {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        color: #fff;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Info */
    .chatbox-friend-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .chatbox-friend-name {
        font-weight: 600;
        font-size: 0.92rem;
        color: #1f2937;
        text-decoration: none;
        transition: color 0.25s ease;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chatbox-friend-name:hover {
        color: #2563eb;
    }

    .chatbox-friend-email {
        font-size: 0.75rem;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Actions */
    .chatbox-friend-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }

    .chatbox-fr-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .chatbox-fr-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }

    .chatbox-fr-accept-btn:hover {
        background: #ecfdf5;
        border-color: #a7f3d0;
        color: #059669;
    }

    .chatbox-fr-reject-btn:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .chatbox-fr-message-btn:hover {
        background: #eff6ff;
        border-color: #dbeafe;
        color: #2563eb;
    }

    .chatbox-fr-profile-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    /* Pending badge for outgoing */
    .chatbox-fr-status-badge {
        display: inline-flex;
        align-items: center;
        font-size: 0.7rem;
        font-weight: 600;
        color: #b45309;
        background: #fffbeb;
        border: 1px solid #fde68a;
        padding: 3px 10px;
        border-radius: 20px;
        flex-shrink: 0;
        white-space: nowrap;
    }

    /* ===== EMPTY STATE ===== */
    .chatbox-friends-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .chatbox-friends-empty-icon {
        width: 64px;
        height: 64px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        border-radius: 50%;
        font-size: 1.6rem;
        color: #2563eb;
        margin-bottom: 1rem;
    }

    .chatbox-friends-page .chatbox-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        font-size: 0.85rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.28s;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        text-decoration: none;
    }

    .chatbox-friends-page .chatbox-btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        color: #fff;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767.98px) {
        .chatbox-friends-header {
            flex-direction: column;
            gap: 12px;
            text-align: center;
            padding: 1rem;
        }

        .chatbox-friends-grid {
            grid-template-columns: 1fr;
        }

        .chatbox-friend-card {
            padding: 0.7rem 0.85rem;
        }

        .chatbox-friends-section-card {
            padding: 1rem;
        }
    }
</style>

<script>
    // ===== SWEET ALERT + AJAX BEFORE ACCEPT FRIEND REQUEST =====
    document.addEventListener('submit', function(e) {
        const acceptForm = e.target.closest('.chatbox-fr-accept-form');
        if (!acceptForm) return;

        e.preventDefault();

        const requesterName = acceptForm.dataset.requesterName || 'this user';

        Swal.fire({
            title: 'Accept Request?',
            text: `You will become friends with ${requesterName}.`,
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
                // Remove the friend card from the DOM
                const card = acceptForm.closest('.chatbox-friend-request-card');
                if (card) {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => card.remove(), 300);
                }

                // Update incoming request count
                const requestCountBadge = document.querySelector('.chatbox-friends-request-count');
                if (requestCountBadge) {
                    const current = parseInt(requestCountBadge.textContent, 10) || 0;
                    const next = Math.max(0, current - 1);
                    requestCountBadge.textContent = next;
                    // If no more requests, hide the whole section
                    if (next <= 0) {
                        const section = requestCountBadge.closest('.chatbox-friends-section-card');
                        if (section) {
                            section.style.transition = 'all 0.3s ease';
                            section.style.opacity = '0';
                            setTimeout(() => section.remove(), 300);
                        }
                    }
                }

                // Update friends count in "All Friends" section
                const friendsCountBadge = document.querySelector('.chatbox-friends-count-badge');
                if (friendsCountBadge) {
                    const current = parseInt(friendsCountBadge.textContent, 10) || 0;
                    friendsCountBadge.textContent = current + 1;
                }

                // Update friends count in header stat
                const headerStatBadge = document.querySelector('.chatbox-friends-stat-badge');
                if (headerStatBadge) {
                    const match = headerStatBadge.textContent.match(/[\d,]+/);
                    const current = match ? parseInt(match[0].replace(/,/g, ''), 10) : 0;
                    headerStatBadge.innerHTML = `<i class="bi bi-person-check me-1"></i> ${current + 1} friends`;
                }

                chatboxFriendsToast('success', `Accepted ${requesterName}'s request`);
            }
        });
    });

    // ===== SWEET ALERT + AJAX BEFORE REJECT FRIEND REQUEST =====
    document.addEventListener('submit', function(e) {
        const rejectForm = e.target.closest('.chatbox-fr-reject-form');
        if (!rejectForm) return;

        e.preventDefault();

        const requesterName = rejectForm.dataset.requesterName || 'this user';

        Swal.fire({
            title: 'Reject Request?',
            text: `The friend request from ${requesterName} will be rejected.`,
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
                // Remove the friend card from the DOM
                const card = rejectForm.closest('.chatbox-friend-request-card');
                if (card) {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => card.remove(), 300);
                }

                // Update incoming request count
                const requestCountBadge = document.querySelector('.chatbox-friends-request-count');
                if (requestCountBadge) {
                    const current = parseInt(requestCountBadge.textContent, 10) || 0;
                    const next = Math.max(0, current - 1);
                    requestCountBadge.textContent = next;
                    // If no more requests, hide the whole section
                    if (next <= 0) {
                        const section = requestCountBadge.closest('.chatbox-friends-section-card');
                        if (section) {
                            section.style.transition = 'all 0.3s ease';
                            section.style.opacity = '0';
                            setTimeout(() => section.remove(), 300);
                        }
                    }
                }

                chatboxFriendsToast('success', `Rejected ${requesterName}'s request`);
            }
        });
    });

    // ===== TOAST HELPER =====
    function chatboxFriendsToast(icon, title) {
        if (typeof Swal === 'undefined') {
            console.warn('SweetAlert2 not loaded');
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
</script>

<style>
    /* Toast styling for friends page */
    .chatbox-toast-popup {
        border-radius: 12px !important;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12) !important;
        font-family: inherit !important;
    }

    .chatbox-toast-popup .swal2-title {
        font-size: 0.88rem !important;
        font-weight: 500 !important;
        color: #1f2937 !important;
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
@endsection
