@php
use Illuminate\Support\Str;
use App\Models\Message;

$activeUserId = request()->route('user_id') !== null ? (string) request()->route('user_id') : null;
$isChatPage = request()->routeIs('message');
$isLandingPage = request()->is('/') || request()->is('contact');
$isProfilePage = request()->routeIs('profile.show');
$isFeedOrProfile = request()->is('feed') || request()->routeIs('profile.show');
$isPostEdit = request()->routeIs('feed.posts.edit');
$isPostComments = request()->routeIs('feed.posts.comments');
$isFriendsOrSearch = request()->routeIs('friends') || request()->routeIs('search');
$isLegalPage = in_array(request()->path(), ['privacy', 'terms', 'cookies', 'gdpr']);
@endphp

<!-- Top Bar -->
<nav class="navbar navbar-expand-lg chatbox-top-navbar py-2">
    <div class="container-fluid">
        <a class="navbar-brand chatbox-brand-link d-flex align-items-center gap-2" href="/">
            <div class="chatbox-brand-icon-wrap">
                <i class="bi bi-diagram-3-fill chatbox-brand-icon"></i>
            </div>
            <span class="chatbox-brand-text">Connectly</span>
        </a>

        <button class="navbar-toggler chatbox-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopNav"
                aria-controls="navbarTopNav" aria-expanded="false" aria-label="Toggle navigation">
            <div class="chatbox-toggler-icon-wrap">
                <span class="chatbox-toggler-bar"></span>
                <span class="chatbox-toggler-bar"></span>
                <span class="chatbox-toggler-bar"></span>
            </div>
        </button>

        <div class="collapse navbar-collapse" id="navbarTopNav">
            <!-- Center: main navigation items -->
            <ul class="navbar-nav justify-content-center gap-1 gap-lg-2 mx-auto chatbox-mobile-nav-items">
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ request()->is('/') ? 'active-navlink-chatbox' : '' }}" href="/">
                        <i class="bi bi-house-door"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ request()->is('feed') ? 'active-navlink-chatbox' : '' }}" href="/feed">
                        <i class="bi bi-rss-fill"></i>
                        <span>Feed</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ $isProfilePage ? 'active-navlink-chatbox' : '' }}" href="{{ auth()->check() ? route('profile.show', auth()->id()) : '/login' }}">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ request()->routeIs('friends') ? 'active-navlink-chatbox' : '' }}" href="{{ route('friends') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Friends</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ $isChatPage ? 'active-navlink-chatbox' : '' }}" href="{{ route('message', auth()->id()) }}">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <!-- Notification Bell -->
                <li class="nav-item dropdown" id="chatboxNotificationDropdown">
                    <a class="nav-link chatbox-navlink-top chatbox-notif-bell" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="notifDropdownToggle" title="Notifications">
                        <i class="bi bi-bell-fill"></i>
                        <span class="d-none d-lg-inline">Notifications</span>
                        <span class="chatbox-notif-badge d-none" id="notifBadge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end chatbox-notif-dropdown" aria-labelledby="notifDropdownToggle">
                        <div class="chatbox-notif-header">
                            <span class="fw-bold">Notifications</span>
                            <button class="btn btn-sm btn-link chatbox-notif-mark-all d-none" id="markAllReadBtn" type="button">
                                Mark all as read
                            </button>
                        </div>
                        <div class="chatbox-notif-list" id="notifList">
                            <div class="chatbox-notif-loading text-center py-4">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('friends') }}" class="chatbox-notif-footer">
                            View all friend requests
                        </a>
                    </div>
                </li>
                @if(auth()->user()->is_admin == 1)
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ Str::startsWith(request()->path(), 'admin') ? 'active-navlink-chatbox' : '' }}" href="/admin">
                        <i class="bi bi-speedometer2"></i>
                        <span>Admin</span>
                    </a>
                </li>
                @endif
                @endauth
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top {{ request()->is('contact') ? 'active-navlink-chatbox' : '' }}" href="/contact">
                        <i class="bi bi-envelope"></i>
                        <span>Contact</span>
                    </a>
                </li>
            </ul>

            <!-- Right: auth actions (login/signup or logout) -->
            <ul class="navbar-nav align-items-center gap-2 flex-shrink-0 chatbox-auth-right">
                @auth
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link chatbox-navlink-top chatbox-logout-btn border-0">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link chatbox-navlink-top chatbox-login-link {{ request()->is('login') ? 'active-navlink-chatbox' : '' }}" href="/login">
                        <i class="bi bi-person-circle"></i>
                        <span>Login</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link chatbox-signup-button" href="/register">
                        <i class="bi bi-person-plus"></i>
                        <span>Signup</span>
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if($isChatPage)
<script>document.documentElement.classList.add('chatbox-message-active');</script>
@endif

