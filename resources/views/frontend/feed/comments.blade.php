@extends('frontend.app')

@section('content')

@php
    $userReaction = $post->reactions->first();
    $currentReactionType = $userReaction?->reaction_type;
    $currentReactionLabel = $currentReactionType ? ($reactionTypes[$currentReactionType] ?? 'Like') : 'Like';
    $currentReactionEmoji = match ($currentReactionType) {
        'love' => '❤️',
        'haha' => '😆',
        'wow' => '😮',
        'sad' => '😢',
        default => '👍',
    };
    $postImages = $post->images ?? [];
    $imageCount = count($postImages);
@endphp

<div class="connectly-comments-page">
    <div class="connectly-comments-container">
        <div class="connectly-comments-header">
            <a href="{{ route('feed') }}" class="connectly-comments-back">
                <i class="bi bi-arrow-left"></i>
                Back to Feed
            </a>
            <h4 class="connectly-comments-title">Comments</h4>
        </div>

        {{-- Post Card --}}
        <div class="connectly-comments-post-card">
            <div class="d-flex align-items-start gap-3">
                @if($post->user->avatar_path)
                    <img src="{{ route('media.show', ['path' => $post->user->avatar_path]) }}"
                         alt="{{ $post->user->name }} avatar"
                         class="connectly-comments-post-avatar">
                @else
                    <div class="connectly-comments-post-avatar connectly-comments-post-avatar-alt">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('profile.show', $post->user_id) }}" class="connectly-comments-post-user">{{ $post->user->name }}</a>
                        <span class="text-muted" style="font-size:0.75rem;">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    @if (filled($post->content))
                        <p class="connectly-comments-post-text">{{ $post->content }}</p>
                    @endif
                    @if ($imageCount > 0)
                        <div class="connectly-comments-post-images {{ $imageCount === 1 ? 'grid-1' : ($imageCount === 2 ? 'grid-2' : ($imageCount === 3 ? 'grid-3' : 'grid-4')) }}">
                            @foreach ($postImages as $index => $imgPath)
                                @if ($index < 4)
                                    <div class="connectly-comments-post-image-item" onclick="openImageModal('{{ route('media.show', ['path' => $imgPath]) }}')">
                                        <img src="{{ route('media.show', ['path' => $imgPath]) }}" alt="Post image {{ $index + 1 }}" loading="lazy">
                                        @if ($index === 3 && $imageCount > 4)
                                            <div class="connectly-comments-post-image-overlay">+{{ $imageCount - 4 }}</div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Comments List --}}
        <div class="connectly-comments-list">
            @forelse ($post->comments as $comment)
                @php
                    $commentUserReaction = $comment->reactions->first();
                    $commentCurrentReactionType = $commentUserReaction?->reaction_type;
                    $commentCurrentReactionLabel = $commentCurrentReactionType ? ($reactionTypes[$commentCurrentReactionType] ?? 'Like') : 'Like';
                    $commentCurrentReactionEmoji = match ($commentCurrentReactionType) {
                        'love' => '❤️',
                        'haha' => '😆',
                        'wow' => '😮',
                        'sad' => '😢',
                        default => '👍',
                    };
                @endphp
                <div class="connectly-comments-item" data-comment-card="{{ $comment->id }}">
                    <div class="d-flex align-items-start gap-2">
                        @if($comment->user->avatar_path)
                            <img src="{{ route('media.show', ['path' => $comment->user->avatar_path]) }}"
                                 alt="{{ $comment->user->name }} avatar"
                                 class="connectly-comments-item-avatar">
                        @else
                            <div class="connectly-comments-item-avatar connectly-comments-item-avatar-alt">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <a href="{{ route('profile.show', $comment->user_id) }}" class="connectly-comments-item-user">{{ $comment->user->name }}</a>
                                <span class="text-muted" style="font-size:0.7rem;">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            @if (filled($comment->comment))
                                <p class="connectly-comments-item-text">{!! nl2br(e($comment->comment)) !!}</p>
                            @endif
                            @if ($comment->image_path)
                                <img src="{{ route('media.show', ['path' => $comment->image_path]) }}"
                                     alt="Comment image"
                                     class="connectly-comments-item-image"
                                     onclick="openImageModal(this.src)">
                            @endif
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <div class="connectly-comment-reaction-picker" data-comment-id="{{ $comment->id }}">
                                    <form action="{{ route('feed.comments.react', $comment->id) }}" method="POST" class="d-inline" data-comment-reaction-form="main">
                                        @csrf
                                        <input type="hidden" name="reaction_type" value="{{ $commentCurrentReactionType ?? 'like' }}" class="chatbox-comment-main-reaction-input">
                                        <button type="submit" class="connectly-comments-reaction-btn {{ $commentCurrentReactionType ? 'active' : '' }}">
                                            <span class="me-1 chatbox-comment-main-reaction-emoji">{{ $commentCurrentReactionEmoji }}</span>
                                            <span class="chatbox-comment-main-reaction-label">{{ $commentCurrentReactionLabel }}</span>
                                            (<span class="chatbox-comment-main-reaction-count">{{ $comment->reactions_count }}</span>)
                                        </button>
                                    </form>
                                    <div class="connectly-comment-reaction-options" aria-label="Reaction options">
                                        @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                            @php
                                                $reactionEmoji = match ($reactionKey) {
                                                    'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                                    default => '👍',
                                                };
                                            @endphp
                                            <form action="{{ route('feed.comments.react', $comment->id) }}" method="POST" class="d-inline" data-comment-reaction-form="option">
                                                @csrf
                                                <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                <button type="submit" class="connectly-comments-reaction-option {{ $commentCurrentReactionType === $reactionKey ? 'active' : '' }}" title="{{ $reactionLabel }}">{{ $reactionEmoji }}</button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="connectly-comments-reply-btn chatbox-reply-trigger"
                                        data-form-id="commentForm{{ $post->id }}"
                                        data-parent-id="{{ $comment->id }}">
                                    <i class="bi bi-reply"></i> Reply
                                </button>
                            </div>

                            {{-- Reaction badges --}}
                            <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                                @foreach (array_keys($reactionTypes) as $reactionKey)
                                    @php
                                        $reactionCountField = $reactionKey . '_count';
                                        $reactionCount = (int) ($comment->{$reactionCountField} ?? 0);
                                        $reactionEmoji = match ($reactionKey) {
                                            'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                            default => '👍',
                                        };
                                    @endphp
                                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge {{ $reactionCount > 0 ? '' : 'd-none' }}" data-comment-reaction-badge="{{ $reactionKey }}">
                                        <span class="chatbox-comment-reaction-badge-emoji">{{ $reactionEmoji }}</span>
                                        <span class="chatbox-comment-reaction-badge-count">{{ $reactionCount }}</span>
                                    </span>
                                @endforeach
                            </div>

                            {{-- Replies --}}
                            @if ($comment->replies->isNotEmpty())
                                <div class="connectly-comments-replies" data-replies-for="{{ $comment->id }}">
                                    @foreach ($comment->replies as $reply)
                                        @php
                                            $replyUserReaction = $reply->reactions->first();
                                            $replyCurrentReactionType = $replyUserReaction?->reaction_type;
                                            $replyCurrentReactionLabel = $replyCurrentReactionType ? ($reactionTypes[$replyCurrentReactionType] ?? 'Like') : 'Like';
                                            $replyCurrentReactionEmoji = match ($replyCurrentReactionType) {
                                                'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                                default => '👍',
                                            };
                                        @endphp
                                        <div class="connectly-comments-reply-item" data-comment-card="{{ $reply->id }}">
                                            <div class="d-flex align-items-start gap-2">
                                                @if($reply->user->avatar_path)
                                                    <img src="{{ route('media.show', ['path' => $reply->user->avatar_path]) }}"
                                                         alt="{{ $reply->user->name }} avatar"
                                                         class="connectly-comments-item-avatar" style="width:24px;height:24px;">
                                                @else
                                                    <div class="connectly-comments-item-avatar connectly-comments-item-avatar-alt" style="width:24px;height:24px;font-size:10px;">
                                                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                                        <a href="{{ route('profile.show', $reply->user_id) }}" class="connectly-comments-item-user">{{ $reply->user->name }}</a>
                                                        <span class="text-muted" style="font-size:0.7rem;">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @if (filled($reply->comment))
                                                        <p class="connectly-comments-item-text">{!! nl2br(e($reply->comment)) !!}</p>
                                                    @endif
                                                    @if ($reply->image_path)
                                                        <img src="{{ route('media.show', ['path' => $reply->image_path]) }}"
                                                             alt="Reply image" class="connectly-comments-item-image"
                                                             onclick="openImageModal(this.src)">
                                                    @endif
                                                    <div class="d-flex align-items-center gap-2 mt-2">
                                                        <div class="connectly-comment-reaction-picker" data-comment-id="{{ $reply->id }}">
                                                            <form action="{{ route('feed.comments.react', $reply->id) }}" method="POST" class="d-inline" data-comment-reaction-form="main">
                                                                @csrf
                                                                <input type="hidden" name="reaction_type" value="{{ $replyCurrentReactionType ?? 'like' }}" class="chatbox-comment-main-reaction-input">
                                                                <button type="submit" class="connectly-comments-reaction-btn {{ $replyCurrentReactionType ? 'active' : '' }}">
                                                                    <span class="me-1 chatbox-comment-main-reaction-emoji">{{ $replyCurrentReactionEmoji }}</span>
                                                                    <span class="chatbox-comment-main-reaction-label">{{ $replyCurrentReactionLabel }}</span>
                                                                    (<span class="chatbox-comment-main-reaction-count">{{ $reply->reactions_count }}</span>)
                                                                </button>
                                                            </form>
                                                            <div class="connectly-comment-reaction-options" aria-label="Reaction options">
                                                                @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                                                    @php
                                                                        $reactionEmoji = match ($reactionKey) {
                                                                            'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                                                            default => '👍',
                                                                        };
                                                                    @endphp
                                                                    <form action="{{ route('feed.comments.react', $reply->id) }}" method="POST" class="d-inline" data-comment-reaction-form="option">
                                                                        @csrf
                                                                        <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                                        <button type="submit" class="connectly-comments-reaction-option {{ $replyCurrentReactionType === $reactionKey ? 'active' : '' }}" title="{{ $reactionLabel }}">{{ $reactionEmoji }}</button>
                                                                    </form>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                                                        @foreach (array_keys($reactionTypes) as $reactionKey)
                                                            @php
                                                                $reactionCountField = $reactionKey . '_count';
                                                                $reactionCount = (int) ($reply->{$reactionCountField} ?? 0);
                                                                $reactionEmoji = match ($reactionKey) {
                                                                    'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                                                    default => '👍',
                                                                };
                                                            @endphp
                                                            <span class="badge rounded-pill text-bg-light border connectly-reaction-badge {{ $reactionCount > 0 ? '' : 'd-none' }}" data-comment-reaction-badge="{{ $reactionKey }}">
                                                                <span class="chatbox-comment-reaction-badge-emoji">{{ $reactionEmoji }}</span>
                                                                <span class="chatbox-comment-reaction-badge-count">{{ $reactionCount }}</span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="connectly-comments-replies d-none" data-replies-for="{{ $comment->id }}"></div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="connectly-comments-empty">
                    <i class="bi bi-chat-square-text"></i>
                    <p>No comments yet. Be the first to comment!</p>
                </div>
            @endforelse
        </div>

        {{-- Comment Form --}}
        <div class="connectly-comments-form-card">
            <form action="{{ route('feed.posts.comments.store', $post->id) }}" method="POST" enctype="multipart/form-data" id="commentForm{{ $post->id }}" data-comment-form-id="{{ $post->id }}">
                @csrf
                <input type="hidden" name="parent_id" value="" class="chatbox-reply-parent-id">

                <div class="connectly-comments-reply-indicator d-none chatbox-reply-indicator" role="alert">
                    <i class="bi bi-reply-fill"></i>
                    <span class="chatbox-reply-indicator-text">Replying to comment</span>
                    <button type="button" class="chatbox-reply-cancel-btn chatbox-reply-cancel"><i class="bi bi-x-lg"></i></button>
                </div>

                <textarea
                    name="comment"
                    class="connectly-comments-form-textarea @error('comment', 'commentPost_' . $post->id) is-invalid @enderror"
                    rows="3"
                    placeholder="Write a comment..."
                    maxlength="500"
                >{{ old('comment') }}</textarea>
                @error('comment', 'commentPost_' . $post->id)
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <div class="connectly-comments-form-tools">
                    <div class="connectly-comments-form-upload">
                        <input
                            type="file"
                            name="comment_image"
                            accept="image/*"
                            class="connectly-comments-form-file"
                            id="commentImage{{ $post->id }}"
                        >
                        <label for="commentImage{{ $post->id }}" class="connectly-comments-form-file-label">
                            <i class="bi bi-image"></i>
                            <span>Add image</span>
                        </label>
                    </div>
                    <button type="submit" class="connectly-comments-form-submit">
                        <i class="bi bi-send-fill"></i>
                        Add Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.connectly-comments-page {
    min-height: 100%;
    background: #f5f5f7;
    padding: 2rem 1rem;
}

