@extends('frontend.app')

@section('content')

@php
    $recipientInitial = strtoupper(substr($recipient->name ?? 'U', 0, 1));
    $senderInitial = strtoupper(substr(auth()->user()->name ?? 'Y', 0, 1));
    $recipientAvatarPath = $recipient->avatar_path;
    $senderAvatarPath = auth()->user()->avatar_path;
    $isSelfChat = (int) auth()->id() === (int) $user_id;
@endphp

<div class="connectly-msg-page">
    <!-- BG Orbs -->
    <div class="connectly-msg-orb connectly-msg-orb-1"></div>
    <div class="connectly-msg-orb connectly-msg-orb-2"></div>
    <div class="connectly-msg-orb connectly-msg-orb-3"></div>

    <!-- Particles -->
    <div class="connectly-msg-particles" id="msgParticles"></div>

    <div class="connectly-msg-layout">
        <div class="connectly-msg-card">
            <!-- ===== HEADER ===== -->
            <div class="connectly-msg-header">
                <div class="connectly-msg-header-bg-shine"></div>
                <div class="connectly-msg-header-info">
                    <div class="connectly-msg-avatar">
                        @if($recipientAvatarPath)
                            <img src="{{ route('media.show', ['path' => $recipientAvatarPath]) }}"
                                 alt="Avatar"
                                 class="connectly-msg-avatar-img">
                        @else
                            <div class="connectly-msg-avatar-letter">{{ $recipientInitial }}</div>
                        @endif
                        <div class="connectly-msg-status-dot"></div>
                    </div>
                    <div class="connectly-msg-header-text">
                        <h5 class="connectly-msg-header-name">
                            {{ $recipient->name }}
                            @if($isSelfChat)
                                <span class="connectly-msg-self-tag">(You)</span>
                            @endif
                        </h5>
                        <span class="connectly-msg-header-status">
                            <span class="connectly-msg-header-dot"></span>
                            {{ $isSelfChat ? 'Saved messages' : 'Online' }}
                        </span>
                    </div>
                </div>
                <div class="connectly-msg-header-actions">
                    <button type="button" class="connectly-msg-header-btn" title="Search in conversation">
                        <i class="bi bi-search"></i>
                    </button>
                    <button type="button" class="connectly-msg-header-btn" title="More options">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
            </div>

            <!-- ===== MESSAGES AREA ===== -->
            <div class="connectly-msg-messages"
                 id="chatboxMessagesArea"
                 data-last-id="{{ $messages->last()?->id ?? 0 }}"
                 data-fetch-url="{{ route('message.fetch', $user_id) }}">

                <!-- Date separator -->
                <div class="connectly-msg-date-sep">
                    <span class="connectly-msg-date-line"></span>
                    <span class="connectly-msg-date-text">Today</span>
                    <span class="connectly-msg-date-line"></span>
                </div>

                @if($messages->isEmpty())
                    <div class="connectly-msg-empty" id="chatboxEmptyState">
                        <div class="connectly-msg-empty-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h4 class="connectly-msg-empty-title">No messages yet</h4>
                        <p class="connectly-msg-empty-sub">Start the conversation by sending a message below.</p>
                    </div>
                @endif

                @foreach($messages as $message)
                    @include('frontend.partials.message-row', [
                        'message' => $message,
                        'user_id' => $user_id,
                        'recipientInitial' => $recipientInitial,
                        'senderInitial' => $senderInitial,
                        'recipientAvatarPath' => $recipientAvatarPath,
                        'senderAvatarPath' => $senderAvatarPath,
                    ])
                @endforeach
            </div>

            <!-- ===== INPUT FORM ===== -->
            <form class="connectly-msg-form"
                  id="chatboxMainForm"
                  action="{{ route('message.send', $user_id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                <input type="file" name="image" id="chatboxImageInput" accept="image/*" hidden>

                <div class="connectly-msg-form-inner">
                    <!-- Image preview -->
                    <div class="connectly-msg-preview" id="chatboxImagePreview" style="display:none;">
                        <span class="connectly-msg-preview-text" id="chatboxFileName"></span>
                        <button type="button" class="connectly-msg-preview-remove" id="chatboxRemoveImage">&times;</button>
                    </div>

                    <div class="connectly-msg-form-row">
                        <label for="chatboxImageInput" class="connectly-msg-attach">
                            <i class="bi bi-image"></i>
                        </label>

                        <textarea name="message"
                                  id="chatboxMessageInput"
                                  class="connectly-msg-input"
                                  rows="1"
                                  placeholder="{{ $isSelfChat ? 'Write notes...' : 'Write a message...' }}"></textarea>

                        <button type="submit" class="connectly-msg-send" aria-label="Send message" id="chatboxSendBtn">
                            <i class="bi bi-send-fill"></i>
                            <div class="connectly-msg-send-ripple"></div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image lightbox -->
<div class="connectly-lightbox" id="chatboxImageLightbox" aria-hidden="true">
    <div class="connectly-lightbox-bg" id="chatboxImageLightboxBackdrop"></div>
    <button type="button" class="connectly-lightbox-close" id="chatboxImageLightboxClose">&times;</button>
    <div class="connectly-lightbox-dialog">
        <img src="" alt="Preview" id="chatboxLightboxImage">
    </div>
</div>

<style>
:root {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #f0f5ff;
    --clr-card: #ffffff;
    --clr-text: #1e293b;
    --clr-muted: #94a3b8;
    --clr-border: #e2e8f0;
    --shadow-card: 0 8px 32px rgba(37, 99, 235, 0.08);
    --radius: 16px;
}

.connectly-msg-page {
    position: relative;
    min-height: calc(100vh - 80px);
    background: var(--clr-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow: hidden;
}

.connectly-msg-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
}
.connectly-msg-orb-1 {
    width: 400px; height: 400px;
    background: rgba(37, 99, 235, 0.15);
    top: -120px; right: -100px;
    animation: orbf 12s ease-in-out infinite;
}
.connectly-msg-orb-2 {
    width: 350px; height: 350px;
    background: rgba(96, 165, 250, 0.12);
    bottom: -80px; left: -80px;
    animation: orbf 15s ease-in-out infinite reverse;
}
.connectly-msg-orb-3 {
    width: 250px; height: 250px;
    background: rgba(30, 64, 175, 0.08);
    top: 50%; left: 60%;
    animation: orbf 10s ease-in-out infinite 2s;
}
@keyframes orbf {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -40px) scale(1.05); }
    66% { transform: translate(-20px, 30px) scale(0.95); }
}

.connectly-msg-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

.connectly-msg-layout {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 820px;
    height: calc(100vh - 120px);
    min-height: 500px;
    animation: msgFadeIn 0.6s ease-out;
}
@keyframes msgFadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.connectly-msg-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: var(--clr-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    position: relative;
    border: 1px solid rgba(37, 99, 235, 0.06);
}

.connectly-msg-header {
    flex-shrink: 0;
    padding: 16px 24px;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    gap: 16px;
    z-index: 2;
}
.connectly-msg-header-bg-shine {
    position: absolute;
    top: -60%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
    border-radius: 50%;
    animation: hdrShine 8s ease-in-out infinite;
    pointer-events: none;
}
@keyframes hdrShine {
    0%, 100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(-20px, -15px) scale(1.15); }
}

.connectly-msg-header-info {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
    min-width: 0;
}

.connectly-msg-header-info .connectly-msg-avatar {
    position: relative;
    flex-shrink: 0;
    width: 48px;
    height: 48px;
}
.connectly-msg-header-info .connectly-msg-avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.4);
    transition: transform 0.3s ease;
}
.connectly-msg-header-info .connectly-msg-avatar:hover .connectly-msg-avatar-img {
    transform: scale(1.05);
}
.connectly-msg-header-info .connectly-msg-avatar-letter {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: 3px solid rgba(255,255,255,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
}
.connectly-msg-status-dot {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 13px;
    height: 13px;
    background: #10b981;
    border-radius: 50%;
    border: 3px solid var(--clr-primary);
    animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.connectly-msg-header-text {
    min-width: 0;
}
.connectly-msg-header-name {
    font-size: 17px;
    font-weight: 600;
    color: #fff;
    margin: 0 0 3px;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.connectly-msg-self-tag {
    font-size: 11px;
    font-weight: 500;
    color: rgba(255,255,255,0.8);
    background: rgba(255,255,255,0.15);
    padding: 2px 10px;
    border-radius: 10px;
    flex-shrink: 0;
}
.connectly-msg-header-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: rgba(255,255,255,0.85);
}
.connectly-msg-header-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    animation: dotPulse 2s ease-in-out infinite;
}

.connectly-msg-header-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}
.connectly-msg-header-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.connectly-msg-header-btn:hover {
    background: rgba(255,255,255,0.25);
    color: #fff;
    transform: scale(1.08);
}

.connectly-msg-messages {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    padding: 20px 24px;
    background: #f8fafc;
    position: relative;
    scroll-behavior: smooth;
}
.connectly-msg-messages::-webkit-scrollbar { width: 6px; }
.connectly-msg-messages::-webkit-scrollbar-track { background: transparent; }
.connectly-msg-messages::-webkit-scrollbar-thumb { background: var(--clr-light); border-radius: 3px; }
.connectly-msg-messages::-webkit-scrollbar-thumb:hover { background: var(--clr-primary); }

.connectly-msg-date-sep {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    animation: fadeIn 0.5s ease-out;
}
.connectly-msg-date-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--clr-border), transparent);
}
.connectly-msg-date-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--clr-muted);
    background: #f8fafc;
    padding: 0 8px;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.connectly-msg-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    animation: emptyIn 0.8s ease-out;
}
@keyframes emptyIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.connectly-msg-empty-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    position: relative;
    animation: iconRing 2s ease-in-out infinite;
}
@keyframes iconRing {
    0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,0.3); }
    50% { box-shadow: 0 0 0 15px rgba(37,99,235,0); }
}
.connectly-msg-empty-icon i { font-size: 42px; color: #fff; }
.connectly-msg-empty-title { font-size: 20px; font-weight: 600; color: var(--clr-text); margin: 0 0 6px; }
.connectly-msg-empty-sub { font-size: 14px; color: var(--clr-muted); margin: 0; }

.connectly-msg-form {
    flex-shrink: 0;
    padding: 16px 24px;
    background: #fff;
    border-top: 1px solid var(--clr-border);
    z-index: 2;
}
.connectly-msg-form-inner {
    background: #f1f5f9;
    border-radius: 14px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}
.connectly-msg-form-inner:focus-within {
    border-color: var(--clr-primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
    background: #fff;
}

.connectly-msg-preview {
    padding: 10px 14px;
    background: #eff6ff;
    border-bottom: 1px solid var(--clr-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: slideDown 0.3s ease-out;
}
@keyframes slideDown {
    from { opacity: 0; max-height: 0; }
    to { opacity: 1; max-height: 60px; }
}
.connectly-msg-preview-text {
    font-size: 13px;
    color: var(--clr-primary);
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}
.connectly-msg-preview-text::before {
    content: '\F336';
    font-family: 'bootstrap-icons';
    font-size: 16px;
}
.connectly-msg-preview-remove {
    width: 26px; height: 26px; border: none; background: transparent;
    font-size: 20px; color: var(--clr-muted); cursor: pointer;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease;
}
.connectly-msg-preview-remove:hover {
    background: #fee2e2; color: #dc2626; transform: rotate(90deg);
}

.connectly-msg-form-row {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    padding: 6px;
}

.connectly-msg-attach {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.3s ease;
    flex-shrink: 0; color: var(--clr-muted); font-size: 18px;
}
.connectly-msg-attach:hover {
    background: #dbeafe; color: var(--clr-primary); transform: scale(1.1);
}

.connectly-msg-input {
    flex: 1; border: none; background: transparent; resize: none;
    font-size: 14px; font-family: inherit;
    padding: 8px 4px; max-height: 100px; color: var(--clr-text); line-height: 1.5;
}
.connectly-msg-input:focus { outline: none; }
.connectly-msg-input::placeholder { color: var(--clr-muted); }

.connectly-msg-send {
    width: 38px; height: 38px; border: none; border-radius: 10px;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff; font-size: 15px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; position: relative; overflow: hidden;
    transition: all 0.3s ease;
}
.connectly-msg-send:hover {
    transform: scale(1.08);
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
}
.connectly-msg-send:active { transform: scale(0.92); }
.connectly-msg-send:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

.connectly-msg-send-ripple {
    position: absolute; inset: 0; border-radius: 10px;
    background: rgba(255,255,255,0.2);
    transform: scale(0); opacity: 0;
}
.connectly-msg-send:active .connectly-msg-send-ripple {
    animation: sendRipple 0.5s ease-out;
}
@keyframes sendRipple {
    to { transform: scale(2.5); opacity: 0; }
}

.connectly-lightbox {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 24px;
    opacity: 0; visibility: hidden; pointer-events: none;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.connectly-lightbox[aria-hidden="false"] {
    opacity: 1; visibility: visible; pointer-events: auto;
}
.connectly-lightbox-bg {
    position: absolute; inset: 0;
    background: rgba(15,23,42,0.88);
    backdrop-filter: blur(8px);
}
.connectly-lightbox-close {
    position: fixed; top: 20px; right: 24px; z-index: 10000;
    width: 44px; height: 44px; border: none; border-radius: 50%;
    background: rgba(255,255,255,0.12); color: #fff; font-size: 28px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease;
}
.connectly-lightbox-close:hover {
    background: rgba(255,255,255,0.25);
    transform: scale(1.1) rotate(90deg);
}
.connectly-lightbox-dialog {
    position: relative; z-index: 1;
    max-width: min(92vw, 1100px); max-height: 88vh;
    animation: lightZoom 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes lightZoom {
    from { opacity: 0; transform: scale(0.85); }
    to { opacity: 1; transform: scale(1); }
}
.connectly-lightbox-dialog img {
    display: block;
    max-width: min(92vw, 1100px); max-height: 88vh;
    width: auto; height: auto; object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 24px 80px rgba(0,0,0,0.45);
}

.connectly-send-flash {
    animation: sendFlash 0.4s ease-out;
}
@keyframes sendFlash {
    0% { background-color: rgba(37,99,235,0.05); }
    100% { background-color: transparent; }
}

/* ===== MESSAGE ROW STYLES ===== */
.connectly-msg-row {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    margin-bottom: 16px;
    animation: fadeIn 0.4s ease-out;
}
.connectly-msg-row-out {
    flex-direction: row-reverse;
}

