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
                         class="connectly-comments-post-avatar" loading="lazy">
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
                                <div class="connectly-comment-react" data-comment-id="{{ $comment->id }}">
                                    <form action="{{ route('feed.comments.react', $comment->id) }}" method="POST" data-comment-reaction-form="main">
                                        @csrf
                                        <input type="hidden" name="reaction_type" value="{{ $commentCurrentReactionType ?? 'like' }}" class="connectly-comment-react-input">
                                        <button type="submit" class="connectly-comment-react-btn {{ $commentCurrentReactionType ? 'is-reacted' : '' }}">
                                            <span class="connectly-comment-react-emoji">{{ $commentCurrentReactionEmoji }}</span>
                                            <span class="connectly-comment-react-label">{{ $commentCurrentReactionLabel }}</span>
                                            <span class="connectly-comment-react-count">{{ $comment->reactions_count }}</span>
                                        </button>
                                    </form>
                                    <div class="connectly-comment-react-float" aria-label="Reaction options">
                                        @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                            @php
                                                $reactionEmoji = match ($reactionKey) {
                                                    'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                                    default => '👍',
                                                };
                                            @endphp
                                            <form action="{{ route('feed.comments.react', $comment->id) }}" method="POST" data-comment-reaction-form="option">
                                                @csrf
                                                <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                <button type="submit" class="connectly-comment-react-emojibtn {{ $commentCurrentReactionType === $reactionKey ? 'active' : '' }}" data-reaction-key="{{ $reactionKey }}" title="{{ $reactionLabel }}">{{ $reactionEmoji }}</button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="connectly-comments-reply-btn chatbox-reply-trigger"
                                        data-form-id="commentForm{{ $post->id }}"
                                        data-parent-id="{{ $comment->id }}"
                                        data-reply-to-name="{{ $comment->user->name }}">
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
                                                        <div class="connectly-comment-react" data-comment-id="{{ $reply->id }}">
                                                            <form action="{{ route('feed.comments.react', $reply->id) }}" method="POST" data-comment-reaction-form="main">
                                                                @csrf
                                                                <input type="hidden" name="reaction_type" value="{{ $replyCurrentReactionType ?? 'like' }}" class="connectly-comment-react-input">
                                                                <button type="submit" class="connectly-comment-react-btn {{ $replyCurrentReactionType ? 'is-reacted' : '' }}">
                                                                    <span class="connectly-comment-react-emoji">{{ $replyCurrentReactionEmoji }}</span>
                                                                    <span class="connectly-comment-react-label">{{ $replyCurrentReactionLabel }}</span>
                                                                    <span class="connectly-comment-react-count">{{ $reply->reactions_count }}</span>
                                                                </button>
                                                            </form>
                                                            <div class="connectly-comment-react-float" aria-label="Reaction options">
                                                                @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                                                    @php
                                                                        $reactionEmoji = match ($reactionKey) {
                                                                            'love' => '❤️', 'haha' => '😆', 'wow' => '😮', 'sad' => '😢',
                                                                            default => '👍',
                                                                        };
                                                                    @endphp
                                                                    <form action="{{ route('feed.comments.react', $reply->id) }}" method="POST" data-comment-reaction-form="option">
                                                                        @csrf
                                                                        <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                                        <button type="submit" class="connectly-comment-react-emojibtn {{ $replyCurrentReactionType === $reactionKey ? 'active' : '' }}" data-reaction-key="{{ $reactionKey }}" title="{{ $reactionLabel }}">{{ $reactionEmoji }}</button>
                                                                    </form>
                                                                @endforeach
                                                            </div>
                                                            <button type="button" class="connectly-comments-reply-btn chatbox-reply-trigger"
                                                                    data-form-id="commentForm{{ $post->id }}"
                                                                    data-parent-id="{{ $reply->id }}"
                                                                    data-reply-to-name="{{ $reply->user->name }}">
                                                                <i class="bi bi-reply"></i> Reply
                                                            </button>
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

.connectly-comment-react {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.connectly-comment-react-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.7rem;
    border-radius: 999px;
    border: 1.5px solid #e5e7eb;
    background: #ffffff;
    color: #86868b;
    font-size: 0.72rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(.4,0,.2,1);
    font-family: inherit;
}

.connectly-comment-react-btn:hover {
    border-color: rgba(0,113,227,0.25);
    color: #0071e3;
    background: rgba(0,113,227,0.04);
}

.connectly-comment-react-btn.is-reacted {
    background: #0071e3;
    border-color: #0071e3;
    color: #fff;
}

.connectly-comment-react-btn.is-reacted:hover {
    background: #0058b3;
    border-color: #0058b3;
    color: #fff;
}

.connectly-comment-react-emoji {
    font-size: 0.88rem;
    line-height: 1;
}

.connectly-comment-react-count {
    font-weight: 600;
}

