@extends('frontend.app')

@section('content')

<div class="connectly-friends-page">
    <!-- Animated BG Orbs -->
    <div class="connectly-fr-orb connectly-fr-orb-1"></div>
    <div class="connectly-fr-orb connectly-fr-orb-2"></div>
    <div class="connectly-fr-orb connectly-fr-orb-3"></div>

    <!-- Floating Particles -->
    <div class="connectly-fr-particles">
        <span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="connectly-fr-container">
        @if (session('success'))
            <div class="connectly-fr-alert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="connectly-fr-alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        <!-- ===== HEADER ===== -->
        <div class="connectly-fr-header">
            <div class="connectly-fr-header-left">
                <div class="connectly-fr-header-icon">
                    <i class="bi bi-people-fill"></i>
                    <div class="connectly-fr-header-ring"></div>
                </div>
                <div>
                    <h4 class="connectly-fr-header-title">Friends</h4>
                    <p class="connectly-fr-header-sub">Manage your connections</p>
                </div>
            </div>
            <div class="connectly-fr-header-right">
                <span class="connectly-fr-stat-badge">
                    <i class="bi bi-person-check"></i>
                    {{ $friends->count() }} friends
                </span>
                @if($incomingRequests->isNotEmpty())
                    <span class="connectly-fr-stat-badge connectly-fr-stat-badge-warning">
                        <i class="bi bi-person-plus"></i>
                        {{ $incomingRequests->count() }} pending
                    </span>
                @endif
            </div>
        </div>

        <!-- ===== TABS ===== -->
        <div class="connectly-fr-tabs">
            @if($incomingRequests->isNotEmpty())
                <button class="connectly-fr-tab {{ $incomingRequests->isNotEmpty() ? 'active' : '' }}" data-tab="requests">
                    <i class="bi bi-person-plus-fill"></i>
                    Requests
                    <span class="connectly-fr-tab-badge connectly-fr-tab-badge-warning">{{ $incomingRequests->count() }}</span>
                </button>
            @endif
            @if($outgoingRequests->isNotEmpty())
                <button class="connectly-fr-tab {{ $incomingRequests->isEmpty() && $outgoingRequests->isNotEmpty() ? 'active' : '' }}" data-tab="sent">
                    <i class="bi bi-send-fill"></i>
                    Sent
                    <span class="connectly-fr-tab-badge connectly-fr-tab-badge-info">{{ $outgoingRequests->count() }}</span>
                </button>
            @endif
            <button class="connectly-fr-tab {{ $incomingRequests->isEmpty() && $outgoingRequests->isEmpty() ? 'active' : '' }}" data-tab="friends">
                <i class="bi bi-people-fill"></i>
                All Friends
                <span class="connectly-fr-tab-badge connectly-fr-tab-badge-success">{{ $friends->count() }}</span>
            </button>
        </div>

        <!-- ===== INCOMING REQUESTS PANEL ===== -->
        @if($incomingRequests->isNotEmpty())
        <div class="connectly-fr-panel {{ $incomingRequests->isNotEmpty() ? 'active' : '' }}" id="requestsPanel">
            <div class="connectly-fr-grid">
                @foreach($incomingRequests as $request)
                    @php $requester = $request->sender; @endphp
                    <div class="connectly-fr-card connectly-fr-card-request" data-delay="{{ $loop->index * 50 }}">
                        <div class="connectly-fr-card-glow"></div>
                        <a href="{{ route('profile.show', $requester->id) }}" class="connectly-fr-avatar-link">
                            @if ($requester->avatar_path)
                                <img src="{{ route('media.show', ['path' => $requester->avatar_path]) }}"
                                     alt="{{ $requester->name }}" class="connectly-fr-avatar">
                            @else
                                <div class="connectly-fr-avatar connectly-fr-avatar-fallback">
                                    {{ strtoupper(substr($requester->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="connectly-fr-online"></span>
                        </a>
                        <div class="connectly-fr-info">
                            <a href="{{ route('profile.show', $requester->id) }}" class="connectly-fr-name">
                                {{ $requester->name }}
                            </a>
                            <span class="connectly-fr-email">{{ $requester->email }}</span>
                            <div class="connectly-fr-id-badge">#{{ $requester->id }}</div>
                            <span class="connectly-fr-label connectly-fr-label-request">
                                <i class="bi bi-person-plus"></i> Wants to connect
                            </span>
                        </div>
                        <div class="connectly-fr-actions">
                            <form action="{{ route('friend-request.accept', $request->id) }}" method="POST"
                                  class="connectly-fr-action-form" data-type="accept" data-requester-name="{{ $requester->name }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="connectly-fr-btn connectly-fr-btn-accept" title="Accept">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form action="{{ route('friend-request.reject', $request->id) }}" method="POST"
                                  class="connectly-fr-action-form" data-type="reject" data-requester-name="{{ $requester->name }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="connectly-fr-btn connectly-fr-btn-reject" title="Reject">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ===== OUTGOING REQUESTS PANEL ===== -->
        @if($outgoingRequests->isNotEmpty())
        <div class="connectly-fr-panel {{ $incomingRequests->isEmpty() && $outgoingRequests->isNotEmpty() ? 'active' : '' }}" id="sentPanel">
            <div class="connectly-fr-grid">
                @foreach($outgoingRequests as $request)
                    @php $sentTo = $request->receiver; @endphp
                    <div class="connectly-fr-card connectly-fr-card-sent" data-delay="{{ $loop->index * 50 }}">
                        <div class="connectly-fr-card-glow"></div>
                        <a href="{{ route('profile.show', $sentTo->id) }}" class="connectly-fr-avatar-link">
                            @if ($sentTo->avatar_path)
                                <img src="{{ route('media.show', ['path' => $sentTo->avatar_path]) }}"
                                     alt="{{ $sentTo->name }}" class="connectly-fr-avatar">
                            @else
                                <div class="connectly-fr-avatar connectly-fr-avatar-fallback">
                                    {{ strtoupper(substr($sentTo->name, 0, 1)) }}
                                </div>
                            @endif
                        </a>
                        <div class="connectly-fr-info">
                            <a href="{{ route('profile.show', $sentTo->id) }}" class="connectly-fr-name">
                                {{ $sentTo->name }}
                            </a>
                            <span class="connectly-fr-email">{{ $sentTo->email }}</span>
                            <div class="connectly-fr-id-badge">#{{ $sentTo->id }}</div>
                            <span class="connectly-fr-label connectly-fr-label-sent">
                                <i class="bi bi-hourglass-split"></i> Request sent
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ===== ALL FRIENDS PANEL ===== -->
        <div class="connectly-fr-panel {{ $incomingRequests->isEmpty() && $outgoingRequests->isEmpty() ? 'active' : '' }}" id="friendsPanel">
            @if($friends->isNotEmpty())
                <div class="connectly-fr-grid">
                    @foreach($friends as $friend)
                        <div class="connectly-fr-card connectly-fr-card-friend" data-delay="{{ $loop->index * 50 }}">
                            <div class="connectly-fr-card-glow"></div>
                            <a href="{{ route('profile.show', $friend->id) }}" class="connectly-fr-avatar-link">
                                @if ($friend->avatar_path)
                                    <img src="{{ route('media.show', ['path' => $friend->avatar_path]) }}"
                                         alt="{{ $friend->name }}" class="connectly-fr-avatar">
                                @else
                                    <div class="connectly-fr-avatar connectly-fr-avatar-fallback">
                                        {{ strtoupper(substr($friend->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="connectly-fr-online"></span>
                            </a>
                            <div class="connectly-fr-info">
                                <a href="{{ route('profile.show', $friend->id) }}" class="connectly-fr-name">
                                    {{ $friend->name }}
                                </a>
                                <span class="connectly-fr-email">{{ $friend->email }}</span>
                                <div class="connectly-fr-id-badge">#{{ $friend->id }}</div>
                            <span class="connectly-fr-label connectly-fr-label-friend">
                                    <i class="bi bi-check-circle-fill"></i> Connected
                                </span>
                            </div>
                            <div class="connectly-fr-actions">
                                <a href="{{ route('message', $friend->id) }}"
                                   class="connectly-fr-btn connectly-fr-btn-message" title="Send Message">
                                    <i class="bi bi-chat-dots-fill"></i>
                                </a>
                                <a href="{{ route('profile.show', $friend->id) }}"
                                   class="connectly-fr-btn connectly-fr-btn-profile" title="View Profile">
                                    <i class="bi bi-person"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="connectly-fr-empty">
                    <div class="connectly-fr-empty-icon">
                        <i class="bi bi-people"></i>
                        <div class="connectly-fr-empty-ring"></div>
                        <div class="connectly-fr-empty-ring connectly-fr-empty-ring-2"></div>
                    </div>
                    <h5 class="connectly-fr-empty-title">No friends yet</h5>
                    <p class="connectly-fr-empty-text">
                        Search for people and send them friend requests to start connecting!
                    </p>
                    <a href="{{ route('search') }}" class="connectly-fr-empty-btn">
                        <i class="bi bi-search me-1"></i> Find People
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* ==============================================================
   CONNECTLY FRIENDS — MODERN TRENDING DESIGN
   Color Scheme: Primary #2563EB | Light #60A5FA | Dark #1E40AF
   ============================================================== */

:root {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #F0F5FF;
    --clr-surface: rgba(255, 255, 255, 0.85);
    --clr-glass: rgba(255, 255, 255, 0.72);
    --clr-text: #0F172A;
    --clr-muted: #64748B;
    --clr-soft: #94A3B8;
    --gradient-primary: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
    --gradient-light: linear-gradient(135deg, #60A5FA 0%, #2563EB 100%);
    --gradient-mesh: linear-gradient(135deg, #F0F5FF 0%, #DBEAFE 50%, #EFF6FF 100%);
    --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
    --shadow-md: 0 8px 24px rgba(15, 23, 42, 0.06);
    --shadow-lg: 0 16px 48px rgba(15, 23, 42, 0.08);
    --radius-sm: 10px;
    --radius-md: 14px;
    --radius-lg: 18px;
    --radius-xl: 24px;
}

/* ===== PAGE ===== */
.connectly-friends-page {
    position: relative;
    min-height: 100vh;
    padding: 0 0 3rem;
    background: var(--gradient-mesh);
    overflow: hidden;
}

/* ===== BG ORBS ===== */
.connectly-fr-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
    opacity: 0.45;
}

.connectly-fr-orb-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.15), transparent 70%);
    top: -150px;
    right: -80px;
    animation: frOrb1 20s ease-in-out infinite;
}

.connectly-fr-orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(96, 165, 250, 0.12), transparent 70%);
    bottom: -80px;
    left: -80px;
    animation: frOrb2 25s ease-in-out infinite;
}

.connectly-fr-orb-3 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(30, 64, 175, 0.1), transparent 70%);
    top: 45%;
    left: 60%;
    animation: frOrb3 18s ease-in-out infinite;
}

@keyframes frOrb1 {
    0%, 100% { transform: translate(0,0) scale(1); }
    33% { transform: translate(30px, 50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

@keyframes frOrb2 {
    0%, 100% { transform: translate(0,0) scale(1); }
    33% { transform: translate(-40px, -30px) scale(1.15); }
    66% { transform: translate(20px, -20px) scale(0.95); }
}

@keyframes frOrb3 {
    0%, 100% { transform: translate(0,0) scale(1); opacity: 0.4; }
    50% { transform: translate(-30px, 30px) scale(1.2); opacity: 0.6; }
}

/* ===== PARTICLES ===== */
.connectly-fr-particles {
    position: fixed;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
}

.connectly-fr-particles span {
    position: absolute;
    width: 6px;
    height: 6px;
    background: rgba(37, 99, 235, 0.18);
    border-radius: 50%;
    animation: frParticle 15s infinite;
}

.connectly-fr-particles span:nth-child(1) { left: 5%; top: 15%; animation-delay: 0s; animation-duration: 18s; width: 8px; height: 8px; }
.connectly-fr-particles span:nth-child(2) { left: 20%; top: 60%; animation-delay: 1s; animation-duration: 14s; }
.connectly-fr-particles span:nth-child(3) { left: 40%; top: 10%; animation-delay: 2s; animation-duration: 16s; width: 7px; height: 7px; }
.connectly-fr-particles span:nth-child(4) { left: 60%; top: 70%; animation-delay: 0.5s; animation-duration: 20s; }
.connectly-fr-particles span:nth-child(5) { left: 80%; top: 25%; animation-delay: 1.5s; animation-duration: 12s; }
.connectly-fr-particles span:nth-child(6) { left: 10%; top: 85%; animation-delay: 3s; animation-duration: 17s; }
.connectly-fr-particles span:nth-child(7) { left: 50%; top: 45%; animation-delay: 2.5s; animation-duration: 19s; width: 9px; height: 9px; }
.connectly-fr-particles span:nth-child(8) { left: 30%; top: 90%; animation-delay: 0.8s; animation-duration: 15s; }
.connectly-fr-particles span:nth-child(9) { left: 90%; top: 50%; animation-delay: 1.8s; animation-duration: 13s; width: 7px; height: 7px; }
.connectly-fr-particles span:nth-child(10) { left: 70%; top: 5%; animation-delay: 3.5s; animation-duration: 21s; }

@keyframes frParticle {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.25; }
    25% { transform: translateY(-30px) scale(1.4); opacity: 0.6; }
    50% { transform: translateY(-60px) scale(0.8); opacity: 0.1; }
    75% { transform: translateY(-20px) scale(1.2); opacity: 0.4; }
}

/* ===== CONTAINER ===== */
.connectly-fr-container {
    position: relative;
    z-index: 1;
    max-width: 900px;
    margin: 0 auto;
    padding: 1.5rem 1rem;
}

/* ===== ALERT ===== */
.connectly-fr-alert {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.85rem 1.2rem;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-left: 4px solid #10B981;
    border-radius: var(--radius-md);
    color: #065F46;
    font-size: 0.9rem;
    font-weight: 500;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.12);
    animation: frAlertSlide 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    margin-bottom: 1.25rem;
}

@keyframes frAlertSlide {
    0% { opacity: 0; transform: translateY(-16px) scale(0.97); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.connectly-fr-alert i {
    font-size: 1.2rem;
    color: #10B981;
}

.connectly-fr-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 1.3rem;
    color: #94A3B8;
    cursor: pointer;
    padding: 0 4px;
    line-height: 1;
    transition: all 0.3s ease;
}

.connectly-fr-alert-close:hover {
    color: #EF4444;
    transform: scale(1.2) rotate(90deg);
}

/* ===== HEADER ===== */
.connectly-fr-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    background: var(--clr-surface);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(37, 99, 235, 0.06);
    border-radius: var(--radius-lg);
    padding: 1.25rem 1.5rem;
    box-shadow: var(--shadow-md);
    animation: frHeaderEntrance 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
}

@keyframes frHeaderEntrance {
    0% { opacity: 0; transform: translateY(30px) scale(0.97); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.connectly-fr-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.connectly-fr-header-icon {
    position: relative;
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    border-radius: var(--radius-md);
    font-size: 1.5rem;
    color: #fff;
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
    animation: frHeaderIconPulse 3s ease-in-out infinite;
}

@keyframes frHeaderIconPulse {
    0%, 100% { box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3); }
    50% { box-shadow: 0 8px 32px rgba(37, 99, 235, 0.45); }
}

.connectly-fr-header-ring {
    position: absolute;
    inset: -3px;
    border-radius: var(--radius-md);
    border: 2px solid rgba(96, 165, 250, 0.2);
    animation: frHeaderRingExpand 3s ease-out infinite;
}

@keyframes frHeaderRingExpand {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.08); opacity: 0.1; }
}

.connectly-fr-header-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--clr-text);
    margin: 0;
    line-height: 1.3;
}