.connectly-msg-avatar-wrap {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    position: relative;
}
.connectly-msg-avatar-wrap-out {
    margin-left: 0;
}

.connectly-msg-avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    transition: transform 0.3s ease;
}
.connectly-msg-avatar-wrap:hover .connectly-msg-avatar-img {
    transform: scale(1.08);
}

.connectly-msg-avatar-fallback {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: #e2e8f0;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
}
.connectly-msg-avatar-sender {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff;
}

.connectly-msg-bubble-wrap {
    max-width: 70%;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.connectly-msg-row-out .connectly-msg-bubble-wrap {
    align-items: flex-end;
}

.connectly-msg-bubble {
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    transition: all 0.3s ease;
    word-wrap: break-word;
    overflow-wrap: break-word;
}
.connectly-msg-bubble-in {
    background: #fff;
    color: var(--clr-text);
    border-bottom-left-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
}
.connectly-msg-bubble-out {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff;
    border-bottom-right-radius: 6px;
    box-shadow: 0 4px 14px rgba(37,99,235,0.2);
}
.connectly-msg-bubble-img {
    padding: 6px;
    background: #fff;
}
.connectly-msg-bubble-out.connectly-msg-bubble-img {
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
}

.connectly-msg-bubble:hover {
    transform: translateY(-1px);
}
.connectly-msg-bubble-in:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.connectly-msg-bubble-out:hover {
    box-shadow: 0 6px 20px rgba(37,99,235,0.3);
}

.connectly-msg-text {
    margin: 0;
    font-size: 15px;
    line-height: 1.5;
    word-wrap: break-word;
}
.connectly-msg-text-unsent {
    font-style: italic;
    opacity: 0.6;
    font-size: 14px;
}

.connectly-msg-link {
    color: var(--clr-primary);
    text-decoration: underline;
}
.connectly-msg-bubble-out .connectly-msg-link {
    color: rgba(255,255,255,0.9);
}
.connectly-msg-link:hover {
    opacity: 0.8;
}

.connectly-msg-edited {
    font-size: 11px;
    opacity: 0.6;
    margin-left: 4px;
    white-space: nowrap;
}
.connectly-msg-bubble-out .connectly-msg-edited {
    color: rgba(255,255,255,0.6);
}

.connectly-msg-img {
    max-width: 100%;
    border-radius: 12px;
    display: block;
    cursor: pointer;
    transition: transform 0.3s ease;
    margin-top: 6px;
}
.connectly-msg-bubble-img .connectly-msg-img {
    margin-top: 0;
}
.connectly-msg-img:hover {
    transform: scale(1.02);
    opacity: 0.95;
}

.connectly-msg-time {
    display: block;
    font-size: 11px;
    color: rgba(0,0,0,0.4);
    margin-top: 4px;
    text-align: right;
}
.connectly-msg-bubble-out .connectly-msg-time {
    color: rgba(255,255,255,0.7);
}

.connectly-msg-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
    animation: fadeIn 0.3s ease-out;
}
.connectly-msg-row-out .connectly-msg-actions {
    justify-content: flex-end;
}