.connectly-comment-react-count::before {
    content: '(';
}

.connectly-comment-react-count::after {
    content: ')';
}

.connectly-comment-react-float {
    position: absolute;
    left: 0;
    bottom: calc(100% + 6px);
    display: flex;
    gap: 0.2rem;
    padding: 0.3rem 0.4rem;
    background: #ffffff;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(8px) scale(0.92);
    transition: all 0.2s cubic-bezier(.16,1,.3,1);
    z-index: 25;
}

.connectly-comment-react-float::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: -12px;
    height: 12px;
}

.connectly-comment-react:hover .connectly-comment-react-float,
.connectly-comment-react:focus-within .connectly-comment-react-float,
.connectly-comment-react-float:hover {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0) scale(1);
}

.connectly-comment-react-emojibtn {
    border: none;
    background: transparent;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    font-size: 1.1rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.15s ease, background 0.15s ease;
    cursor: pointer;
}

.connectly-comment-react-emojibtn:hover {
    transform: scale(1.3);
    background: rgba(0,113,227,0.08);
}

.connectly-comment-react-emojibtn.active {
    background: rgba(0,113,227,0.12);
    transform: scale(1.15);
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

@php
    $commentFormId = 'commentForm' . $post->id;
@endphp

<script>
function createCommentHtml(data, postId) {
    const c = data.comment;
    const avatarHtml = c.user_avatar_url
        ? `<img src="${c.user_avatar_url}" alt="" class="connectly-comments-item-avatar">`
        : `<div class="connectly-comments-item-avatar connectly-comments-item-avatar-alt">${c.user_name.charAt(0).toUpperCase()}</div>`;
    const avatarSmallHtml = c.user_avatar_url
        ? `<img src="${c.user_avatar_url}" alt="" class="connectly-comments-item-avatar" style="width:24px;height:24px;">`
        : `<div class="connectly-comments-item-avatar connectly-comments-item-avatar-alt" style="width:24px;height:24px;font-size:10px;">${c.user_name.charAt(0).toUpperCase()}</div>`;
    const commentText = c.comment ? `<p class="connectly-comments-item-text">${c.comment.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>')}</p>` : '';
    const imageHtml = c.image_url ? `<img src="${c.image_url}" alt="" class="connectly-comments-item-image" onclick="openImageModal(this.src)">` : '';

    return `<div class="connectly-comments-item" data-comment-card="${c.id}">
        <div class="d-flex align-items-start gap-2">
            ${avatarHtml}
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="/${c.user_id}/profile" class="connectly-comments-item-user">${c.user_name}</a>
                    <span class="text-muted" style="font-size:0.7rem;">${c.created_at_human}</span>
                </div>
                ${commentText}
                ${imageHtml}
                <div class="d-flex align-items-center gap-2 mt-2">
                    <div class="connectly-comment-react" data-comment-id="${c.id}">
                        <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="main">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                            <input type="hidden" name="reaction_type" value="like" class="connectly-comment-react-input">
                            <button type="submit" class="connectly-comment-react-btn">
                                <span class="connectly-comment-react-emoji">👍</span>
                                <span class="connectly-comment-react-label">Like</span>
                                <span class="connectly-comment-react-count">0</span>
                            </button>
                        </form>
                        <div class="connectly-comment-react-float" aria-label="Reaction options">
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="like">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="like" title="Like">👍</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="love">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="love" title="Love">❤️</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="haha">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="haha" title="Haha">😆</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="wow">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="wow" title="Wow">😮</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="sad">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="sad" title="Sad">😢</button>
                            </form>
                        </div>
                    </div>
                    <button type="button" class="connectly-comments-reply-btn chatbox-reply-trigger"
                            data-form-id="${c.parent_id ? 'commentForm' + postId : 'commentForm' + postId}"
                            data-parent-id="${c.id}"
                            data-reply-to-name="${c.user_name}">
                        <i class="bi bi-reply"></i> Reply
                    </button>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="like"><span class="chatbox-comment-reaction-badge-emoji">👍</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="love"><span class="chatbox-comment-reaction-badge-emoji">❤️</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="haha"><span class="chatbox-comment-reaction-badge-emoji">😆</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="wow"><span class="chatbox-comment-reaction-badge-emoji">😮</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="sad"><span class="chatbox-comment-reaction-badge-emoji">😢</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                </div>
                ${c.parent_id ? '' : `<div class="connectly-comments-replies d-none" data-replies-for="${c.id}"></div>`}
            </div>
        </div>
    </div>`;
}

function createReplyHtml(data, postId) {
    const c = data.comment;
    const avatarSmallHtml = c.user_avatar_url
        ? `<img src="${c.user_avatar_url}" alt="" class="connectly-comments-item-avatar" style="width:24px;height:24px;">`
        : `<div class="connectly-comments-item-avatar connectly-comments-item-avatar-alt" style="width:24px;height:24px;font-size:10px;">${c.user_name.charAt(0).toUpperCase()}</div>`;
    const commentText = c.comment ? `<p class="connectly-comments-item-text">${c.comment.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>')}</p>` : '';
    const imageHtml = c.image_url ? `<img src="${c.image_url}" alt="" class="connectly-comments-item-image" onclick="openImageModal(this.src)">` : '';

    return `<div class="connectly-comments-reply-item" data-comment-card="${c.id}">
        <div class="d-flex align-items-start gap-2">
            ${avatarSmallHtml}
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="/${c.user_id}/profile" class="connectly-comments-item-user">${c.user_name}</a>
                    <span class="text-muted" style="font-size:0.7rem;">${c.created_at_human}</span>
                </div>
                ${commentText}
                ${imageHtml}
                <div class="d-flex align-items-center gap-2 mt-2">
                    <div class="connectly-comment-react" data-comment-id="${c.id}">
                        <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="main">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                            <input type="hidden" name="reaction_type" value="like" class="connectly-comment-react-input">
                            <button type="submit" class="connectly-comment-react-btn">
                                <span class="connectly-comment-react-emoji">👍</span>
                                <span class="connectly-comment-react-label">Like</span>
                                <span class="connectly-comment-react-count">0</span>
                            </button>
                        </form>
                        <div class="connectly-comment-react-float" aria-label="Reaction options">
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="like">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="like" title="Like">👍</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="love">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="love" title="Love">❤️</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="haha">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="haha" title="Haha">😆</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="wow">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="wow" title="Wow">😮</button>
                            </form>
                            <form action="/feed/comments/${c.id}/react" method="POST" data-comment-reaction-form="option">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="reaction_type" value="sad">
                                <button type="submit" class="connectly-comment-react-emojibtn" data-reaction-key="sad" title="Sad">😢</button>
                            </form>
                        </div>
                    </div>
                    <button type="button" class="connectly-comments-reply-btn chatbox-reply-trigger"
                            data-form-id="commentForm${postId}"
                            data-parent-id="${c.id}"
                            data-reply-to-name="${c.user_name}">
                        <i class="bi bi-reply"></i> Reply
                    </button>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="like"><span class="chatbox-comment-reaction-badge-emoji">👍</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="love"><span class="chatbox-comment-reaction-badge-emoji">❤️</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="haha"><span class="chatbox-comment-reaction-badge-emoji">😆</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="wow"><span class="chatbox-comment-reaction-badge-emoji">😮</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                    <span class="badge rounded-pill text-bg-light border connectly-reaction-badge d-none" data-comment-reaction-badge="sad"><span class="chatbox-comment-reaction-badge-emoji">😢</span> <span class="chatbox-comment-reaction-badge-count">0</span></span>
                </div>
            </div>
        </div>
    </div>`;
}

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

document.addEventListener('submit', async function (event) {
    const form = event.target;
    if (!form.matches('[data-comment-reaction-form]')) {
        return;
    }

    event.preventDefault();

    const wrap = form.closest('.connectly-comment-react');
    if (!wrap) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const buttons = wrap.querySelectorAll('button');
    buttons.forEach((button) => { button.disabled = true; });

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

        if (!response.ok) throw new Error('Failed to submit comment reaction');
        const data = await response.json();

        const reactionMeta = {
            like: { label: 'Like', emoji: '👍' },
            love: { label: 'Love', emoji: '❤️' },
            haha: { label: 'Haha', emoji: '😆' },
            wow: { label: 'Wow', emoji: '😮' },
            sad: { label: 'Sad', emoji: '😢' },
        };

        const currentReaction = data.current_reaction;
        const mainInput = wrap.querySelector('.connectly-comment-react-input');
        const mainButton = wrap.querySelector('.connectly-comment-react-btn');
        const mainEmoji = wrap.querySelector('.connectly-comment-react-emoji');
        const mainLabel = wrap.querySelector('.connectly-comment-react-label');
        const mainCount = wrap.querySelector('.connectly-comment-react-count');

        if (mainInput) mainInput.value = currentReaction || 'like';
        if (mainButton) {
            mainButton.classList.toggle('is-reacted', !!currentReaction);
        }

        const meta = reactionMeta[currentReaction] || reactionMeta.like;
        if (mainEmoji) mainEmoji.textContent = currentReaction ? meta.emoji : reactionMeta.like.emoji;
        if (mainLabel) mainLabel.textContent = currentReaction ? meta.label : 'Like';
        if (mainCount) mainCount.textContent = String(data.total_reactions ?? 0);

        wrap.querySelectorAll('.connectly-comment-react-emojibtn').forEach((optionButton) => {
            optionButton.classList.toggle('active', optionButton.dataset.reactionKey === currentReaction);
        });

        if (data.reaction_counts) {
            Object.keys(reactionMeta).forEach((reactionKey) => {
                const badge = wrap.closest('[data-comment-id]')?.querySelector(`[data-comment-reaction-badge="${reactionKey}"]`);
                if (!badge) return;
                const count = Number(data.reaction_counts[reactionKey] || 0);
                const countEl = badge.querySelector('.chatbox-comment-reaction-badge-count');
                if (countEl) countEl.textContent = String(count);
                badge.classList.toggle('d-none', count <= 0);
            });
        }
    } catch (error) {
        console.error(error);
        if (window.chatboxToast) {
            chatboxToast('error', 'Could not update reaction. Please try again.');
        }
    } finally {
        buttons.forEach((button) => { button.disabled = false; });
    }
});