.connectly-fr-header-sub {
    font-size: 0.85rem;
    color: var(--clr-muted);
    margin: 0;
}

.connectly-fr-header-right {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.connectly-fr-stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(16, 185, 129, 0.08);
    color: #047857;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1px solid rgba(16, 185, 129, 0.15);
    transition: all 0.3s ease;
}

.connectly-fr-stat-badge i {
    font-size: 0.9rem;
}

.connectly-fr-stat-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.12);
}

.connectly-fr-stat-badge-warning {
    background: rgba(245, 158, 11, 0.08);
    color: #B45309;
    border-color: rgba(245, 158, 11, 0.15);
}

/* ===== TABS ===== */
.connectly-fr-tabs {
    display: flex;
    gap: 0.4rem;
    margin: 1.25rem 0;
    padding: 0.35rem;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: var(--radius-md);
    border: 1px solid rgba(37, 99, 235, 0.06);
    width: fit-content;
    animation: frFadeInUp 0.6s ease-out 0.15s backwards;
}

.connectly-fr-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.6rem 1.1rem;
    border: none;
    background: transparent;
    color: var(--clr-muted);
    font-size: 0.88rem;
    font-weight: 600;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    white-space: nowrap;
}

.connectly-fr-tab i {
    font-size: 1rem;
}