.connectly-msg-action-btn {
    background: transparent;
    border: 1px solid var(--clr-border);
    color: var(--clr-muted);
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.connectly-msg-action-btn i {
    font-size: 14px;
}
.connectly-msg-action-btn:hover {
    background: #f1f5f9;
    border-color: var(--clr-primary);
    color: var(--clr-primary);
    transform: translateY(-1px);
}
.connectly-msg-action-btn-danger:hover {
    border-color: #dc2626;
    color: #dc2626;
    background: #fef2f2;
}

.connectly-msg-action-form {
    display: inline;
}

.connectly-msg-edit-form {
    margin-top: 8px;
    animation: fadeIn 0.3s ease-out;
}
.connectly-msg-edit-input {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid var(--clr-primary);
    border-radius: 12px;
    font-size: 14px;
    resize: vertical;
    font-family: inherit;
    background: #fff;
    transition: all 0.3s ease;
}
.connectly-msg-edit-input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.connectly-msg-edit-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.connectly-msg-edit-save {
    background: var(--clr-primary);
    border: none;
    color: #fff;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.connectly-msg-edit-save:hover {
    background: var(--clr-dark);
    transform: translateY(-1px);
}

.connectly-msg-edit-cancel {
    background: transparent;
    border: 1px solid var(--clr-border);
    color: var(--clr-muted);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.connectly-msg-edit-cancel:hover {
    background: #f1f5f9;
    color: var(--clr-text);
}

/* ===== RESPONSIVE (max-width: 768px - Tablet) ===== */
@media (max-width: 768px) {
    .connectly-msg-page {
        overflow-x: hidden;
        padding: 10px;
        min-height: 100dvh;
    }
    .connectly-msg-layout {
        height: calc(100dvh - 20px);
        max-width: 100%;
        min-height: 500px;
    }
    .connectly-msg-header { padding: 12px 16px; }
    .connectly-msg-header-info .connectly-msg-avatar { width: 40px; height: 40px; }
    .connectly-msg-header-name { font-size: 15px; }
    .connectly-msg-header-actions { gap: 4px; }
    .connectly-msg-header-btn { width: 38px; height: 38px; font-size: 15px; }
    .connectly-msg-messages { padding: 14px 16px; }
    .connectly-msg-form { padding: 10px 14px; }
    .connectly-msg-form-row { padding: 4px; gap: 6px; }
    .connectly-msg-attach { width: 40px; height: 40px; font-size: 17px; border-radius: 10px; }
    .connectly-msg-send { width: 40px; height: 40px; font-size: 16px; border-radius: 10px; }
    .connectly-msg-input { font-size: 16px; padding: 8px 4px; }
    .connectly-lightbox { padding: 12px; }
    .connectly-msg-avatar-wrap { width: 32px; height: 32px; }
    .connectly-msg-bubble-wrap { max-width: 80%; }
    .connectly-msg-bubble { padding: 10px 14px; border-radius: 16px; }
    .connectly-msg-bubble-in { border-bottom-left-radius: 4px; }
    .connectly-msg-bubble-out { border-bottom-right-radius: 4px; }
    .connectly-msg-text { font-size: 14px; }
    .connectly-msg-time { font-size: 10px; }
    .connectly-msg-empty-icon { width: 72px; height: 72px; }
    .connectly-msg-empty-icon i { font-size: 30px; }
    .connectly-msg-empty-title { font-size: 17px; }
    .connectly-msg-empty-sub { font-size: 13px; }
    .connectly-msg-actions { gap: 6px; }
    .connectly-msg-action-btn {
        padding: 8px 12px;
        font-size: 12px;
        min-height: 40px;
        min-width: 40px;
        justify-content: center;
        border-radius: 8px;
    }
    .connectly-msg-action-btn i { font-size: 14px; }
    .connectly-msg-edit-input { font-size: 16px; padding: 8px 12px; }
    .connectly-msg-edit-save, .connectly-msg-edit-cancel { padding: 8px 16px; font-size: 13px; }
    .connectly-lightbox-close { top: 12px; right: 12px; width: 40px; height: 40px; font-size: 24px; }
    .connectly-msg-date-sep { margin-bottom: 14px; }
    .connectly-msg-date-text { font-size: 11px; }
    .connectly-msg-status-dot { width: 11px; height: 11px; border-width: 2px; }

    /* Reduce orb sizes for tablets */
    .connectly-msg-orb-1 { width: 200px; height: 200px; top: -60px; right: -50px; }
    .connectly-msg-orb-2 { width: 180px; height: 180px; bottom: -40px; left: -40px; }
    .connectly-msg-orb-3 { width: 140px; height: 140px; }
}

/* ===== RESPONSIVE (max-width: 576px - Phones) ===== */
@media (max-width: 576px) {
    .connectly-msg-page { padding: 0; }
    .connectly-msg-layout {
        height: 100dvh;
        min-height: 100dvh;
        border-radius: 0;
    }
    .connectly-msg-card { border-radius: 0; border: none; }
    .connectly-msg-header { padding: 10px 12px; }
    .connectly-msg-header-info .connectly-msg-avatar { width: 36px; height: 36px; }
    .connectly-msg-header-name { font-size: 14px; }
    .connectly-msg-header-btn { width: 36px; height: 36px; font-size: 14px; }
    .connectly-msg-header-actions { gap: 3px; }
    .connectly-msg-messages { padding: 10px 12px; }
    .connectly-msg-form { padding: 8px 10px; }
    .connectly-msg-form-inner { border-radius: 12px; }
    .connectly-msg-form-row { padding: 3px; gap: 5px; }
    .connectly-msg-attach { width: 38px; height: 38px; font-size: 16px; border-radius: 9px; }
    .connectly-msg-send { width: 38px; height: 38px; font-size: 15px; border-radius: 9px; }
    .connectly-msg-input { font-size: 16px; padding: 6px 4px; }
    .connectly-msg-avatar-wrap { width: 28px; height: 28px; }
    .connectly-msg-bubble-wrap { max-width: 85%; }
    .connectly-msg-bubble { padding: 8px 12px; border-radius: 14px; }
    .connectly-msg-text { font-size: 14px; }
    .connectly-msg-empty-icon { width: 60px; height: 60px; }
    .connectly-msg-empty-icon i { font-size: 26px; }
    .connectly-msg-empty-title { font-size: 16px; }
    .connectly-msg-empty-sub { font-size: 12px; padding: 0 10px; }
    .connectly-msg-action-btn {
        padding: 6px 10px;
        font-size: 12px;
        min-height: 38px;
        min-width: 38px;
        border-radius: 8px;
    }
    .connectly-msg-action-btn i { font-size: 13px; }
    .connectly-lightbox-dialog img { border-radius: 8px; }
    .connectly-lightbox-close { width: 38px; height: 38px; font-size: 22px; }
    .connectly-msg-edit-input { font-size: 16px; padding: 8px 12px; }
    .connectly-msg-edit-save { padding: 7px 14px; font-size: 12px; }
    .connectly-msg-edit-cancel { padding: 7px 14px; font-size: 12px; }
}

/* ===== RESPONSIVE (max-width: 400px - Small phones) ===== */
@media (max-width: 400px) {
    .connectly-msg-header { padding: 8px 10px; }
    .connectly-msg-header-info { gap: 10px; }
    .connectly-msg-header-info .connectly-msg-avatar { width: 32px; height: 32px; }
    .connectly-msg-header-name { font-size: 13px; }
    .connectly-msg-header-status { font-size: 11px; }
    .connectly-msg-header-btn { width: 34px; height: 34px; font-size: 13px; }
    .connectly-msg-header-actions { gap: 2px; }
    .connectly-msg-messages { padding: 8px 10px; }
    .connectly-msg-form { padding: 6px 8px; }
    .connectly-msg-form-row { padding: 3px; gap: 4px; }
    .connectly-msg-attach { width: 36px; height: 36px; border-radius: 8px; font-size: 15px; }
    .connectly-msg-send { width: 36px; height: 36px; border-radius: 8px; font-size: 14px; }
    .connectly-msg-input { font-size: 16px; max-height: 72px; }
    .connectly-msg-avatar-wrap { width: 24px; height: 24px; }
    .connectly-msg-bubble-wrap { max-width: 88%; }
    .connectly-msg-bubble { padding: 7px 10px; border-radius: 12px; }
    .connectly-msg-text { font-size: 13px; }
    .connectly-msg-time { font-size: 9px; }
    .connectly-msg-empty-icon { width: 50px; height: 50px; }
    .connectly-msg-empty-icon i { font-size: 22px; }
    .connectly-msg-empty-title { font-size: 14px; }
    .connectly-msg-empty-sub { font-size: 11px; }
    .connectly-msg-action-btn {
        padding: 5px 8px;
        font-size: 11px;
        min-height: 36px;
        min-width: 36px;
        border-radius: 6px;
    }
    .connectly-msg-action-btn i { font-size: 12px; }
    .connectly-lightbox-close { width: 36px; height: 36px; font-size: 20px; }
    .connectly-msg-date-sep { margin-bottom: 10px; }
    .connectly-msg-date-text { font-size: 10px; }
    .connectly-msg-edit-input { font-size: 16px; padding: 6px 10px; }
    .connectly-msg-edit-save, .connectly-msg-edit-cancel { padding: 6px 12px; font-size: 11px; }

    /* Reduce orb sizes further for small phones */
    .connectly-msg-orb-1 { width: 140px; height: 140px; top: -40px; right: -30px; }
    .connectly-msg-orb-2 { width: 120px; height: 120px; bottom: -30px; left: -30px; }
    .connectly-msg-orb-3 { width: 100px; height: 100px; }
}

/* ===== Landscape orientation ===== */
@media (max-height: 500px) and (orientation: landscape) {
    .connectly-msg-page { overflow-x: hidden; }
    .connectly-msg-layout { height: 100dvh; min-height: 100dvh; }
    .connectly-msg-header { padding: 6px 12px; }
    .connectly-msg-header-info .connectly-msg-avatar { width: 30px; height: 30px; }
    .connectly-msg-header-name { font-size: 13px; }
    .connectly-msg-header-btn { width: 32px; height: 32px; font-size: 13px; }
    .connectly-msg-messages { padding: 6px 12px; }
    .connectly-msg-form { padding: 4px 10px; }
    .connectly-msg-form-row { padding: 3px; gap: 4px; }
    .connectly-msg-attach { width: 32px; height: 32px; font-size: 14px; }
    .connectly-msg-send { width: 32px; height: 32px; font-size: 13px; }
    .connectly-msg-input { max-height: 48px; font-size: 16px; }
    .connectly-msg-avatar-wrap { width: 24px; height: 24px; }
    .connectly-msg-bubble { padding: 5px 10px; border-radius: 10px; }
    .connectly-msg-text { font-size: 13px; }
    .connectly-msg-empty-icon { width: 44px; height: 44px; }
    .connectly-msg-empty-icon i { font-size: 20px; }
    .connectly-msg-empty-title { font-size: 13px; }
    .connectly-msg-date-sep { margin-bottom: 6px; }
    .connectly-msg-actions { gap: 4px; }
    .connectly-msg-action-btn { padding: 4px 8px; min-height: 30px; min-width: 30px; font-size: 10px; }
}

/* ===== Prevent iOS zoom on input focus ===== */
@supports (-webkit-touch-callout: none) {
    .connectly-msg-input { font-size: 16px !important; }
    .connectly-msg-edit-input { font-size: 16px !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Particles
    (function() {
        const c = document.getElementById('msgParticles');
        if (!c) return;
        for (let i = 0; i < 15; i++) {
            const p = document.createElement('div');
            p.style.cssText = [
                'position:absolute',
                'width:' + (4 + Math.random() * 6) + 'px',
                'height:' + (4 + Math.random() * 6) + 'px',
                'border-radius:50%',
                'background:' + ['rgba(37,99,235,0.2)','rgba(96,165,250,0.18)','rgba(30,64,175,0.15)'][i%3],
                'left:' + (Math.random() * 100) + '%',
                'top:' + (Math.random() * 100) + '%',
                'animation:pf' + ((i % 3) + 1) + ' ' + (6 + Math.random() * 8) + 's ease-in-out infinite',
                'animation-delay:' + (Math.random() * 5) + 's',
                'pointer-events:none'
            ].join(';');
            c.appendChild(p);
        }
    })();

    // Particle keyframes
    var s = document.createElement('style');
    s.textContent = '@keyframes pf1{0%,100%{transform:translateY(0) translateX(0)}25%{transform:translateY(-30px) translateX(15px)}50%{transform:translateY(-10px) translateX(-20px)}75%{transform:translateY(-40px) translateX(10px)}}@keyframes pf2{0%,100%{transform:translateY(0) translateX(0)}25%{transform:translateY(20px) translateX(-25px)}50%{transform:translateY(-15px) translateX(10px)}75%{transform:translateY(30px) translateX(-15px)}}@keyframes pf3{0%,100%{transform:translateY(0) translateX(0)}33%{transform:translateY(-25px) translateX(-15px)}66%{transform:translateY(15px) translateX(25px)}}';
    document.head.appendChild(s);

    // Core chat
    var csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    var input = document.getElementById('chatboxMessageInput');
    var area = document.getElementById('chatboxMessagesArea');
    var form = document.getElementById('chatboxMainForm');
    var sendBtn = document.getElementById('chatboxSendBtn');
    var fetchUrl = area.dataset.fetchUrl;
    var lastId = parseInt(area.dataset.lastId || '0', 10);
    var polling = false;
    var sending = false;

    function resize() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    }
    input.addEventListener('input', resize);

    var imgInput = document.getElementById('chatboxImageInput');
    var preview = document.getElementById('chatboxImagePreview');
    var fname = document.getElementById('chatboxFileName');
    var rmBtn = document.getElementById('chatboxRemoveImage');

    imgInput.addEventListener('change', function() {
        if (this.files.length) { fname.textContent = this.files[0].name; preview.style.display = 'flex'; }
    });
    rmBtn.addEventListener('click', function() { imgInput.value = ''; preview.style.display = 'none'; });

    var lb = document.getElementById('chatboxImageLightbox');
    var lbImg = document.getElementById('chatboxLightboxImage');
    var lbBg = document.getElementById('chatboxImageLightboxBackdrop');
    var lbClose = document.getElementById('chatboxImageLightboxClose');

    function openLB(src) { lbImg.src = src; lb.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; }
    function closeLB() { lb.setAttribute('aria-hidden', 'true'); lbImg.removeAttribute('src'); document.body.style.overflow = ''; }
    lbBg.addEventListener('click', closeLB);
    lbClose.addEventListener('click', closeLB);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lb.getAttribute('aria-hidden') === 'false') closeLB();
    });

    area.addEventListener('click', function(e) {
        var btn = e.target.closest('.edit-btn');
        if (btn) { var f = document.getElementById('editForm-' + btn.dataset.id); if (f) f.style.display = 'block'; return; }
        var cb = e.target.closest('.cancel-btn');
        if (cb) { var f2 = document.getElementById('editForm-' + cb.dataset.id); if (f2) f2.style.display = 'none'; return; }
        var img = e.target.closest('.connectly-msg-img');
        if (img) openLB(img.src);
    });

    area.addEventListener('keydown', function(e) {
        var img = e.target.closest('.connectly-msg-img');
        if (img && (e.key === 'Enter' || e.key === ' ')) { e.preventDefault(); openLB(img.src); }
    });

    function scrollDown() { area.scrollTop = area.scrollHeight; }

    function rmEmpty() {
        var e = document.getElementById('chatboxEmptyState');
        if (e) {
            e.style.transition = 'all 0.3s ease';
            e.style.opacity = '0';
            e.style.transform = 'scale(0.9)';
            setTimeout(function() { if (e.parentNode) e.remove(); }, 300);
        }
    }

    function msgExists(id) { return area.querySelector('[data-message-id="' + id + '"]') !== null; }

    function append(html) {
        if (!html) return;
        var w = document.createElement('div');
        w.innerHTML = html.trim();
        var added = false;
        w.querySelectorAll('[data-message-id]').forEach(function(row) {
            var id = row.getAttribute('data-message-id');
            if (msgExists(id)) return;
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            area.appendChild(row);
            requestAnimationFrame(function() {
                row.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            });
            lastId = Math.max(lastId, parseInt(id, 10));
            added = true;
        });
        if (added) { area.dataset.lastId = String(lastId); rmEmpty(); }
    }

    async function poll() {
        if (polling || document.hidden) return;
        polling = true;
        try {
            var r = await fetch(fetchUrl + '?after=' + encodeURIComponent(lastId), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!r.ok) return;
            var d = await r.json();
            var nearBottom = area.scrollHeight - area.scrollTop - area.clientHeight < 100;
            append(d.html);
            if (d.last_id) { lastId = Math.max(lastId, parseInt(d.last_id, 10)); area.dataset.lastId = String(lastId); }
            if (nearBottom) scrollDown();
        } catch(e) {} finally { polling = false; }
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (sending) return;
        var text = input.value.trim();
        var hasImg = imgInput.files.length > 0;
        if (!text && !hasImg) return;
        sending = true;
        sendBtn.disabled = true;
        var fd = new FormData(form);
        try {
            var r = await fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf },
                body: fd
            });
            var d = await r.json();
            if (!r.ok) { alert(d.message || d.errors?.message?.[0] || 'Could not send message.'); return; }
            append(d.html);
            if (d.message_id) { lastId = Math.max(lastId, parseInt(d.message_id, 10)); area.dataset.lastId = String(lastId); }
            form.reset();
            imgInput.value = '';
            preview.style.display = 'none';
            resize();
            scrollDown();
            area.classList.remove('connectly-send-flash');
            void area.offsetWidth;
            area.classList.add('connectly-send-flash');
        } catch(err) { alert('Could not send message. Please try again.'); }
        finally { sending = false; sendBtn.disabled = false; }
    });

    scrollDown();
    resize();
    setInterval(poll, 3000);
    document.addEventListener('visibilitychange', function() { if (!document.hidden) poll(); });
});
</script>

@endsection