.connectly-comments-container {
    max-width: 640px;
    margin: 0 auto;
}

.connectly-comments-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.connectly-comments-back {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    text-decoration: none;
    color: #86868b;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 999px;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}

.connectly-comments-back:hover {
    color: #0071e3;
    background: rgba(0,113,227,0.06);
}

.connectly-comments-back i {
    font-size: 0.9rem;
    transition: transform 0.2s ease;
}

.connectly-comments-back:hover i {
    transform: translateX(-2px);
}

.connectly-comments-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1d1d1f;
    margin: 0;
}

.connectly-comments-post-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}

.connectly-comments-post-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.connectly-comments-post-avatar-alt {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.95rem;
    color: #fff;
    background: #0071e3;
}

.connectly-comments-post-user {
    font-weight: 700;
    font-size: 0.88rem;
    color: #1d1d1f;
    text-decoration: none;
}

.connectly-comments-post-user:hover {
    color: #0071e3;
}

.connectly-comments-post-text {
    color: #424245;
    font-size: 0.88rem;
    line-height: 1.6;
    margin: 0.4rem 0 0;
    white-space: pre-line;
}

.connectly-comments-post-images {
    display: grid;
    gap: 0.3rem;
    margin-top: 0.6rem;
    border-radius: 12px;
    overflow: hidden;
}