<!-- Sidebar + Content -->
<div class="row m-0 chatbox-main-layout-row {{ $isLandingPage ? 'chatbox-layout-landing' : '' }} {{ $isFeedOrProfile || $isPostEdit || $isPostComments ? 'chatbox-layout-feed-profile' : '' }} {{ $isChatPage ? 'chatbox-layout-message' : '' }}">
    @unless($isLandingPage || $isFeedOrProfile || $isPostEdit || $isPostComments || $isFriendsOrSearch || $isLegalPage)
    <div class="col-md-3 p-0">
        <div class="chatbox-sidebar-container">

            <!-- Search -->
            <div class="chatbox-search-wrapper px-3 mb-3">
                <div class="chatbox-search-input-box">
                    <i class="bi bi-search chatbox-search-icon"></i>
                    <input type="text" id="userSearch" class="form-control chatbox-search-field" placeholder="Search by Gmail...">
                    <div id="searchResult" class="chatbox-search-results-dropdown"></div>
                </div>
            </div>

            <ul class="chatbox-sidebar-user-list">

                @auth
                    <!-- My Account -->
                    <li class="ps-3 text-muted chatbox-section-label">My Account</li>
                    <li class="chatbox-user-list-item">
                        <a href="{{ route('message', auth()->id()) }}"
                           class="chatbox-user-link {{ $activeUserId === (string) auth()->id() ? 'active-user-chatbox' : '' }}">
                            
                            <div class="chatbox-user-avatar-wrapper">
                                <i class="bi bi-person-circle chatbox-user-avatar-icon"></i>
                                <span class="chatbox-online-indicator"></span>
                            </div>

                            <div class="chatbox-user-info">
                                <span class="chatbox-user-name">{{ auth()->user()->name }} (You)</span>
                                <span class="chatbox-user-status">Active now</span>
                            </div>
                        </a>
                    </li>

                    <!-- Recent Chats -->
                    <li class="mt-3 ps-3 text-muted chatbox-section-label">Recent Chats</li>

                    @php
                        $chattedUserIds = Message::conversationPartnerIdsFor((int) auth()->id());
                        $users = \App\Models\User::whereIn('id', $chattedUserIds)->orderBy('name')->get();
                    @endphp

                    @foreach($users as $user)
                        <li class="chatbox-user-list-item user-item"
                            data-name="{{ strtolower($user->name) }}"
                            data-email="{{ strtolower($user->email) }}">

                            <a href="{{ route('message', $user->id) }}"
                               class="chatbox-user-link {{ $activeUserId === (string) $user->id ? 'active-user-chatbox' : '' }}">

                                <div class="chatbox-user-avatar-wrapper">
                                    <i class="bi bi-person chatbox-user-avatar-icon"></i>
                                </div>

                                <div class="chatbox-user-info">
                                    <span class="chatbox-user-name">{{ $user->name }}</span>
                                    <span class="chatbox-user-status">{{ $user->email }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach

                @else
                    <li class="chatbox-user-list-item">
                        <a href="{{ route('login') }}" class="chatbox-user-link active-user-chatbox">
                            <div class="chatbox-user-info">
                                <span class="chatbox-user-name">Guest — Login to chat</span>
                            </div>
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
    @endunless

    <!-- Content -->
    <div class="{{ $isLandingPage || $isFeedOrProfile || $isPostEdit || $isPostComments || $isFriendsOrSearch || $isLegalPage ? 'col-12' : 'col-md-9' }} p-0 {{ $isChatPage ? 'chatbox-chat-page-column' : 'chatbox-content-area' }}">
        @yield('content')
    </div>
</div>

<!-- Notification Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifBell = document.getElementById('chatboxNotificationDropdown');
    const notifBadge = document.getElementById('notifBadge');
    const notifList = document.getElementById('notifList');
    const markAllBtn = document.getElementById('markAllReadBtn');
    const notifToggle = document.getElementById('notifDropdownToggle');

    if (!notifBell) return;

    const notifFetchUrl = '{{ route("notifications.fetch") }}';
    const notifSseUrl = '{{ route("notifications.stream") }}';
    const notifReadUrl = '{{ route("notifications.read", ["id" => "___NOTIF_ID___"]) }}';
    const markAllUrl = '{{ route("notifications.mark-all-read") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const mediaUrlPrefix = '{{ route("media.show", ["path" => "___MEDIA_PATH___"]) }}';

    // ====== Notification Sound via Web Audio API ======
    let audioCtx = null;

    function playNotifSound() {
        // Don't play if page is hidden/minimized
        if (document.hidden) return;

        try {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }

            // Create a pleasant two-tone chime
            const oscillator = audioCtx.createOscillator();
            const gain = audioCtx.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(523.25, audioCtx.currentTime);      // C5
            oscillator.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1); // E5

            gain.gain.setValueAtTime(0.15, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.25);

            oscillator.connect(gain);
            gain.connect(audioCtx.destination);

            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + 0.25);
        } catch (e) {
            // Audio not supported — silently ignore
        }
    }

    // ====== SSE: Real-time updates via EventSource ======
    let eventSource = null;
    let prevUnreadCount = Infinity; // Prevents sound on initial load for existing notifications

    function connectSSE() {
        // Close any existing connection
        if (eventSource) {
            eventSource.close();
        }

        eventSource = new EventSource(notifSseUrl);

        eventSource.addEventListener('notification', function (e) {
            try {
                const data = JSON.parse(e.data);
                updateBadge(data.unread_count);

                // If count increased: shake bell + play sound
                if (data.unread_count > prevUnreadCount) {
                    // Shake bell
                    notifToggle?.classList.add('chatbox-notif-shake');
                    setTimeout(() => {
                        notifToggle?.classList.remove('chatbox-notif-shake');
                    }, 600);

                    // Play sound
                    playNotifSound();
                }
                prevUnreadCount = data.unread_count;

                // Update dropdown content only if it's open
                if (notifBell.classList.contains('show')) {
                    renderNotifications(data.notifications);
                }
            } catch (err) {
                console.warn('SSE parse error', err);
            }
        });

        eventSource.onerror = function () {
            // Connection lost — retry after 5 seconds
            if (eventSource) {
                eventSource.close();
            }
            setTimeout(connectSSE, 5000);
        };
    }

    // Connect to SSE on page load
    connectSSE();

    // ====== Regular fetch (for dropdown open & initial) ======
    function fetchNotifications() {
        fetch(notifFetchUrl, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            updateBadge(data.unread_count);
            renderNotifications(data.notifications);
        })
        .catch(() => {});
    }

    function updateBadge(count) {
        if (count > 0) {
            notifBadge.textContent = count > 99 ? '99+' : count;
            notifBadge.classList.remove('d-none');
        } else {
            notifBadge.classList.add('d-none');
        }
    }

    function renderNotifications(notifications) {
        if (!notifications.length) {
            notifList.innerHTML = `
                <div class="chatbox-notif-empty">
                    <i class="bi bi-bell-slash"></i>
                    <p class="mb-0 small text-muted">No notifications</p>
                </div>
            `;
            markAllBtn.classList.add('d-none');
            return;
        }

        const hasUnread = notifications.some(n => !n.is_read);
        markAllBtn.classList.toggle('d-none', !hasUnread);

        notifList.innerHTML = notifications.map(n => {
            const avatarHtml = n.from_user && n.from_user.avatar_path
                ? `<img src="${mediaUrlPrefix.replace('___MEDIA_PATH___', n.from_user.avatar_path)}" alt="${escapeHtml(n.from_user.name)}" class="chatbox-notif-avatar-img">`
                : `<div class="chatbox-notif-avatar-fallback">${n.from_user ? escapeHtml(n.from_user.name.charAt(0).toUpperCase()) : '?'}</div>`;

            return `
                <div class="chatbox-notif-item ${n.is_read ? '' : 'chatbox-notif-unread'}" data-id="${n.id}">
                    <a href="${n.link}" class="chatbox-notif-link" onclick="markNotifRead(${n.id})">
                        <div class="chatbox-notif-avatar">
                            ${avatarHtml}
                        </div>
                        <div class="chatbox-notif-content">
                            <p class="chatbox-notif-text mb-0">${escapeHtml(n.message)}</p>
                            <small class="chatbox-notif-time">${escapeHtml(n.time)}</small>
                        </div>
                        ${n.is_read ? '' : '<span class="chatbox-notif-dot"></span>'}
                    </a>
                </div>
            `;
        }).join('');
    }

    window.markNotifRead = function(id) {
        fetch(notifReadUrl.replace('___NOTIF_ID___', id), {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            keepalive: true,
        }).catch(() => {});
    };

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    // Mark all as read
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function() {
            fetch(markAllUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
            .then(res => res.json())
            .then(() => {
                fetchNotifications();
            })
            .catch(() => {});
        });
    }

    // Refresh when dropdown is shown
    notifBell.addEventListener('shown.bs.dropdown', function () {
        fetchNotifications();
    });

    // Initial fetch (for dropdown content before first SSE event)
    fetchNotifications();

    // Cleanup EventSource on page unload
    window.addEventListener('beforeunload', function () {
        if (eventSource) {
            eventSource.close();
        }
    });
});
</script>