document.addEventListener('submit', async function (event) {
    const form = event.target;
    if (!form.matches('[data-comment-form-id]')) {
        return;
    }

    event.preventDefault();

    const postId = form.dataset.commentFormId;
    if (!postId) return;

    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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
            if (window.chatboxToast) {
                chatboxToast('error', errorText);
            }
            return;
        }

        const parentId = data.comment.parent_id;
        const commentList = document.querySelector('.connectly-comments-list');
        if (!commentList) return;

        if (parentId) {
            const repliesWrap = commentList.querySelector(`[data-replies-for="${parentId}"]`);
            if (repliesWrap) {
                repliesWrap.classList.remove('d-none');
                const replyHtml = createReplyHtml(data, postId);
                repliesWrap.insertAdjacentHTML('afterbegin', replyHtml);
            }
        } else {
            const emptyState = commentList.querySelector('.connectly-comments-empty');
            if (emptyState) emptyState.remove();
            const commentHtml = createCommentHtml(data, postId);
            commentList.insertAdjacentHTML('afterbegin', commentHtml);
        }

        form.reset();
        form.querySelectorAll('textarea').forEach((ta) => { ta.style.height = 'auto'; });

        const parentInput = form.querySelector('.chatbox-reply-parent-id');
        const indicator = form.querySelector('.chatbox-reply-indicator');
        if (parentInput) {
            parentInput.value = '';
            delete parentInput.dataset.replyToName;
        }
        if (indicator) indicator.classList.add('d-none');
    } catch (error) {
        console.error(error);
        if (window.chatboxToast) {
            chatboxToast('error', 'Could not add comment. Please try again.');
        }
    } finally {
        if (submitButton) submitButton.disabled = false;
    }
});