.connectly-comments-post-images.grid-1 {
    grid-template-columns: 1fr;
    max-height: 300px;
}

.connectly-comments-post-images.grid-2 {
    grid-template-columns: 1fr 1fr;
    max-height: 200px;
}

.connectly-comments-post-images.grid-3,
.connectly-comments-post-images.grid-4 {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    max-height: 240px;
}

.connectly-comments-post-images.grid-3 .connectly-comments-post-image-item:nth-child(1) {
    grid-row: span 2;
}

.connectly-comments-post-image-item {
    position: relative;
    overflow: hidden;
    cursor: pointer;
    border-radius: 6px;
}

.connectly-comments-post-image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.connectly-comments-post-image-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.1rem;
    font-weight: 700;
}

.connectly-comments-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.connectly-comments-item {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 1rem;
    transition: box-shadow 0.2s ease;
}

.connectly-comments-item:hover {
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}

.connectly-comments-item-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.connectly-comments-item-avatar-alt {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.8rem;
    color: #fff;
    background: #0071e3;
}

.connectly-comments-item-user {
    font-weight: 600;
    font-size: 0.82rem;
    color: #1d1d1f;
    text-decoration: none;
}

.connectly-comments-item-user:hover {
    color: #0071e3;
}

.connectly-comments-item-text {
    color: #424245;
    font-size: 0.85rem;
    line-height: 1.5;
    margin: 0.25rem 0 0;
    white-space: pre-line;
}

