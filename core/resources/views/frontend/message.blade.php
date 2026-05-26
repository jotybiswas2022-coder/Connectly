@extends('frontend.app')

@section('content')

@php
    $recipientInitial = strtoupper(substr($recipient->name ?? 'U', 0, 1));
    $senderInitial = strtoupper(substr(auth()->user()->name ?? 'Y', 0, 1));
    $recipientAvatarPath = $recipient->avatar_path;
    $senderAvatarPath = auth()->user()->avatar_path;
    $isSelfChat = (int) auth()->id() === (int) $user_id;
@endphp

<div class="chatbox-page-wrapper">
    <div class="chatbox-main-container">
        <div class="chatbox-card-wrapper">

            <!-- Header -->
            <div class="chatbox-top-header">
                @if($recipientAvatarPath)
                    <img src="{{ route('media.show', ['path' => $recipientAvatarPath]) }}"
                         alt="Recipient avatar"
                         class="chatbox-user-avatar-circle chatbox-recipient-avatar-image">
                @else
                    <div class="chatbox-user-avatar-circle chatbox-recipient-avatar">{{ $recipientInitial }}</div>
                @endif
                <div class="chatbox-user-details-block">
                    <h5 class="chatbox-username-title">
                        {{ $recipient->name }}
                        @if($isSelfChat)
                            <span class="chatbox-self-label-tag">(You)</span>
                        @endif
                    </h5>
                    <span class="chatbox-online-status-text">
                        <span class="chatbox-status-indicator-dot"></span>
                        {{ $isSelfChat ? 'Saved messages' : 'Online' }}
                    </span>
                </div>
            </div>

            <!-- Messages -->
            <div class="chatbox-messages-scroll-area"
                 id="chatboxMessagesArea"
                 data-last-id="{{ $messages->last()?->id ?? 0 }}"
                 data-fetch-url="{{ route('message.fetch', $user_id) }}">

                @if($messages->isEmpty())
                    <div class="chatbox-empty-state-container" id="chatboxEmptyState">
                        <div class="chatbox-empty-icon-wrapper">
                            <i class="bi bi-chat-left-text"></i>
                        </div>
                        <h4>No messages yet</h4>
                        <p>Start the conversation by sending a message.</p>
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

            <!-- Input -->
            <form class="chatbox-input-form-container"
                  id="chatboxMainForm"
                  action="{{ route('message.send', $user_id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                <input type="file" name="image" id="chatboxImageInput" accept="image/*" hidden>

                <div class="chatbox-input-wrapper-block">
                    <div class="chatbox-image-preview-container" id="chatboxImagePreview" style="display:none;">
                        <span class="chatbox-image-filename-text" id="chatboxFileName"></span>
                        <button type="button" class="chatbox-remove-image-button" id="chatboxRemoveImage" aria-label="Remove image">&times;</button>
                    </div>

                    <div class="chatbox-input-controls-row">
                        <label for="chatboxImageInput" class="chatbox-attach-file-label">
                            <i class="bi bi-image"></i>
                        </label>

                        <textarea name="message"
                                  id="chatboxMessageInput"
                                  class="chatbox-message-textarea-field"
                                  rows="1"
                                  placeholder="{{ $isSelfChat ? 'Write notes...' : 'Write a message...' }}"></textarea>

                        <button type="submit" class="chatbox-send-message-button" aria-label="Send message">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Image lightbox -->
<div id="chatboxImageLightbox" class="chatbox-image-lightbox" aria-hidden="true">
    <div class="chatbox-image-lightbox-backdrop" id="chatboxImageLightboxBackdrop"></div>
    <button type="button" class="chatbox-image-lightbox-close" id="chatboxImageLightboxClose" aria-label="Close image">&times;</button>
    <div class="chatbox-image-lightbox-dialog">
        <img src="" alt="Message image preview" id="chatboxLightboxImage">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.body.classList.add('chatbox-message-active');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const input = document.getElementById('chatboxMessageInput');
    const messagesArea = document.getElementById('chatboxMessagesArea');
    const chatForm = document.getElementById('chatboxMainForm');
    const sendBtn = chatForm.querySelector('.chatbox-send-message-button');
    const fetchUrl = messagesArea.dataset.fetchUrl;
    let lastMessageId = parseInt(messagesArea.dataset.lastId || '0', 10);
    let isPolling = false;
    let isSending = false;

    function resizeMessageInput() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    }

    input.addEventListener('input', resizeMessageInput);
    input.addEventListener('focus', function () {
        scrollMessagesToBottom();
    });

    const imageInput = document.getElementById('chatboxImageInput');
    const preview = document.getElementById('chatboxImagePreview');
    const fileName = document.getElementById('chatboxFileName');
    const removeBtn = document.getElementById('chatboxRemoveImage');

    imageInput.addEventListener('change', function () {
        if (this.files.length) {
            fileName.textContent = this.files[0].name;
            preview.style.display = 'flex';
        }
    });

    removeBtn.addEventListener('click', function () {
        imageInput.value = '';
        preview.style.display = 'none';
    });

    const lightbox = document.getElementById('chatboxImageLightbox');
    const lightboxImg = document.getElementById('chatboxLightboxImage');
    const lightboxBackdrop = document.getElementById('chatboxImageLightboxBackdrop');
    const lightboxClose = document.getElementById('chatboxImageLightboxClose');

    function openImageLightbox(src) {
        lightboxImg.src = src;
        lightbox.classList.add('chatbox-image-lightbox-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeImageLightbox() {
        lightbox.classList.remove('chatbox-image-lightbox-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImg.removeAttribute('src');
        document.body.style.overflow = '';
    }

    lightboxBackdrop.addEventListener('click', closeImageLightbox);
    lightboxClose.addEventListener('click', closeImageLightbox);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('chatbox-image-lightbox-open')) {
            closeImageLightbox();
        }
    });

    messagesArea.addEventListener('click', function (e) {
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            const form = document.getElementById('editForm-' + editBtn.dataset.id);
            if (form) form.style.display = 'block';
            return;
        }

        const cancelBtn = e.target.closest('.cancel-btn');
        if (cancelBtn) {
            const form = document.getElementById('editForm-' + cancelBtn.dataset.id);
            if (form) form.style.display = 'none';
            return;
        }

        const img = e.target.closest('.chatbox-message-image-display');
        if (img) {
            openImageLightbox(img.src);
        }
    });

    messagesArea.addEventListener('keydown', function (e) {
        const img = e.target.closest('.chatbox-message-image-display');
        if (img && (e.key === 'Enter' || e.key === ' ')) {
            e.preventDefault();
            openImageLightbox(img.src);
        }
    });

    function scrollMessagesToBottom() {
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    function removeEmptyState() {
        const empty = document.getElementById('chatboxEmptyState');
        if (empty) empty.remove();
    }

    function messageExists(id) {
        return messagesArea.querySelector('[data-message-id="' + id + '"]') !== null;
    }

    function appendMessages(html) {
        if (!html) return;

        const wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();

        wrapper.querySelectorAll('[data-message-id]').forEach(function (row) {
            const id = row.getAttribute('data-message-id');
            if (messageExists(id)) return;

            messagesArea.appendChild(row);
            lastMessageId = Math.max(lastMessageId, parseInt(id, 10));
        });

        messagesArea.dataset.lastId = String(lastMessageId);
        removeEmptyState();
    }

    async function pollMessages() {
        if (isPolling || document.hidden) return;
        isPolling = true;

        try {
            const url = fetchUrl + '?after=' + encodeURIComponent(lastMessageId);
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) return;

            const data = await response.json();
            const wasNearBottom = messagesArea.scrollHeight - messagesArea.scrollTop - messagesArea.clientHeight < 80;

            appendMessages(data.html);

            if (data.last_id) {
                lastMessageId = Math.max(lastMessageId, parseInt(data.last_id, 10));
                messagesArea.dataset.lastId = String(lastMessageId);
            }

            if (wasNearBottom) {
                scrollMessagesToBottom();
            }
        } catch (err) {
            // ignore network errors during poll
        } finally {
            isPolling = false;
        }
    }

    chatForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (isSending) return;

        const text = input.value.trim();
        const hasImage = imageInput.files.length > 0;
        if (!text && !hasImage) return;

        isSending = true;
        sendBtn.disabled = true;

        const formData = new FormData(chatForm);

        try {
            const response = await fetch(chatForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                const msg = data.message || data.errors?.message?.[0] || 'Could not send message.';
                alert(msg);
                return;
            }

            appendMessages(data.html);
            if (data.message_id) {
                lastMessageId = Math.max(lastMessageId, parseInt(data.message_id, 10));
                messagesArea.dataset.lastId = String(lastMessageId);
            }

            chatForm.reset();
            imageInput.value = '';
            preview.style.display = 'none';
            resizeMessageInput();
            scrollMessagesToBottom();
        } catch (err) {
            alert('Could not send message. Please try again.');
        } finally {
            isSending = false;
            sendBtn.disabled = false;
        }
    });

    scrollMessagesToBottom();
    resizeMessageInput();
    setInterval(pollMessages, 3000);
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) pollMessages();
    });
});
</script>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.chatbox-message-active {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #FFFFFF;
            color: #1f2937;
            overflow: visible;
        }

        .chatbox-page-wrapper {
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
            position: relative;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .chatbox-page-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            z-index: 0;
        }

        .chatbox-main-container {
            flex: 1;
            min-height: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .chatbox-card-wrapper {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            background: #FFFFFF;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            animation: chatboxSlideUp 0.6s ease-out;
            margin: 12px 16px;
        }

        @keyframes chatboxSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-top-header {
            flex-shrink: 0;
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .chatbox-top-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: chatboxFloatBubble 8s ease-in-out infinite;
        }

        @keyframes chatboxFloatBubble {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(-20px, -20px) scale(1.1);
            }
        }

        .chatbox-user-avatar-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: #FFFFFF;
            flex-shrink: 0;
            position: relative;
            animation: chatboxPulseAvatar 2s ease-in-out infinite;
        }

        @keyframes chatboxPulseAvatar {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(255, 255, 255, 0);
            }
        }

        .chatbox-user-avatar-circle.chatbox-recipient-avatar {
            background: rgba(255, 255, 255, 0.25);
        }

        .chatbox-recipient-avatar-image {
            object-fit: cover;
            background: #ffffff;
            animation: none;
            box-shadow: none;
        }

        .chatbox-user-details-block {
            flex: 1;
            min-width: 0;
        }

        .chatbox-username-title {
            font-size: 18px;
            font-weight: 600;
            color: #FFFFFF;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chatbox-self-label-tag {
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 10px;
            border-radius: 12px;
        }

        .chatbox-online-status-text {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        .chatbox-status-indicator-dot {
            width: 10px;
            height: 10px;
            background: #10b981;
            border-radius: 50%;
            border: 2px solid #FFFFFF;
            animation: chatboxBlink 2s ease-in-out infinite;
        }

        @keyframes chatboxBlink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .chatbox-messages-scroll-area {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-y;
            padding: 16px;
            background: #f9fafb;
            position: relative;
        }

        .chatbox-messages-scroll-area::-webkit-scrollbar {
            width: 8px;
        }

        .chatbox-messages-scroll-area::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 4px;
        }

        .chatbox-messages-scroll-area::-webkit-scrollbar-thumb {
            background: #2563EB;
            border-radius: 4px;
        }

        .chatbox-messages-scroll-area::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }

        .chatbox-empty-state-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            animation: chatboxFadeIn 0.8s ease-out;
        }

        @keyframes chatboxFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .chatbox-empty-icon-wrapper {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            animation: chatboxBounceIn 1s ease-out;
        }

        @keyframes chatboxBounceIn {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .chatbox-empty-icon-wrapper i {
            font-size: 48px;
            color: #FFFFFF;
        }

        .chatbox-empty-state-container h4 {
            font-size: 22px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .chatbox-empty-state-container p {
            font-size: 15px;
            color: #6b7280;
        }

        .chatbox-message-row-container {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            animation: chatboxMessageSlide 0.4s ease-out;
        }

        @keyframes chatboxMessageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-message-row-container.chatbox-outgoing-row {
            flex-direction: row-reverse;
        }

        .chatbox-message-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
            color: #6b7280;
            flex-shrink: 0;
            border: 2px solid #FFFFFF;
        }

        .chatbox-message-avatar-small.chatbox-sender-avatar {
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            color: #FFFFFF;
        }

        .chatbox-message-avatar-image {
            object-fit: cover;
            background: #ffffff;
            border: 2px solid #FFFFFF;
        }

        .chatbox-sender-avatar-image {
            border-color: #dbeafe;
        }

        .chatbox-bubble-content-wrapper {
            max-width: 65%;
            position: relative;
        }

        .chatbox-message-bubble-box {
            background: #FFFFFF;
            padding: 14px 18px;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: relative;
            transition: all 0.3s ease;
        }

        .chatbox-message-bubble-box:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }

        .chatbox-outgoing-row .chatbox-message-bubble-box {
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            color: #FFFFFF;
        }

        .chatbox-message-bubble-box.chatbox-has-image-content {
            padding: 8px;
        }

        /* Incoming message links (blue) */
        .chatbox-message-bubble-box a {
            color: #2563EB; /* match bubble background */
            text-decoration: underline;
            background: transparent;
        }
        .chatbox-message-bubble-box a:hover {
            opacity: 0.85;
        }
        /* Outgoing message links (white) */
        .chatbox-outgoing-row .chatbox-message-bubble-box a {
            color: #FFFFFF;
        }

        .chatbox-message-text-paragraph {
            margin: 0;
            font-size: 15px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .chatbox-outgoing-row .chatbox-message-text-paragraph {
            color: #FFFFFF;
        }

        .chatbox-message-image-display {
            max-width: 100%;
            border-radius: 12px;
            display: block;
            margin-top: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .chatbox-message-image-display:hover {
            transform: scale(1.02);
            opacity: 0.92;
        }

        .chatbox-message-bubble-box.chatbox-has-image-content .chatbox-message-image-display {
            margin-top: 0;
        }

        .chatbox-image-lightbox {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .chatbox-image-lightbox.chatbox-image-lightbox-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .chatbox-image-lightbox-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(6px);
        }

        .chatbox-image-lightbox-dialog {
            position: relative;
            z-index: 1;
            max-width: min(92vw, 1100px);
            max-height: 88vh;
            animation: chatboxLightboxZoom 0.3s ease-out;
        }

        @keyframes chatboxLightboxZoom {
            from {
                opacity: 0;
                transform: scale(0.92);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .chatbox-image-lightbox-dialog img {
            display: block;
            max-width: min(92vw, 1100px);
            max-height: 88vh;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.45);
        }

        .chatbox-image-lightbox-close {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 10000;
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            color: #FFFFFF;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .chatbox-image-lightbox-close:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: scale(1.08);
        }

        .chatbox-timestamp-label {
            display: block;
            font-size: 11px;
            color: rgba(0, 0, 0, 0.4);
            margin-top: 6px;
            text-align: right;
        }

        .chatbox-outgoing-row .chatbox-timestamp-label {
            color: rgba(255, 255, 255, 0.7);
        }

        .chatbox-actions-menu-container {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
            animation: chatboxFadeIn 0.3s ease-out;
        }

        .chatbox-action-button-style {
            background: transparent;
            border: 1px solid #d1d5db;
            color: #6b7280;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chatbox-action-button-style:hover {
            background: #f3f4f6;
            border-color: #2563EB;
            color: #2563EB;
            transform: translateY(-1px);
        }

        .chatbox-action-button-style.chatbox-edit-action-btn {
            border-color: #2563EB;
            color: #2563EB;
        }

        .chatbox-action-button-style.chatbox-delete-action-btn {
            border-color: #dc2626;
            color: #dc2626;
        }

        .chatbox-action-button-style.chatbox-delete-action-btn:hover {
            background: #fee2e2;
        }

        .chatbox-action-button-style.chatbox-save-action-btn {
            background: #2563EB;
            border-color: #2563EB;
            color: #FFFFFF;
        }

        .chatbox-action-button-style.chatbox-save-action-btn:hover {
            background: #1d4ed8;
        }

        .chatbox-inline-form-style {
            display: inline;
        }

        .chatbox-edit-form-container {
            margin-top: 10px;
            animation: chatboxFadeIn 0.3s ease-out;
        }

        .chatbox-edit-textarea-input {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #2563EB;
            border-radius: 12px;
            font-size: 14px;
            resize: vertical;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .chatbox-edit-textarea-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .chatbox-edit-buttons-row {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .chatbox-notification-alert-box {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            animation: chatboxSlideInRight 0.4s ease-out;
        }

        @keyframes chatboxSlideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .chatbox-notification-alert-box.chatbox-success-alert {
            background: #10b981;
            color: #FFFFFF;
        }

        .chatbox-notification-alert-box.chatbox-error-alert {
            background: #dc2626;
            color: #FFFFFF;
        }

        .chatbox-input-form-container {
            flex-shrink: 0;
            background: #FFFFFF;
            padding: 14px 18px;
            border-top: 1px solid #e5e7eb;
            width: 100%;
        }

        .chatbox-input-wrapper-block {
            background: #f9fafb;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .chatbox-input-wrapper-block:focus-within {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .chatbox-image-preview-container {
            padding: 10px 12px;
            background: #eff6ff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: chatboxFadeIn 0.3s ease-out;
        }

        .chatbox-image-filename-text {
            font-size: 14px;
            color: #2563EB;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chatbox-image-filename-text::before {
            content: '\F427';
            font-family: 'bootstrap-icons';
            font-size: 18px;
        }

        .chatbox-remove-image-button {
            background: transparent;
            border: none;
            color: #6b7280;
            font-size: 24px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .chatbox-remove-image-button:hover {
            background: #fee2e2;
            color: #dc2626;
            transform: rotate(90deg);
        }

        .chatbox-input-controls-row {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            padding: 0;
        }

        .chatbox-attach-file-label {
            width: 40px;
            height: 40px;
            background: #eff6ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .chatbox-attach-file-label:hover {
            background: #2563EB;
            transform: scale(1.08);
        }

        .chatbox-attach-file-label i {
            font-size: 18px;
            color: #2563EB;
            transition: color 0.3s ease;
        }

        .chatbox-attach-file-label:hover i {
            color: #FFFFFF;
        }

        .chatbox-message-textarea-field {
            flex: 1;
            border: none;
            background: transparent;
            resize: none;
            font-size: 14px;
            font-family: inherit;
            padding: 8px 0;
            max-height: 100px;
            overflow-y: auto;
            color: #1f2937;
        }

        .chatbox-message-textarea-field:focus {
            outline: none;
        }

        .chatbox-message-textarea-field::placeholder {
            color: #9ca3af;
        }

        .chatbox-send-message-button {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%);
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .chatbox-send-message-button:hover {
            transform: scale(1.08);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4);
        }

        .chatbox-send-message-button:active {
            transform: scale(0.95);
        }

        .chatbox-send-message-button i {
            font-size: 16px;
            color: #FFFFFF;
        }

        @keyframes chatboxTypingDots {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-8px);
            }
        }

        .chatbox-typing-indicator {
            display: inline-flex;
            gap: 4px;
            padding: 12px 16px;
            background: #FFFFFF;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .chatbox-typing-indicator span {
            width: 8px;
            height: 8px;
            background: #9ca3af;
            border-radius: 50%;
            animation: chatboxTypingDots 1.4s ease-in-out infinite;
        }

        .chatbox-typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chatbox-typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @media (max-width: 768px) {
            .chatbox-main-container {
                padding: 0;
            }

            .chatbox-card-wrapper {
                margin: 8px;
                border-radius: 8px;
            }

            .chatbox-top-header {
                padding: 14px;
            }

            .chatbox-user-avatar-circle {
                width: 44px;
                height: 44px;
                font-size: 16px;
            }

            .chatbox-username-title {
                font-size: 16px;
            }

            .chatbox-messages-scroll-area {
                padding: 12px;
            }

            .chatbox-bubble-content-wrapper {
                max-width: 80%;
            }

            .chatbox-input-form-container {
                padding: 12px 14px;
            }
        }

        .chatbox-message-unsent-style {
            font-style: italic;
            color: #9ca3af;
        }

        .chatbox-edited-label-text {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.4);
        }

        .chatbox-outgoing-row .chatbox-edited-label-text {
            color: rgba(255, 255, 255, 0.6);
        }
            @media (max-width: 600px) {
            .chatbox-main-container {
                padding: 0;
            }
            .chatbox-card-wrapper {
                margin: 6px;
                border-radius: 6px;
            }
            .chatbox-top-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 12px;
                gap: 10px;
            }
            .chatbox-user-avatar-circle {
                width: 40px;
                height: 40px;
                font-size: 16px;
                border: 2px solid rgba(255, 255, 255, 0.4);
            }
            .chatbox-username-title {
                font-size: 14px;
                margin-bottom: 2px;
            }
            .chatbox-online-status-text {
                font-size: 11px;
            }
            .chatbox-message-row-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .chatbox-message-bubble-box {
                max-width: 100%;
                padding: 8px 12px;
            }
            .chatbox-input-form-container {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
                padding: 10px 12px;
            }
            .chatbox-message-textarea-field {
                width: 100%;
                font-size: 13px;
                padding: 6px 0;
            }
            .chatbox-send-message-button {
                align-self: flex-end;
            }
            .chatbox-messages-scroll-area {
                padding: 12px;
            }
        }
    </style>

@endsection