document.addEventListener('click', function (event) {
    const replyButton = event.target.closest('.chatbox-reply-trigger');
    if (replyButton) {
        const formId = replyButton.dataset.formId;
        const parentId = replyButton.dataset.parentId || '';
        const replyToName = replyButton.dataset.replyToName || '';
        if (!formId) return;

        const form = document.getElementById(formId);
        if (!form) return;

        const parentInput = form.querySelector('.chatbox-reply-parent-id');
        const indicator = form.querySelector('.chatbox-reply-indicator');
        const indicatorText = form.querySelector('.chatbox-reply-indicator-text');
        const textarea = form.querySelector('textarea[name="comment"]');

        if (parentInput) {
            parentInput.value = parentId;
            parentInput.dataset.replyToName = replyToName;
        }
        if (indicator) indicator.classList.remove('d-none');
        if (indicatorText && replyToName) {
            indicatorText.textContent = 'Replying to ' + replyToName;
        }
        if (textarea) {
            const atMention = '@' + replyToName + ' ';
            const currentVal = textarea.value;
            if (!currentVal.startsWith(atMention)) {
                if (parentInput && parentInput.dataset.replyToName && currentVal.startsWith('@' + parentInput.dataset.replyToName)) {
                    textarea.value = textarea.value.replace(/^@\S+\s*/, '');
                }
                textarea.value = atMention + textarea.value;
            }
            textarea.focus();
        }
        return;
    }

    const cancelButton = event.target.closest('.chatbox-reply-cancel');
    if (cancelButton) {
        event.preventDefault();
        const form = cancelButton.closest('form');
        if (!form) return;

        const parentInput = form.querySelector('.chatbox-reply-parent-id');
        const indicator = form.querySelector('.chatbox-reply-indicator');
        const indicatorText = form.querySelector('.chatbox-reply-indicator-text');
        const textarea = form.querySelector('textarea[name="comment"]');

        if (parentInput) {
            const name = parentInput.dataset.replyToName || '';
            if (name && textarea) {
                textarea.value = textarea.value.replace(new RegExp('^@' + name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\s*'), '');
            }
            parentInput.value = '';
            delete parentInput.dataset.replyToName;
        }
        if (indicator) indicator.classList.add('d-none');
        if (indicatorText) indicatorText.textContent = 'Replying to comment';
    }
});
</script>

@endsection