.connectly-comments-item-image {
    max-width: 240px;
    max-height: 180px;
    border-radius: 10px;
    object-fit: cover;
    margin-top: 0.4rem;
    cursor: pointer;
    border: 1px solid #e5e7eb;
}

.connectly-comments-reaction-btn {
    border: 1.5px solid #e5e7eb;
    background: #ffffff;
    border-radius: 999px;
    padding: 0.2rem 0.65rem;
    font-size: 0.72rem;
    font-weight: 500;
    color: #86868b;
    transition: all 0.2s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
}

.connectly-comments-reaction-btn:hover {
    border-color: rgba(0,113,227,0.25);
    color: #0071e3;
    background: rgba(0,113,227,0.04);
}

.connectly-comments-reaction-btn.active {
    background: #0071e3;
    border-color: #0071e3;
    color: #fff;
}

.connectly-comments-reply-btn {
    border: none;
    background: transparent;
    color: #86868b;
    font-size: 0.72rem;
    font-weight: 500;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.connectly-comments-reply-btn:hover {
    color: #0071e3;
    background: rgba(0,113,227,0.06);
}

.connectly-comments-replies {
    margin-top: 0.75rem;
    margin-left: 0.5rem;
    padding-left: 0.75rem;
    border-left: 2px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.connectly-comments-reply-item {
    padding: 0.75rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #fafbfc;
}

.connectly-comments-empty {
    text-align: center;
    padding: 2.5rem 1rem;
    color: #aeaeb2;
}

.connectly-comments-empty i {
    font-size: 2rem;
    display: block;
    margin-bottom: 0.5rem;
}

.connectly-comments-empty p {
    font-size: 0.88rem;
    margin: 0;
}

.connectly-comments-form-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}

.connectly-comments-reply-indicator {
    display: flex !important;
    align-items: center;
    gap: 8px;
    padding: 0.5rem 0.75rem;
    margin-bottom: 0.75rem;
    background: rgba(0,113,227,0.06);
    border: 1px solid rgba(0,113,227,0.15);
    border-radius: 10px;
    color: #0071e3;
    font-size: 0.8rem;
    font-weight: 500;
}

.connectly-comments-reply-indicator.d-none {
    display: none !important;
}

.connectly-comments-form-textarea {
    width: 100%;
    border-radius: 12px;
    border: 1.5px solid #d2d2d7;
    padding: 0.85rem 1rem;
    resize: vertical;
    font-size: 0.85rem;
    background: #f5f5f7;
    color: #1d1d1f;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    line-height: 1.5;
    font-family: inherit;
}

.connectly-comments-form-textarea:focus {
    border-color: #0071e3;
    box-shadow: 0 0 0 3px rgba(0,113,227,0.1);
    background: #ffffff;
    outline: none;
}

.connectly-comments-form-textarea::placeholder {
    color: #aeaeb2;
}

.connectly-comments-form-tools {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.connectly-comments-form-upload {
    position: relative;
}

.connectly-comments-form-file {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.connectly-comments-form-file-label {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 0.85rem;
    border: 1.5px dashed #e5e7eb;
    border-radius: 999px;
    background: #f5f5f7;
    color: #86868b;
    font-size: 0.78rem;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
}

.connectly-comments-form-file-label:hover {
    border-color: #0071e3;
    background: rgba(0,113,227,0.04);
    color: #0071e3;
}

.connectly-comments-form-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.55rem 1.25rem;
    border: none;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.82rem;
    background: linear-gradient(135deg, #0071e3, #0058b3);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,113,227,0.2);
    cursor: pointer;
    transition: all 0.25s ease;
    font-family: inherit;
}

.connectly-comments-form-submit:hover {
    box-shadow: 0 6px 18px rgba(0,113,227,0.3);
    transform: translateY(-1px);
}

@media (max-width: 640px) {
    .connectly-comments-page {
        padding: 1rem 0.75rem;
    }
    .connectly-comments-post-card,
    .connectly-comments-form-card {
        padding: 1rem;
        border-radius: 16px;
    }
    .connectly-comments-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .connectly-comments-item {
        padding: 0.85rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.querySelector('.connectly-comments-form-textarea');
    if (textarea) {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});

document.addEventListener('change', function(e) {
    if (e.target.matches('.connectly-comments-form-file')) {
        const label = e.target.closest('.connectly-comments-form-upload')?.querySelector('span');
        if (label && e.target.files.length > 0) {
            label.textContent = '1 image selected';
        } else if (label) {
            label.textContent = 'Add image';
        }
    }
});
</script>

@endsection
