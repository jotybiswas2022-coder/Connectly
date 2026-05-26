@php
    $isOutgoing = (int) $message->sender_id === auth()->id();
@endphp

<div class="chatbox-message-row-container {{ $isOutgoing ? 'chatbox-outgoing-row' : '' }}"
     data-message-id="{{ $message->id }}">

    @if(!$isOutgoing)
        @if(!empty($recipientAvatarPath))
            <img src="{{ route('media.show', ['path' => $recipientAvatarPath]) }}"
                 alt="Recipient avatar"
                 class="chatbox-message-avatar-small chatbox-message-avatar-image">
        @else
            <div class="chatbox-message-avatar-small">{{ $recipientInitial }}</div>
        @endif
    @endif

    <div class="chatbox-bubble-content-wrapper">

        <div class="chatbox-message-bubble-box {{ $message->image_path ? 'chatbox-has-image-content' : '' }}">

            @if($message->deleted_at)
                <p class="chatbox-message-text-paragraph chatbox-message-unsent-style">Unsent</p>
            @else
                @if($message->message)
                    <p class="chatbox-message-text-paragraph">
                        {!! preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $message->message) !!}
                        @if($message->edited_at)
                            <small>(Edited)</small>
                        @endif
                    </p>
                @endif

                @if($message->image_path)
                    <img src="{{ route('media.show', ['path' => $message->image_path]) }}"
                         class="chatbox-message-image-display"
                         alt="Message image"
                         role="button"
                         tabindex="0">
                @endif
            @endif

            <span class="chatbox-timestamp-label">
                {{ $message->created_at->format('h:i A') }}
            </span>
        </div>

        <div class="chatbox-actions-menu-container">
            @if($isOutgoing)

                @if(!$message->deleted_at)
                    <button type="button"
                            class="chatbox-action-button-style edit-btn"
                            data-id="{{ $message->id }}">
                        Edit
                    </button>
                @endif

                <form method="POST" action="{{ route('message.destroy', [$user_id, $message->id]) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="chatbox-action-button-style">
                        Unsend
                    </button>
                </form>

                <form method="POST" action="{{ route('message.delete-for-me', [$user_id, $message->id]) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="chatbox-action-button-style">
                        Delete for me
                    </button>
                </form>

            @else
                <form method="POST" action="{{ route('message.delete-for-me', [$user_id, $message->id]) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="chatbox-action-button-style">
                        Delete for me
                    </button>
                </form>
            @endif
        </div>

        @if($isOutgoing && !$message->deleted_at)
            <form method="POST"
                  action="{{ route('message.update', [$user_id, $message->id]) }}"
                  id="editForm-{{ $message->id }}"
                  class="chatbox-edit-form-container"
                  style="display:none;">
                @csrf @method('PUT')

                <textarea name="message"
                          class="chatbox-edit-textarea-input"
                          rows="2">{{ $message->message }}</textarea>

                <div class="chatbox-edit-buttons-row">
                    <button type="submit" class="chatbox-action-button-style">Save</button>
                    <button type="button"
                            class="chatbox-action-button-style cancel-btn"
                            data-id="{{ $message->id }}">
                        Cancel
                    </button>
                </div>
            </form>
        @endif

    </div>

    @if($isOutgoing)
        @if(!empty($senderAvatarPath))
            <img src="{{ route('media.show', ['path' => $senderAvatarPath]) }}"
                 alt="Sender avatar"
                 class="chatbox-message-avatar-small chatbox-message-avatar-image chatbox-sender-avatar-image">
        @else
            <div class="chatbox-message-avatar-small chatbox-sender-avatar">{{ $senderInitial }}</div>
        @endif
    @endif

</div>