.connectly-fr-tab:hover {
    color: var(--clr-primary);
    background: rgba(37, 99, 235, 0.04);
}

.connectly-fr-tab.active {
    background: #fff;
    color: var(--clr-primary);
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
}

.connectly-fr-tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    font-size: 0.7rem;
    font-weight: 700;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.connectly-fr-tab-badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #B45309;
}

.connectly-fr-tab.active .connectly-fr-tab-badge-warning {
    background: #F59E0B;
    color: #fff;
}

.connectly-fr-tab-badge-info {
    background: rgba(37, 99, 235, 0.1);
    color: var(--clr-primary);
}

.connectly-fr-tab.active .connectly-fr-tab-badge-info {
    background: var(--clr-primary);
    color: #fff;
}

.connectly-fr-tab-badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #047857;
}

.connectly-fr-tab.active .connectly-fr-tab-badge-success {
    background: #10B981;
    color: #fff;
}

/* ===== PANELS ===== */
.connectly-fr-panel {
    display: none;
    animation: frPanelIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

.connectly-fr-panel.active {
    display: block;
}

@keyframes frPanelIn {
    0% { opacity: 0; transform: translateY(16px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ===== GRID ===== */
.connectly-fr-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 0.8rem;
}

/* ===== FRIEND CARD ===== */
.connectly-fr-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 0.9rem 1.1rem;
    background: var(--clr-surface);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(37, 99, 235, 0.06);
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    animation: frCardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
}

@keyframes frCardIn {
    0% { opacity: 0; transform: translateY(20px) scale(0.97); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.connectly-fr-card::before {
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

.connectly-fr-card-request::before {
    background: #F59E0B;
}

.connectly-fr-card-sent::before {
    background: var(--clr-primary);
}

.connectly-fr-card-friend::before {
    background: #10B981;
}

.connectly-fr-card:hover {
    transform: translateY(-5px) scale(1.01);
    box-shadow: var(--shadow-lg);
    border-color: rgba(37, 99, 235, 0.12);
    background: rgba(255, 255, 255, 0.95);
}

/* Card glow */
.connectly-fr-card-glow {
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

.connectly-fr-card:hover .connectly-fr-card-glow {
    opacity: 1;
    transform: translate(-50%, -50%) scale(3);
}

/* Avatar */
.connectly-fr-avatar-link {
    flex-shrink: 0;
    text-decoration: none;
    position: relative;
}

.connectly-fr-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid #EEF2F8;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.connectly-fr-card:hover .connectly-fr-avatar {
    transform: scale(1.1);
    border-color: #DBEAFE;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
}

.connectly-fr-avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    color: #fff;
    background: var(--gradient-primary);
}

.connectly-fr-online {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 12px;
    height: 12px;
    background: #10B981;
    border: 2.5px solid #fff;
    border-radius: 50%;
    animation: frOnlinePulse 2s ease-in-out infinite;
}

@keyframes frOnlinePulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
    50% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
}

/* Info */
.connectly-fr-info {
    flex: 1;
    min-width: 0;
}

.connectly-fr-name {
    display: block;
    font-weight: 600;
    font-size: 0.93rem;
    color: var(--clr-text);
    text-decoration: none;
    transition: color 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.connectly-fr-name:hover {
    color: var(--clr-primary);
}

.connectly-fr-email {
    display: block;
    font-size: 0.75rem;
    color: var(--clr-soft);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.connectly-fr-label {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 0.68rem;
    font-weight: 600;
    margin-top: 4px;
    padding: 2px 8px;
    border-radius: 6px;
}

.connectly-fr-id-badge {
    display: inline-flex;
    align-items: center;
    font-size: 0.68rem;
    font-weight: 700;
    color: #94A3B8;
    background: rgba(148, 163, 184, 0.08);
    padding: 2px 8px;
    border-radius: 6px;
    margin-top: 4px;
    letter-spacing: 0.3px;
    border: 1px solid rgba(148, 163, 184, 0.1);
}

.connectly-fr-label-request {
    background: rgba(245, 158, 11, 0.08);
    color: #B45309;
}

.connectly-fr-label-sent {
    background: rgba(37, 99, 235, 0.08);
    color: var(--clr-primary);
}

.connectly-fr-label-friend {
    background: rgba(16, 185, 129, 0.08);
    color: #047857;
}

/* Actions */
.connectly-fr-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
    position: relative;
    z-index: 2;
}

.connectly-fr-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    border: 1.5px solid rgba(37, 99, 235, 0.08);
    background: rgba(255, 255, 255, 0.8);
    color: var(--clr-muted);
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-size: 0.9rem;
    text-decoration: none;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.connectly-fr-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

.connectly-fr-btn-accept:hover {
    background: #10B981;
    border-color: #10B981;
    color: #fff;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
}

.connectly-fr-btn-reject:hover {
    background: #EF4444;
    border-color: #EF4444;
    color: #fff;
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
}

.connectly-fr-btn-message:hover {
    background: var(--clr-primary);
    border-color: var(--clr-primary);
    color: #fff;
    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
}

.connectly-fr-btn-profile:hover {
    background: #475569;
    border-color: #475569;
    color: #fff;
    box-shadow: 0 4px 12px rgba(71, 85, 105, 0.3);
}

/* ===== EMPTY STATE ===== */
.connectly-fr-empty {
    text-align: center;
    padding: 4rem 1rem;
    animation: frFadeInUp 0.6s ease-out;
}

.connectly-fr-empty-icon {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.connectly-fr-empty-icon i {
    font-size: 3rem;
    color: var(--clr-primary);
    z-index: 2;
    animation: frEmptyBounce 2.5s ease-in-out infinite;
}

@keyframes frEmptyBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

.connectly-fr-empty-ring {
    position: absolute;
    inset: -3px;
    border: 2.5px dashed rgba(37, 99, 235, 0.15);
    border-radius: 50%;
    animation: frRingSpin 12s linear infinite;
}

.connectly-fr-empty-ring-2 {
    inset: -9px;
    border-color: rgba(96, 165, 250, 0.1);
    animation-duration: 16s;
    animation-direction: reverse;
}

@keyframes frRingSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.connectly-fr-empty-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--clr-text);
    margin-bottom: 0.5rem;
}

.connectly-fr-empty-text {
    font-size: 0.9rem;
    color: var(--clr-muted);
    max-width: 380px;
    margin: 0 auto 1.5rem;
    line-height: 1.7;
}

.connectly-fr-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.7rem 1.5rem;
    background: var(--gradient-primary);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 600;
    border: none;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
    text-decoration: none;
}

.connectly-fr-empty-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
    color: #fff;
}

.connectly-fr-empty-btn:active {
    transform: translateY(-1px);
}

/* ===== KEYFRAMES ===== */
@keyframes frFadeInUp {
    0% { opacity: 0; transform: translateY(16px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ===== SweetAlert2 Overrides ===== */
.connectly-fr-swal-popup {
    border-radius: var(--radius-lg) !important;
    box-shadow: var(--shadow-lg) !important;
    font-family: inherit !important;
}

.connectly-fr-swal-popup .swal2-title {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    color: var(--clr-text) !important;
}

.connectly-fr-swal-popup .swal2-html-container {
    font-size: 0.9rem !important;
    color: var(--clr-muted) !important;
}

.connectly-fr-swal-popup .swal2-timer-progress-bar {
    background: var(--gradient-light) !important;
    height: 3px !important;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .connectly-fr-container {
        padding: 1rem 0.75rem;
    }

    .connectly-fr-header {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem 1.2rem;
    }

    .connectly-fr-header-right {
        width: 100%;
    }

    .connectly-fr-grid {
        grid-template-columns: 1fr;
    }

    .connectly-fr-tabs {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .connectly-fr-tab {
        flex: 1;
        justify-content: center;
        font-size: 0.82rem;
        padding: 0.5rem 0.8rem;
    }

    .connectly-fr-card {
        padding: 0.8rem 0.9rem;
    }

    .connectly-fr-empty {
        padding: 3rem 0.5rem;
    }
}

@media (max-width: 480px) {
    .connectly-fr-header-title {
        font-size: 1.1rem;
    }

    .connectly-fr-header-icon {
        width: 44px;
        height: 44px;
        font-size: 1.2rem;
    }

    .connectly-fr-avatar {
        width: 44px;
        height: 44px;
    }

    .connectly-fr-btn {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== 1. Tab switching =====
    const tabs = document.querySelectorAll('.connectly-fr-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            document.querySelectorAll('.connectly-fr-panel').forEach(p => {
                p.classList.remove('active');
            });

            const panel = document.getElementById(target + 'Panel');
            if (panel) {
                panel.classList.add('active');
                panel.style.animation = 'none';
                panel.offsetHeight;
                panel.style.animation = '';
            }
        });
    });

    // ===== 2. Intersection Observer for staggered card animations =====
    const cards = document.querySelectorAll('.connectly-fr-card');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const delay = parseInt(card.dataset.delay) || 0;
                    card.style.animationDelay = delay + 'ms';
                    observer.unobserve(card);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px 50px 0px' });

        cards.forEach(card => {
            card.style.opacity = '0';
            observer.observe(card);
        });
    } else {
        cards.forEach(card => {
            const delay = parseInt(card.dataset.delay) || 0;
            card.style.animationDelay = delay + 'ms';
        });
    }

    // ===== 3. Parallax glow on cards =====
    const allCards = document.querySelectorAll('.connectly-fr-card');
    allCards.forEach(card => {
        card.addEventListener('mousemove', function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const glow = this.querySelector('.connectly-fr-card-glow');
            if (glow) {
                glow.style.left = x + 'px';
                glow.style.top = y + 'px';
                glow.style.transform = 'translate(-50%, -50%) scale(2.5)';
            }
        });

        card.addEventListener('mouseleave', function () {
            const glow = this.querySelector('.connectly-fr-card-glow');
            if (glow) {
                glow.style.left = '50%';
                glow.style.top = '50%';
                glow.style.transform = 'translate(-50%, -50%) scale(0)';
            }
        });
    });

    // ===== 4. Accept/Reject with SweetAlert2 confirmation =====
    document.addEventListener('submit', function (e) {
        const form = e.target.closest('.connectly-fr-action-form');
        if (!form) return;

        e.preventDefault();

        const type = form.dataset.type;
        const name = form.dataset.requesterName || 'this user';

        if (type === 'accept') {
            Swal.fire({
                title: 'Accept Request?',
                text: `You will become friends with ${name}.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#64748B',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Yes, Accept',
                cancelButtonText: 'Not Now',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'connectly-fr-swal-popup',
                    confirmButton: 'btn btn-success px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1',
                    cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border'
                },
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: new FormData(form),
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
                    handleRequestAccepted(form, name);
                }
            });
        } else if (type === 'reject') {
            Swal.fire({
                title: 'Reject Request?',
                text: `The friend request from ${name} will be rejected.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#64748B',
                confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Yes, Reject',
                cancelButtonText: 'Keep Request',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'connectly-fr-swal-popup',
                    confirmButton: 'btn btn-danger px-4 py-2 rounded-3 fw-semibold d-inline-flex align-items-center gap-1',
                    cancelButton: 'btn btn-light px-4 py-2 rounded-3 fw-semibold border'
                },
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: new FormData(form),
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
                    handleRequestRejected(form, name);
                }
            });
        }
    });

    // ===== Toast helper =====
    function showToast(icon, title) {
        if (typeof Swal === 'undefined') {
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
                popup: 'connectly-fr-swal-popup'
            }
        });
    }

    // ===== Handle accept =====
    function handleRequestAccepted(form, name) {
        const card = form.closest('.connectly-fr-card');
        if (card) {
            card.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.85) translateY(-10px)';
            setTimeout(() => card.remove(), 400);
        }

        updateRequestCountBadge();
        updateFriendsCountUp();
        updateHeaderStatUp();

        showToast('success', `Accepted ${name}'s request`);
    }

    // ===== Handle reject =====
    function handleRequestRejected(form, name) {
        const card = form.closest('.connectly-fr-card');
        if (card) {
            card.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.85) translateY(-10px)';
            setTimeout(() => card.remove(), 400);
        }

        updateRequestCountBadge();
        showToast('success', `Rejected ${name}'s request`);
    }

    // ===== Update request count badge =====
    function updateRequestCountBadge() {
        const requestTab = document.querySelector('.connectly-fr-tab[data-tab="requests"]');
        if (requestTab) {
            const badge = requestTab.querySelector('.connectly-fr-tab-badge');
            if (badge) {
                const current = parseInt(badge.textContent, 10) || 0;
                const next = Math.max(0, current - 1);
                badge.textContent = next;

                if (next <= 0) {
                    // Remove the requests tab
                    requestTab.remove();

                    // Also hide any request panels
                    const panel = document.getElementById('requestsPanel');
                    if (panel) {
                        panel.style.transition = 'all 0.3s ease';
                        panel.style.opacity = '0';
                        setTimeout(() => panel.remove(), 300);
                    }

                    // If no tabs left with active, activate friends tab
                    const activeTab = document.querySelector('.connectly-fr-tab.active');
                    if (!activeTab) {
                        const friendsTab = document.querySelector('.connectly-fr-tab[data-tab="friends"]');
                        if (friendsTab) {
                            friendsTab.click();
                        }
                    }
                }
            }
        }

        // Update header pending badge
        const headerPending = document.querySelector('.connectly-fr-stat-badge-warning');
        if (headerPending) {
            const current = parseInt(headerPending.textContent.match(/\d+/)?.[0] || '0', 10);
            const next = Math.max(0, current - 1);
            if (next <= 0) {
                headerPending.remove();
            } else {
                headerPending.innerHTML = `<i class="bi bi-person-plus"></i> ${next} pending`;
            }
        }
    }

    // ===== Update friends count up =====
    function updateFriendsCountUp() {
        const friendsBadge = document.querySelector('.connectly-fr-tab[data-tab="friends"] .connectly-fr-tab-badge');
        if (friendsBadge) {
            const current = parseInt(friendsBadge.textContent, 10) || 0;
            friendsBadge.textContent = current + 1;
        }
    }

    // ===== Update header stat =====
    function updateHeaderStatUp() {
        const headerStat = document.querySelector('.connectly-fr-stat-badge:first-child');
        if (headerStat) {
            const match = headerStat.textContent.match(/\d[\d,]*/);
            const current = match ? parseInt(match[0].replace(/,/g, ''), 10) : 0;
            headerStat.innerHTML = `<i class="bi bi-person-check"></i> ${current + 1} friends`;
        }
    }
});
</script>


@endsection
