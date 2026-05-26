@php
    $isOutgoing = (int) $message->sender_id === auth()->id();
@endphp

<div class="connectly-msg-row {{ $isOutgoing ? 'connectly-msg-row-out' : '' }}"
     data-message-id="{{ $message->id }}">

    @if(!$isOutgoing)
        <div class="connectly-msg-avatar-wrap">
            @if(!empty($recipientAvatarPath))
                <img src="{{ route('media.show', ['path' => $recipientAvatarPath]) }}"
                     alt="Avatar"
                     class="connectly-msg-avatar connectly-msg-avatar-img">
            @else
                <div class="connectly-msg-avatar connectly-msg-avatar-fallback">{{ $recipientInitial }}</div>
            @endif
        </div>
    @endif

    <div class="connectly-msg-bubble-wrap">
        <div class="connectly-msg-bubble {{ $message->image_path ? 'connectly-msg-bubble-img' : '' }} {{ $isOutgoing ? 'connectly-msg-bubble-out' : 'connectly-msg-bubble-in' }}">

            @if($message->deleted_at)
                <p class="connectly-msg-text connectly-msg-text-unsent">
                    <i class="bi bi-slash-circle me-1"></i>Unsent
                </p>
            @else
                @if($message->message)
                    <p class="connectly-msg-text">
                        {!! preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer" class="connectly-msg-link">$1</a>', $message->message) !!}
                        @if($message->edited_at)
                            <span class="connectly-msg-edited">(Edited)</span>
                        @endif
                    </p>
                @endif

                @if($message->image_path)
                    <img src="{{ route('media.show', ['path' => $message->image_path]) }}"
                         class="connectly-msg-img"
                         alt="Message image"
                         role="button"
                         tabindex="0">
                @endif
            @endif

            <span class="connectly-msg-time">
                {{ $message->created_at->format('h:i A') }}
            </span>
        </div>

        @if($isOutgoing && !$message->deleted_at)
            <div class="connectly-msg-actions">
                <button type="button" class="connectly-msg-action-btn edit-btn" data-id="{{ $message->id }}" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>

                <form method="POST" action="{{ route('message.destroy', [$user_id, $message->id]) }}" class="connectly-msg-action-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="connectly-msg-action-btn connectly-msg-action-btn-danger" title="Unsend">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('message.delete-for-me', [$user_id, $message->id]) }}" class="connectly-msg-action-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="connectly-msg-action-btn connectly-msg-action-btn-danger" title="Delete for me">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        @elseif(!$isOutgoing && !$message->deleted_at)
            <div class="connectly-msg-actions">
                <form method="POST" action="{{ route('message.delete-for-me', [$user_id, $message->id]) }}" class="connectly-msg-action-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="connectly-msg-action-btn connectly-msg-action-btn-danger" title="Delete for me">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        @endif

        @if($isOutgoing && !$message->deleted_at)
            <form method="POST"
                  action="{{ route('message.update', [$user_id, $message->id]) }}"
                  id="editForm-{{ $message->id }}"
                  class="connectly-msg-edit-form"
                  style="display:none;">
                @csrf @method('PUT')

                <textarea name="message" class="connectly-msg-edit-input" rows="2">{{ $message->message }}</textarea>

                <div class="connectly-msg-edit-actions">
                    <button type="submit" class="connectly-msg-edit-save">
                        <i class="bi bi-check-lg"></i> Save
                    </button>
                    <button type="button" class="connectly-msg-edit-cancel cancel-btn" data-id="{{ $message->id }}">
                        Cancel
                    </button>
                </div>
            </form>
        @endif
    </div>

    @if($isOutgoing)
        <div class="connectly-msg-avatar-wrap connectly-msg-avatar-wrap-out">
            @if(!empty($senderAvatarPath))
                <img src="{{ route('media.show', ['path' => $senderAvatarPath]) }}"
                     alt="You"
                     class="connectly-msg-avatar connectly-msg-avatar-img">
            @else
                <div class="connectly-msg-avatar connectly-msg-avatar-fallback connectly-msg-avatar-sender">{{ $senderInitial }}</div>
            @endif
        </div>
    @endif

</div>