<!-- Live Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const userSearch = document.getElementById('userSearch');
    const searchResult = document.getElementById('searchResult');
    const searchUrl = "{{ route('users.search') }}";
    const chatUrlPrefix = "{{ url('/') }}/";

    if (!userSearch || !searchResult) return;

    userSearch.addEventListener('input', function () {
        const query = this.value.trim();
        const userItems = document.querySelectorAll('.user-item');

        if (!query.includes('@') || query.length < 1) {
            userItems.forEach(i => i.style.display = '');
            searchResult.style.display = 'none';
            searchResult.innerHTML = '';
            return;
        }

        userItems.forEach(item => item.style.display = 'none');

        fetch(`${searchUrl}?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(users => {
                if (!users.length) {
                    searchResult.innerHTML = '<div class="search-item text-muted">No user found</div>';
                    searchResult.style.display = 'block';
                    return;
                }

                searchResult.innerHTML = users.map(user => `
                    <a class="search-item" href="${chatUrlPrefix}${user.id}/message">
                        <strong>${user.name}</strong>
                        <div class="text-small text-secondary">${user.email ?? ''}</div>
                    </a>
                `).join('');

                searchResult.style.display = 'block';
            });
    });
});
</script>

<style>
    /* Connectly - Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-gradient: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
    --clr-gradient-light: linear-gradient(135deg, #60A5FA 0%, #2563EB 100%);
    --clr-bg: #F0F5FF;
    --clr-surface: #FFFFFF;
    --clr-text: #0F172A;
    --clr-muted: #64748B;
    --clr-border: rgba(37, 99, 235, 0.08);
    --chatbox-navbar-height: 68px;
    --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.04);
    --shadow-md: 0 4px 16px rgba(37, 99, 235, 0.08);
    --shadow-lg: 0 8px 32px rgba(37, 99, 235, 0.12);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-full: 999px;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    background: var(--clr-bg);
    color: var(--clr-text);
    overflow-x: hidden;
    margin: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ===== TOP NAVBAR ===== */
.chatbox-top-navbar {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-bottom: 1px solid var(--clr-border);
    position: sticky;
    top: 0;
    z-index: 1050;
    flex-shrink: 0;
    min-height: var(--chatbox-navbar-height);
    animation: chatbox-navbar-slide-down 0.5s ease-out forwards;
    box-shadow: 0 1px 4px rgba(37, 99, 235, 0.04);
}

.chatbox-top-navbar .container-fluid {
    padding-left: 1.25rem;
    padding-right: 1.25rem;
}

/* Smooth collapse slide animation */
.chatbox-top-navbar .navbar-collapse {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.chatbox-top-navbar .navbar-collapse.collapsing {
    transition-duration: 0.35s;
}

@keyframes chatbox-navbar-slide-down {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* ===== BRAND / LOGO ===== */
.chatbox-brand-link {
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.chatbox-brand-link:hover {
    transform: translateY(-1px);
}

.chatbox-brand-icon-wrap {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--clr-gradient);
    border-radius: var(--radius-sm);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    transition: all 0.3s ease;
    animation: chatbox-brand-float 3s ease-in-out infinite;
}

.chatbox-brand-link:hover .chatbox-brand-icon-wrap {
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
    transform: rotate(-8deg) scale(1.05);
}

@keyframes chatbox-brand-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

.chatbox-brand-icon {
    color: #fff;
    font-size: 1.25rem;
    line-height: 1;
}

.chatbox-brand-text {
    font-size: 1.35rem;
    font-weight: 800;
    background: var(--clr-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.5px;
    position: relative;
}

.chatbox-brand-text::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--clr-gradient);
    border-radius: 2px;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
}

.chatbox-brand-link:hover .chatbox-brand-text::after {
    transform: scaleX(1);
    transform-origin: left;
}

/* ===== TOGGLER ===== */
.chatbox-toggler {
    border: none;
    padding: 8px;
    border-radius: var(--radius-sm);
    background: transparent;
    transition: all 0.3s ease;
    position: relative;
    z-index: 5;
}

.chatbox-toggler:hover {
    background: var(--clr-border);
}

.chatbox-toggler:focus {
    box-shadow: none;
    outline: none;
}

.chatbox-toggler-icon-wrap {
    width: 22px;
    height: 18px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.chatbox-toggler-bar {
    display: block;
    width: 100%;
    height: 2.5px;
    border-radius: 3px;
    background: #2563EB;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: center;
}

/* Hamburger to X animation */
.chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(1) {
    transform: translateY(7.75px) rotate(45deg);
}
.chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}
.chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(3) {
    transform: translateY(-7.75px) rotate(-45deg);
}

/* ===== NAV LINKS ===== */
.navbar .chatbox-navlink-top {
    text-decoration: none;
    color: var(--clr-muted);
    font-weight: 500;
    font-size: 0.875rem;
    padding: 8px 14px;
    border-radius: var(--radius-sm);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    position: relative;
    background: transparent;
}

.navbar .chatbox-navlink-top i {
    font-size: 1rem;
    transition: transform 0.25s ease;
}

.navbar .chatbox-navlink-top span {
    transition: color 0.25s ease;
}

.navbar .chatbox-navlink-top::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: var(--radius-sm);
    background: var(--clr-gradient);
    opacity: 0;
    transition: opacity 0.25s ease;
    z-index: 0;
}

.navbar .chatbox-navlink-top:hover {
    color: var(--clr-primary);
}

.navbar .chatbox-navlink-top:hover::before {
    opacity: 0.08;
}

.navbar .chatbox-navlink-top:hover i {
    transform: translateY(-1px);
}

/* Active link styling */
.navbar .active-navlink-chatbox {
    color: #fff !important;
    background: var(--clr-gradient);
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
}

.navbar .active-navlink-chatbox::before {
    display: none;
}

.navbar .active-navlink-chatbox:hover::before {
    opacity: 0;
}

.navbar .active-navlink-chatbox:hover i {
    transform: none;
}

.navbar .active-navlink-chatbox i {
    color: #fff !important;
}

.navbar .active-navlink-chatbox span {
    color: #fff !important;
}

/* ===== AUTH BUTTONS ===== */

/* Login link */
.chatbox-login-link {
    background: transparent !important;
}

.chatbox-login-link:hover {
    color: var(--clr-primary) !important;
    background: rgba(37, 99, 235, 0.06) !important;
}

/* Signup button */
.chatbox-signup-button {
    display: inline-flex !important;
    align-items: center;
    gap: 6px;
    padding: 8px 20px !important;
    background: var(--clr-gradient) !important;
    color: #fff !important;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: var(--radius-full) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25) !important;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.chatbox-signup-button::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #1E40AF 0%, #1E3A8A 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: inherit;
}

.chatbox-signup-button:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35) !important;
    color: #fff !important;
}

.chatbox-signup-button:hover::before {
    opacity: 1;
}

.chatbox-signup-button i,
.chatbox-signup-button span {
    position: relative;
    z-index: 1;
}

/* Logout button */
.chatbox-logout-btn {
    display: inline-flex !important;
    align-items: center;
    gap: 6px;
    color: #DC2626 !important;
    font-weight: 500;
    font-size: 0.875rem;
    padding: 8px 14px !important;
    border-radius: var(--radius-sm) !important;
    transition: all 0.25s ease !important;
    cursor: pointer;
    background: transparent !important;
}

.chatbox-logout-btn:hover {
    background: rgba(220, 38, 38, 0.06) !important;
    color: #B91C1C !important;
    transform: translateY(-1px);
}

/* Main Layout */
.chatbox-main-layout-row {
    flex: 1;
    min-height: 0;
    height: calc(100vh - var(--chatbox-navbar-height));
    display: flex;
    flex-direction: row;
    margin: 0;
    width: 100%;
}

.chatbox-layout-landing {
    height: auto;
    min-height: calc(100vh - var(--chatbox-navbar-height));
}

.chatbox-layout-landing .chatbox-content-area {
    height: auto;
    min-height: calc(100vh - var(--chatbox-navbar-height));
    overflow: visible;
}

.chatbox-layout-message {
    display: flex;
    flex-direction: row;
    height: 100%;
}

/* Sidebar Styles */
.chatbox-sidebar-container {
    background: #f9fafb;
    height: 100%;
    border-right: none;
    overflow-y: auto;
    animation: chatbox-sidebar-slide-in 0.6s ease-out;
}

.chatbox-layout-message .col-md-3 .chatbox-sidebar-container {
    border-right: 1px solid #e5e7eb;
}

@keyframes chatbox-sidebar-slide-in {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.chatbox-sidebar-container::-webkit-scrollbar {
    width: 6px;
}

.chatbox-sidebar-container::-webkit-scrollbar-track {
    background: #f9fafb;
}

.chatbox-sidebar-container::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

.chatbox-sidebar-container::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Search Box */
.chatbox-search-wrapper {
    padding-top: 20px;
    animation: chatbox-search-fade-in 0.8s ease-out;
}

@keyframes chatbox-search-fade-in {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbox-search-input-box {
    position: relative;
}

.chatbox-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    z-index: 1;
    font-size: 16px;
}

.chatbox-search-field {
    padding-left: 40px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: #FFFFFF;
    transition: all 0.3s ease;
    font-size: 14px;
}

.chatbox-search-field:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.chatbox-search-results-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #FFFFFF;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    margin-top: 8px;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 10;
}

/* Sidebar User List */
.chatbox-sidebar-user-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.chatbox-section-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
    margin-top: 10px;
}

.chatbox-user-list-item {
    animation: chatbox-user-item-fade-in 0.5s ease-out backwards;
}

.chatbox-user-list-item:nth-child(2) {
    animation-delay: 0.1s;
}

.chatbox-user-list-item:nth-child(3) {
    animation-delay: 0.2s;
}

.chatbox-user-list-item:nth-child(4) {
    animation-delay: 0.3s;
}

.chatbox-user-list-item:nth-child(5) {
    animation-delay: 0.4s;
}

.chatbox-user-list-item:nth-child(6) {
    animation-delay: 0.5s;
}

@keyframes chatbox-user-item-fade-in {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.chatbox-user-link {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    text-decoration: none;
    color: #1f2937;
    transition: all 0.3s ease;
    position: relative;
    border-left: 3px solid transparent;
}

.chatbox-user-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, transparent 100%);
    transition: width 0.3s ease;
}

.chatbox-user-link:hover {
    background: #FFFFFF;
}

.chatbox-user-link:hover::before {
    width: 100%;
}

.active-user-chatbox {
    background: #eff6ff;
    border-left-color: #2563EB;
}

.active-user-chatbox::before {
    width: 100%;
}

.chatbox-user-avatar-wrapper {
    position: relative;
    margin-right: 12px;
}

.chatbox-user-avatar-icon {
    font-size: 36px;
    color: #6b7280;
}

.active-user-chatbox .chatbox-user-avatar-icon {
    color: #2563EB;
}

.chatbox-online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background: #10b981;
    border: 2px solid #FFFFFF;
    border-radius: 50%;
    animation: chatbox-online-pulse 2s infinite;
}

@keyframes chatbox-online-pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    50% {
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0);
    }
}

.chatbox-user-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.chatbox-user-name {
    font-weight: 600;
    font-size: 14px;
    color: #1f2937;
}

.chatbox-user-status {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 2px;
}

.chatbox-unread-badge {
    background: #2563EB;
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
    min-width: 20px;
    text-align: center;
    animation: chatbox-badge-bounce 0.5s ease;
}

@keyframes chatbox-badge-bounce {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
}

/* Content Area */
.chatbox-content-area {
    background: #FFFFFF;
    height: 100%;
    overflow-y: auto;
}

.chatbox-chat-page-column {
    height: 100%;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 0;
    flex: 1;
}

/* Message thread: lock page scroll; only the inbox list scrolls */
html.chatbox-message-active,
body.chatbox-message-active {
    height: 100%;
    overflow: hidden;
}

body.chatbox-message-active {
    min-height: 0;
}

.chatbox-layout-message > .col-md-3 {
    width: 25%;
    min-width: 0;
    height: 100%;
    padding: 0;
    border-right: 1px solid #e5e7eb;
}

.chatbox-layout-message > .col-md-9 {
    width: 75%;
    min-width: 0;
    height: 100%;
    padding: 0;
}

.chatbox-layout-message {
    flex: 1;
    min-height: 0;
    height: calc(100vh - var(--chatbox-navbar-height));
    height: calc(100dvh - var(--chatbox-navbar-height));
    max-height: calc(100vh - var(--chatbox-navbar-height));
    max-height: calc(100dvh - var(--chatbox-navbar-height));
    overflow: hidden;
}

.chatbox-layout-message > [class*="col-"] {
    min-height: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.chatbox-layout-message .chatbox-sidebar-container {
    flex: 1;
    min-height: 0;
}

.chatbox-main-content-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    padding: 40px;
    animation: chatbox-content-fade-in 0.8s ease-out;
}

@keyframes chatbox-content-fade-in {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbox-welcome-title {
    font-size: 36px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 12px;
    background: linear-gradient(135deg, #2563EB 0%, #7c3aed 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: chatbox-title-slide-up 0.8s ease-out;
}

@keyframes chatbox-title-slide-up {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbox-welcome-subtitle {
    font-size: 16px;
    color: #6b7280;
    margin-bottom: 40px;
    animation: chatbox-subtitle-fade-in 1s ease-out;
}

@keyframes chatbox-subtitle-fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.chatbox-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
    max-width: 800px;
    width: 100%;
}

.chatbox-feature-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    transition: all 0.4s ease;
    animation: chatbox-card-float-in 0.8s ease-out backwards;
}

.chatbox-feature-card:nth-child(1) {
    animation-delay: 0.2s;
}

.chatbox-feature-card:nth-child(2) {
    animation-delay: 0.4s;
}

.chatbox-feature-card:nth-child(3) {
    animation-delay: 0.6s;
}

@keyframes chatbox-card-float-in {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbox-feature-card:hover {
    background: #FFFFFF;
    border-color: #2563EB;
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.15);
}

.chatbox-feature-icon {
    font-size: 48px;
    color: #2563EB;
    margin-bottom: 16px;
    animation: chatbox-icon-rotate 3s linear infinite;
}

@keyframes chatbox-icon-rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.chatbox-feature-card:hover .chatbox-feature-icon {
    animation: chatbox-icon-bounce 0.6s ease;
}

@keyframes chatbox-icon-bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.chatbox-feature-card h5 {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.chatbox-feature-card p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

/* ===== RESPONSIVE: Mobile Topbar ===== */

/* Mobile nav items: full width inside collapse */
.chatbox-mobile-nav-items {
    width: 100%;
}
@media (min-width: 992px) {
    .chatbox-mobile-nav-items {
        width: auto;
    }
}

@media (max-width: 991.98px) {
    .chatbox-top-navbar .navbar-collapse {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(24px) saturate(180%);
        -webkit-backdrop-filter: blur(24px) saturate(180%);
        border-radius: 0 0 20px 20px;
        padding: 0.75rem 1.25rem 1.25rem;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.1);
        max-height: 85vh;
        max-height: 85dvh;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        border-bottom: 1px solid var(--clr-border);
    }

    .chatbox-top-navbar .navbar-nav {
        text-align: center;
        padding-top: 0.25rem;
        padding-bottom: 0.5rem;
        gap: 2px;
    }

    .navbar .chatbox-navlink-top {
        padding: 12px 16px;
        font-size: 0.9rem;
        justify-content: center;
        width: 100%;
        border-radius: 10px;
    }

    /* Active link in mobile menu - subtle, no gradient */
    .navbar .active-navlink-chatbox {
        background: #eff6ff !important;
        color: var(--clr-primary) !important;
        box-shadow: none;
    }
    .navbar .active-navlink-chatbox i,
    .navbar .active-navlink-chatbox span {
        color: var(--clr-primary) !important;
    }

    /* Mobile nav section separator via border-top on auth */
    .chatbox-auth-right {
        flex-direction: row;
        gap: 8px;
        margin-top: 0;
        padding-top: 12px;
        border-top: 1px solid #eef2f8;
    }
    .chatbox-auth-right .nav-item {
        flex: 1;
    }
    .chatbox-auth-right .nav-link {
        justify-content: center;
        width: 100%;
        border-radius: 10px;
    }
    .chatbox-signup-button {
        width: 100%;
        justify-content: center !important;
        padding: 12px 20px !important;
        font-size: 0.9rem;
    }

    /* Notification bell in mobile */
    .chatbox-notif-bell span.d-none.d-lg-inline {
        display: inline !important;
    }
    .chatbox-notif-badge {
        top: 2px;
        right: 2px;
        min-width: 16px;
        height: 16px;
        font-size: 8px;
        border-width: 1.5px;
    }
}

@media (max-width: 768px) {
    .chatbox-main-layout-row:not(.chatbox-layout-message) {
        flex-direction: column;
    }

    .chatbox-main-layout-row:not(.chatbox-layout-message) .chatbox-sidebar-container {
        height: auto;
        min-height: 300px;
    }

    .chatbox-main-layout-row:not(.chatbox-layout-message) .chatbox-content-area {
        height: auto;
        min-height: 400px;
    }

    .chatbox-layout-message {
        flex-direction: column;
    }

    .chatbox-layout-message > .col-md-3 {
        flex: 0 0 auto;
        max-height: 32vh;
        height: auto;
    }

    .chatbox-layout-message > .col-md-3 .chatbox-sidebar-container {
        max-height: 32vh;
        height: 100%;
    }

    .chatbox-layout-message > .chatbox-chat-page-column {
        flex: 1 1 auto;
        min-height: 0;
        height: auto;
    }

    .chatbox-welcome-title {
        font-size: 28px;
    }

    .chatbox-features-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .chatbox-top-navbar {
        min-height: 56px;
    }
    .chatbox-top-navbar .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    .chatbox-brand-link {
        gap: 8px;
    }
    .chatbox-brand-text {
        font-size: 1.05rem;
    }
    .chatbox-brand-icon-wrap {
        width: 32px;
        height: 32px;
    }
    .chatbox-brand-icon {
        font-size: 1rem;
    }

    .chatbox-toggler {
        padding: 6px;
    }
    .chatbox-toggler-icon-wrap {
        width: 18px;
        height: 14px;
    }
    .chatbox-toggler-bar {
        height: 2px;
    }
    .chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }
    .chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }

    .navbar .chatbox-navlink-top {
        font-size: 0.82rem;
        padding: 10px 12px;
        gap: 6px;
    }
    .chatbox-signup-button {
        font-size: 0.82rem;
        padding: 10px 16px !important;
    }
    .chatbox-auth-right {
        padding-top: 10px;
        gap: 6px;
    }

    /* Tighter collapse spacing */
    .chatbox-top-navbar .navbar-collapse {
        padding: 0.5rem 0.75rem 1rem;
    }

    .chatbox-search-wrapper {
        padding-top: 12px;
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    .chatbox-user-link {
        padding: 10px 12px;
    }
    .chatbox-user-avatar-icon {
        font-size: 28px;
    }
    .chatbox-user-name {
        font-size: 13px;
    }
    .chatbox-section-label {
        font-size: 11px;
        padding-left: 0.75rem !important;
    }
}

@media (max-width: 375px) {
    .chatbox-top-navbar {
        min-height: 52px;
    }
    .chatbox-brand-text {
        font-size: 0.95rem;
    }
    .chatbox-brand-icon-wrap {
        width: 28px;
        height: 28px;
    }
    .chatbox-brand-icon {
        font-size: 0.9rem;
    }
    .chatbox-brand-link {
        gap: 6px;
    }
    .chatbox-toggler-icon-wrap {
        width: 16px;
        height: 12px;
    }
    .chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(1) {
        transform: translateY(5px) rotate(45deg);
    }
    .chatbox-toggler:not(.collapsed) .chatbox-toggler-bar:nth-child(3) {
        transform: translateY(-5px) rotate(-45deg);
    }
    .navbar .chatbox-navlink-top {
        font-size: 0.78rem;
        padding: 8px 10px;
    }
    .chatbox-signup-button {
        font-size: 0.78rem;
        padding: 8px 12px !important;
    }
    .chatbox-top-navbar .navbar-collapse {
        padding: 0.25rem 0.5rem 0.75rem;
    }
}

/* ===== Safe Area Padding for Notched Phones ===== */
@supports (padding-top: env(safe-area-inset-top)) {
    .chatbox-top-navbar {
        padding-top: env(safe-area-inset-top) !important;
    }
    .chatbox-top-navbar .container-fluid {
        padding-left: calc(1.25rem + env(safe-area-inset-left));
        padding-right: calc(1.25rem + env(safe-area-inset-right));
    }
    @media (max-width: 480px) {
        .chatbox-top-navbar .container-fluid {
            padding-left: calc(0.75rem + env(safe-area-inset-left));
            padding-right: calc(0.75rem + env(safe-area-inset-right));
        }
    }
}

@supports (padding-top: constant(safe-area-inset-top)) {
    .chatbox-top-navbar {
        padding-top: constant(safe-area-inset-top) !important;
    }
    .chatbox-top-navbar .container-fluid {
        padding-left: calc(1.25rem + constant(safe-area-inset-left));
        padding-right: calc(1.25rem + constant(safe-area-inset-right));
    }
    @media (max-width: 480px) {
        .chatbox-top-navbar .container-fluid {
            padding-left: calc(0.75rem + constant(safe-area-inset-left));
            padding-right: calc(0.75rem + constant(safe-area-inset-right));
        }
    }
}

/* ===== Reduced Motion ===== */
@media (prefers-reduced-motion: reduce) {
    .chatbox-top-navbar,
    .chatbox-sidebar-container,
    .chatbox-user-list-item,
    .chatbox-brand-link,
    .chatbox-brand-icon-wrap,
    .chatbox-toggler-bar,
    .chatbox-top-navbar .navbar-collapse {
        animation: none !important;
        transition: none !important;
    }
}

/* Loading Animation */
@keyframes chatbox-shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.chatbox-loading-shimmer {
    animation: chatbox-shimmer 2s infinite linear;
    background: linear-gradient(to right, #f9fafb 0%, #e5e7eb 50%, #f9fafb 100%);
    background-size: 1000px 100%;
}

/* Smooth Transitions */
.chatbox-transition-smooth {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Hover Effects */
.chatbox-hover-lift:hover {
    transform: translateY(-4px);
}

.chatbox-hover-scale:hover {
    transform: scale(1.05);
}

/* Glass Morphism Effect */
.chatbox-glass-effect {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Gradient Text */
.chatbox-gradient-text {
    background: linear-gradient(135deg, #2563EB 0%, #7c3aed 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Box Shadow Utilities */
.chatbox-shadow-sm {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.chatbox-shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.chatbox-shadow-lg {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.chatbox-shadow-xl {
    box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
}

/* ===== NOTIFICATION DROPDOWN ===== */
.chatbox-notif-bell {
    position: relative;
}

.chatbox-notif-badge {
    position: absolute;
    top: 2px;
    right: 4px;
    background: #ef4444;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    min-width: 18px;
    height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    padding: 0 5px;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
    animation: chatbox-notif-pulse 2s infinite;
    pointer-events: none;
    line-height: 1;
}

@keyframes chatbox-notif-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.chatbox-notif-dropdown {
    width: 360px;
    max-width: 90vw;
    padding: 0;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
    margin-top: 10px !important;
    overflow: hidden;
}

.chatbox-notif-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #eef2f8;
    background: #f8fafc;
    font-size: 0.9rem;
}

.chatbox-notif-mark-all {
    font-size: 0.78rem;
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    padding: 0;
}

.chatbox-notif-mark-all:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

.chatbox-notif-list {
    max-height: 320px;
    overflow-y: auto;
}

.chatbox-notif-list::-webkit-scrollbar {
    width: 4px;
}

.chatbox-notif-list::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 2px;
}

.chatbox-notif-item {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s ease;
}

.chatbox-notif-item:last-child {
    border-bottom: none;
}

.chatbox-notif-item:hover {
    background: #f8fafc;
}

.chatbox-notif-unread {
    background: #eff6ff;
}

.chatbox-notif-unread:hover {
    background: #dbeafe;
}

.chatbox-notif-link {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 0.75rem 1rem;
    text-decoration: none;
    color: #1f2937;
    position: relative;
}

.chatbox-notif-avatar {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
}

.chatbox-notif-avatar-img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #eef2f8;
}

.chatbox-notif-avatar-fallback {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 700;
}

.chatbox-notif-content {
    flex: 1;
    min-width: 0;
}

.chatbox-notif-text {
    font-size: 0.82rem;
    line-height: 1.4;
    color: #374151;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.chatbox-notif-time {
    font-size: 0.7rem;
    color: #94a3b8;
    margin-top: 2px;
    display: block;
}

.chatbox-notif-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2563eb;
    flex-shrink: 0;
    margin-top: 6px;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
}

.chatbox-notif-empty {
    text-align: center;
    padding: 2.5rem 1rem;
    color: #9ca3af;
}

.chatbox-notif-empty i {
    font-size: 2rem;
    display: block;
    margin-bottom: 0.5rem;
}

.chatbox-notif-loading {
    padding: 2rem;
}

.chatbox-notif-footer {
    display: block;
    text-align: center;
    padding: 0.65rem 1rem;
    border-top: 1px solid #eef2f8;
    font-size: 0.82rem;
    font-weight: 600;
    color: #2563eb;
    text-decoration: none;
    background: #f8fafc;
    transition: background 0.2s ease;
}

.chatbox-notif-footer:hover {
    background: #eff6ff;
    color: #1d4ed8;
}

@media (max-width: 576px) {
    .chatbox-notif-dropdown {
        width: 100vw;
        max-width: 100vw;
        position: fixed !important;
        left: 0 !important;
        right: 0 !important;
        top: 0 !important;
        padding-top: var(--chatbox-navbar-height, 68px);
        border-radius: 0;
        border: none;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-height: 100vh;
        overflow-y: auto;
    }
}

/* Responsive Auth Right (perfect centering on desktop) */
@media (min-width: 992px) {
  .chatbox-auth-right {
    position: absolute !important;
    right: 1rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin-top: 0 !important;
  }
}
/* Utility Classes */
.chatbox-text-primary {
    color: #2563EB;
}

.chatbox-bg-primary {
    background-color: #2563EB;
}

.chatbox-border-primary {
    border-color: #2563EB;
}
</style>
