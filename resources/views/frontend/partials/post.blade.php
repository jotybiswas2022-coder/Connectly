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
                        <article class="chatbox-feed-post-card connectly-post-card" data-pinned="{{ $post->is_pinned ? 'true' : 'false' }}">
                            <div class="d-flex align-items-start gap-3">
                                @if($post->user->avatar_path)
                                    <img src="{{ route('media.show', ['path' => $post->user->avatar_path]) }}"
                                         alt="{{ $post->user->name }} avatar"
                                         class="chatbox-feed-avatar chatbox-feed-avatar-image connectly-feed-avatar connectly-feed-avatar-image">
                                @else
                                    <div class="chatbox-feed-avatar chatbox-feed-avatar-alt">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <h6 class="mb-0 fw-bold">
                                                <a href="{{ route('profile.show', $post->user_id) }}" class="text-decoration-none chatbox-profile-link connectly-profile-link">{{ $post->user->name }}</a>
                                            </h6>
                                            <span class="text-muted small">&middot;</span>
                                            <span class="text-muted small">{{ $post->created_at->diffForHumans() }}</span>
                                            @if($post->is_pinned)
                                                <span class="chatbox-pinned-badge connectly-pinned-badge">
                                                    <i class="bi bi-pin-angle-fill"></i> Pinned
                                                </span>
                                            @endif
                                        </div>

                                        @if ((int) $post->user_id === (int) auth()->id())
                                            <div class="connectly-post-actions">
                                                <button
                                                    type="button"
                                                    class="connectly-post-actions-trigger"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                >
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end connectly-post-dropdown">
                                                    @if(isset($showPinButton) && $showPinButton)
                                                        <li>
                                                            <form action="{{ route('profile.posts.pin', ['user_id' => $post->user_id, 'post' => $post->id]) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item connectly-dropdown-item {{ $post->is_pinned ? 'text-warning' : '' }}">
                                                                    <i class="bi bi-pin-angle-fill me-2"></i>
                                                                    {{ $post->is_pinned ? 'Unpin' : 'Pin' }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                    @endif
                                                    <li>
                                                        <button
                                                            type="button"
                                                            class="dropdown-item connectly-dropdown-item"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editPostModal{{ $post->id }}"
                                                        >
                                                            <i class="bi bi-pencil-square me-2"></i>
                                                            Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('feed.posts.delete', $post->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item connectly-dropdown-item connectly-dropdown-danger btn-delete-post" data-delete-post="true">
                                                                <i class="bi bi-trash me-2"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    @if (filled($post->content))
                                        <p class="mb-3 chatbox-feed-post-text connectly-post-text">{!! nl2br(e($post->content)) !!}</p>
                                    @endif

                                    @if ($imageCount > 0)
                                        <div class="connectly-post-image-grid {{ $imageCount === 1 ? 'grid-1' : ($imageCount === 2 ? 'grid-2' : ($imageCount === 3 ? 'grid-3' : ($imageCount === 4 ? 'grid-4' : 'grid-many'))) }}">
                                            @foreach ($postImages as $index => $imgPath)
                                                @if ($index < 4 || ($index === 4 && $imageCount <= 4))
                                                    <div class="connectly-post-image-item" style="{{ $imageCount === 1 ? 'max-height: 400px;' : '' }}" onclick="openImageModal('{{ route('media.show', ['path' => $imgPath]) }}')">
                                                        <img src="{{ route('media.show', ['path' => $imgPath]) }}" alt="Post image {{ $index + 1 }}" loading="lazy">
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if ($imageCount > 4)
                                                <div class="connectly-post-image-item" onclick="openImageModal('{{ route('media.show', ['path' => $postImages[4]]) }}')">
                                                    <img src="{{ route('media.show', ['path' => $postImages[4]]) }}" alt="Post image 5" loading="lazy">
                                                    <div class="connectly-post-image-overlay">+{{ $imageCount - 4 }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="chatbox-reaction-picker connectly-reaction-picker" data-post-id="{{ $post->id }}">
                                            <form action="{{ route('feed.posts.react', $post->id) }}" method="POST" class="d-inline chatbox-main-reaction-form" data-reaction-form="main">
                                                @csrf
                                                <input type="hidden" name="reaction_type" value="{{ $currentReactionType ?? 'like' }}" class="chatbox-main-reaction-input">
                                                <button type="submit" class="btn btn-sm chatbox-main-reaction-button connectly-main-reaction-btn {{ $currentReactionType ? 'btn-primary' : 'btn-outline-primary' }}">
                                                    <span class="me-1 chatbox-main-reaction-emoji">{{ $currentReactionEmoji }}</span>
                                                    <span class="chatbox-main-reaction-label">{{ $currentReactionLabel }}</span>
                                                    (<span class="chatbox-main-reaction-count">{{ $post->reactions_count }}</span>)
                                                </button>
                                            </form>

                                            <div class="chatbox-reaction-options connectly-reaction-options" aria-label="Reaction options">
                                                @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                                    @php
                                                        $reactionEmoji = match ($reactionKey) {
                                                            'love' => '❤️',
                                                            'haha' => '😆',
                                                            'wow' => '😮',
                                                            'sad' => '😢',
                                                            default => '👍',
                                                        };
                                                    @endphp
                                                    <form action="{{ route('feed.posts.react', $post->id) }}" method="POST" class="d-inline" data-reaction-form="option">
                                                        @csrf
                                                        <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                        <button
                                                            type="submit"
                                                            class="chatbox-reaction-option connectly-reaction-option {{ $currentReactionType === $reactionKey ? 'active' : '' }}"
                                                            title="{{ $reactionLabel }}"
                                                            aria-label="{{ $reactionLabel }}"
                                                            data-reaction-key="{{ $reactionKey }}"
                                                        >
                                                            {{ $reactionEmoji }}
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </div>
                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#commentsModal{{ $post->id }}"
                                        >
                                            <i class="bi bi-chat-dots-fill me-1"></i>
                                            Comments (<span class="chatbox-comments-count">{{ $post->comments_count }}</span>)
                                        </button>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 mt-2 chatbox-reaction-summary">
                                        @foreach (array_keys($reactionTypes) as $reactionKey)
                                            @php
                                                $reactionCountField = $reactionKey . '_count';
                                                $reactionCount = (int) ($post->{$reactionCountField} ?? 0);
                                                $reactionEmoji = match ($reactionKey) {
                                                    'love' => '❤️',
                                                    'haha' => '😆',
                                                    'wow' => '😮',
                                                    'sad' => '😢',
                                                    default => '👍',
                                                };
                                            @endphp
                                            <span class="badge rounded-pill text-bg-light border connectly-reaction-badge {{ $reactionCount > 0 ? '' : 'd-none' }}" data-reaction-badge="{{ $reactionKey }}">
                                                <span class="chatbox-reaction-badge-emoji">{{ $reactionEmoji }}</span>
                                                <span class="chatbox-reaction-badge-count">{{ $reactionCount }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </article>

                        {{-- ===== EDIT POST MODAL (PREMIUM LIGHT) ===== --}}
                        @if ((int) $post->user_id === (int) auth()->id())
                            <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-pencil-square me-1" style="color:var(--feed-primary);"></i>
                                                Edit Post
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('feed.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="edit-post-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold text-muted">Post Content</label>
                                                    <textarea
                                                        name="edit_content"
                                                        class="form-control @error('edit_content', 'editPost_' . $post->id) is-invalid @enderror"
                                                        rows="4"
                                                        placeholder="Update your post..."
                                                        maxlength="600"
                                                    >{{ session('open_modal') === 'editPostModal' . $post->id ? old('edit_content', $post->content) : $post->content }}</textarea>
                                                    @error('edit_content', 'editPost_' . $post->id)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Existing Images --}}
                                                @if ($imageCount > 0)
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted">
                                                            <i class="bi bi-images me-1"></i>Current Images
                                                        </label>
                                                        <div class="connectly-edit-existing-images">
                                                            @foreach ($postImages as $imgPath)
                                                                <div class="connectly-edit-existing-item">
                                                                    <img src="{{ route('media.show', ['path' => $imgPath]) }}" alt="Post image" loading="lazy">
                                                                    <label class="connectly-edit-remove-check">
                                                                        <input type="checkbox" name="remove_images[]" value="{{ $imgPath }}" class="me-1" onchange="this.parentElement.style.opacity=this.checked?'0.6':'1'">
                                                                        Remove
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- New Images Upload --}}
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold text-muted">
                                                        <i class="bi bi-cloud-arrow-up me-1"></i>Add More Images
                                                    </label>
                                                    <div class="connectly-file-upload">
                                                        <input
                                                            type="file"
                                                            name="edit_images[]"
                                                            accept="image/*"
                                                            multiple
                                                            class="connectly-file-input connectly-edit-image-input"
                                                            id="editImageInput{{ $post->id }}"
                                                            data-preview-container="editPreview{{ $post->id }}"
                                                        >
                                                        <label for="editImageInput{{ $post->id }}" class="connectly-file-label">
                                                            <i class="bi bi-cloud-arrow-up me-2"></i>
                                                            <span>Click to add more images</span>
                                                        </label>
                                                    </div>
                                                    <div id="editPreview{{ $post->id }}" class="connectly-edit-preview-grid mt-2"></div>
                                                </div>

                                                <div class="d-flex justify-content-end gap-2 mt-4">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-check-lg me-1"></i>Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- ===== COMMENTS MODAL (PREMIUM LIGHT) ===== --}}
                        <div class="modal fade" id="commentsModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="bi bi-chat-dots-fill me-1" style="color:var(--feed-primary);"></i>
                                            Comments
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="commentsEmpty{{ $post->id }}" class="text-muted mb-3 {{ $post->comments->isEmpty() ? '' : 'd-none' }}">
                                            <i class="bi bi-chat-square-text me-1"></i>No comments yet. Be the first to comment!
                                        </p>

                                        <div id="commentsList{{ $post->id }}" class="d-flex flex-column gap-3 mb-3 {{ $post->comments->isEmpty() ? 'd-none' : '' }}">
                                            @foreach ($post->comments as $comment)
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
                                                    <div class="chatbox-comment-item connectly-comment-item" data-comment-card="{{ $comment->id }}">
                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                            @if($comment->user->avatar_path)
                                                                <img src="{{ route('media.show', ['path' => $comment->user->avatar_path]) }}"
                                                                     alt="{{ $comment->user->name }} avatar"
                                                                     class="chatbox-feed-avatar chatbox-feed-avatar-image connectly-feed-avatar connectly-feed-avatar-image" style="width: 24px; height: 24px;">
                                                            @else
                                                                <div class="chatbox-feed-avatar chatbox-feed-avatar-alt connectly-feed-avatar connectly-feed-avatar-alt" style="width: 24px; height: 24px; font-size: 11px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                            <strong><a href="{{ route('profile.show', $comment->user_id) }}" class="text-decoration-none chatbox-profile-link connectly-profile-link">{{ $comment->user->name }}</a></strong>
                                                            <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        @if (filled($comment->comment))
                                                            <p class="mb-0 connectly-post-text" style="font-size:0.88rem;">{!! nl2br(e($comment->comment)) !!}</p>
                                                        @endif

                                                        @if ($comment->image_path)
                                                            <div class="mt-2">
                                                                <img
                                                                    src="{{ route('media.show', ['path' => $comment->image_path]) }}"
                                                                    alt="Comment image"
                                                                    class="img-fluid rounded chatbox-comment-image connectly-comment-image"
                                                                    onclick="openImageModal(this.src)"
                                                                    style="cursor:pointer;"
                                                                >
                                                            </div>
                                                        @endif

                                                        <div class="d-flex align-items-center gap-2 mt-2">
                                                            <div class="chatbox-comment-reaction-picker connectly-comment-reaction-picker" data-comment-id="{{ $comment->id }}">
                                                                <form action="{{ route('feed.comments.react', $comment->id) }}" method="POST" class="d-inline" data-comment-reaction-form="main">
                                                                    @csrf
                                                                    <input type="hidden" name="reaction_type" value="{{ $commentCurrentReactionType ?? 'like' }}" class="chatbox-comment-main-reaction-input">
                                                                    <button type="submit" class="btn btn-sm chatbox-comment-main-reaction-button connectly-comment-main-reaction-btn {{ $commentCurrentReactionType ? 'btn-primary' : 'btn-outline-primary' }}">
                                                                        <span class="me-1 chatbox-comment-main-reaction-emoji">{{ $commentCurrentReactionEmoji }}</span>
                                                                        <span class="chatbox-comment-main-reaction-label">{{ $commentCurrentReactionLabel }}</span>
                                                                        (<span class="chatbox-comment-main-reaction-count">{{ $comment->reactions_count }}</span>)
                                                                    </button>
                                                                </form>

                                                                <div class="chatbox-comment-reaction-options connectly-comment-reaction-options" aria-label="Comment reaction options">
                                                                    @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                                                        @php
                                                                            $reactionEmoji = match ($reactionKey) {
                                                                                'love' => '❤️',
                                                                                'haha' => '😆',
                                                                                'wow' => '😮',
                                                                                'sad' => '😢',
                                                                                default => '👍',
                                                                            };
                                                                        @endphp
                                                                        <form action="{{ route('feed.comments.react', $comment->id) }}" method="POST" class="d-inline" data-comment-reaction-form="option">
                                                                            @csrf
                                                                            <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                                            <button
                                                                                type="submit"
                                                                                class="chatbox-comment-reaction-option connectly-comment-reaction-option {{ $commentCurrentReactionType === $reactionKey ? 'active' : '' }}"
                                                                                title="{{ $reactionLabel }}"
                                                                                aria-label="{{ $reactionLabel }}"
                                                                                data-reaction-key="{{ $reactionKey }}"
                                                                            >
                                                                                {{ $reactionEmoji }}
                                                                            </button>
                                                                        </form>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-outline-secondary chatbox-reply-trigger connectly-reply-trigger"
                                                                data-form-id="commentForm{{ $post->id }}"
                                                                data-parent-id="{{ $comment->id }}"
                                                            >
                                                                Reply
                                                            </button>
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                                                            @foreach (array_keys($reactionTypes) as $reactionKey)
                                                                @php
                                                                    $reactionCountField = $reactionKey . '_count';
                                                                    $reactionCount = (int) ($comment->{$reactionCountField} ?? 0);
                                                                    $reactionEmoji = match ($reactionKey) {
                                                                        'love' => '❤️',
                                                                        'haha' => '😆',
                                                                        'wow' => '😮',
                                                                        'sad' => '😢',
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
                                                        <div class="chatbox-comment-replies connectly-comment-replies mt-3 {{ $comment->replies->isEmpty() ? 'd-none' : '' }}" data-replies-for="{{ $comment->id }}">
                                                            @foreach ($comment->replies as $reply)
                                                                    @php
                                                                        $replyUserReaction = $reply->reactions->first();
                                                                        $replyCurrentReactionType = $replyUserReaction?->reaction_type;
                                                                        $replyCurrentReactionLabel = $replyCurrentReactionType ? ($reactionTypes[$replyCurrentReactionType] ?? 'Like') : 'Like';
                                                                        $replyCurrentReactionEmoji = match ($replyCurrentReactionType) {
                                                                            'love' => '❤️',
                                                                            'haha' => '😆',
                                                                            'wow' => '😮',
                                                                            'sad' => '😢',
                                                                            default => '👍',
                                                                        };
                                                                    @endphp
                                                                    <div class="chatbox-comment-reply-item connectly-comment-reply-item mt-2" data-comment-card="{{ $reply->id }}">
                                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                                            @if($reply->user->avatar_path)
                                                                                <img src="{{ route('media.show', ['path' => $reply->user->avatar_path]) }}"
                                                                                     alt="{{ $reply->user->name }} avatar"
                                                                                     class="chatbox-feed-avatar chatbox-feed-avatar-image connectly-feed-avatar connectly-feed-avatar-image" style="width: 24px; height: 24px;">
                                                                            @else
                                                                                <div class="chatbox-feed-avatar chatbox-feed-avatar-alt connectly-feed-avatar connectly-feed-avatar-alt" style="width: 24px; height: 24px; font-size: 11px; display: flex; align-items: center; justify-content: center;">
                                                                                    {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                                                </div>
                                                                            @endif
                                                                            <strong><a href="{{ route('profile.show', $reply->user_id) }}" class="text-decoration-none chatbox-profile-link connectly-profile-link">{{ $reply->user->name }}</a></strong>
                                                                            <span class="text-muted small">{{ $reply->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        @if (filled($reply->comment))
                                                                            <p class="mb-0 connectly-post-text" style="font-size:0.88rem;">{!! nl2br(e($reply->comment)) !!}</p>
                                                                        @endif

                                                                        @if ($reply->image_path)
                                                                            <div class="mt-2">
                                                                                <img
                                                                                    src="{{ route('media.show', ['path' => $reply->image_path]) }}"
                                                                                    alt="Reply image"
                                                                                    class="img-fluid rounded chatbox-comment-image connectly-comment-image"
                                                                                    onclick="openImageModal(this.src)"
                                                                                    style="cursor:pointer;"
                                                                                >
                                                                            </div>
                                                                        @endif

                                                                        <div class="d-flex align-items-center gap-2 mt-2">
                                                                            <div class="chatbox-comment-reaction-picker connectly-comment-reaction-picker" data-comment-id="{{ $reply->id }}">
                                                                                <form action="{{ route('feed.comments.react', $reply->id) }}" method="POST" class="d-inline" data-comment-reaction-form="main">
                                                                                    @csrf
                                                                                    <input type="hidden" name="reaction_type" value="{{ $replyCurrentReactionType ?? 'like' }}" class="chatbox-comment-main-reaction-input">
                                                                                    <button type="submit" class="btn btn-sm chatbox-comment-main-reaction-button connectly-comment-main-reaction-btn {{ $replyCurrentReactionType ? 'btn-primary' : 'btn-outline-primary' }}">
                                                                                        <span class="me-1 chatbox-comment-main-reaction-emoji">{{ $replyCurrentReactionEmoji }}</span>
                                                                                        <span class="chatbox-comment-main-reaction-label">{{ $replyCurrentReactionLabel }}</span>
                                                                                        (<span class="chatbox-comment-main-reaction-count">{{ $reply->reactions_count }}</span>)
                                                                                    </button>
                                                                                </form>

                                                                                <div class="chatbox-comment-reaction-options connectly-comment-reaction-options" aria-label="Reply reaction options">
                                                                                    @foreach ($reactionTypes as $reactionKey => $reactionLabel)
                                                                                        @php
                                                                                            $reactionEmoji = match ($reactionKey) {
                                                                                                'love' => '❤️',
                                                                                                'haha' => '😆',
                                                                                                'wow' => '😮',
                                                                                                'sad' => '😢',
                                                                                                default => '👍',
                                                                                            };
                                                                                        @endphp
                                                                                        <form action="{{ route('feed.comments.react', $reply->id) }}" method="POST" class="d-inline" data-comment-reaction-form="option">
                                                                                            @csrf
                                                                                            <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                                                            <button
                                                                                                type="submit"
                                                                                                class="chatbox-comment-reaction-option connectly-comment-reaction-option {{ $replyCurrentReactionType === $reactionKey ? 'active' : '' }}"
                                                                                                title="{{ $reactionLabel }}"
                                                                                                aria-label="{{ $reactionLabel }}"
                                                                                                data-reaction-key="{{ $reactionKey }}"
                                                                                            >
                                                                                                {{ $reactionEmoji }}
                                                                                            </button>
                                                                                        </form>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>

                                                                            <button
                                                                                type="button"
                                                                                class="btn btn-sm btn-outline-secondary chatbox-reply-trigger connectly-reply-trigger"
                                                                                data-form-id="commentForm{{ $post->id }}"
                                                                                data-parent-id="{{ $comment->id }}"
                                                                            >
                                                                                Reply
                                                                            </button>
                                                                        </div>

                                                                        <div class="d-flex flex-wrap gap-2 mt-2 chatbox-comment-reaction-summary">
                                                                            @foreach (array_keys($reactionTypes) as $reactionKey)
                                                                                @php
                                                                                    $reactionCountField = $reactionKey . '_count';
                                                                                    $reactionCount = (int) ($reply->{$reactionCountField} ?? 0);
                                                                                    $reactionEmoji = match ($reactionKey) {
                                                                                        'love' => '❤️',
                                                                                        'haha' => '😆',
                                                                                        'wow' => '😮',
                                                                                        'sad' => '😢',
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
                                                            @endforeach
                                                        </div>
                                                    </div>
                                            @endforeach
                                        </div>

                                        {{-- Comment Form --}}
                                        <form action="{{ route('feed.posts.comments.store', $post->id) }}" method="POST" enctype="multipart/form-data" id="commentForm{{ $post->id }}" data-comment-form-id="{{ $post->id }}">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="" class="chatbox-reply-parent-id">

                                            <div class="d-none chatbox-reply-indicator connectly-reply-indicator" role="alert">
                                                <i class="bi bi-reply-fill chatbox-reply-indicator-icon"></i>
                                                <span class="chatbox-reply-indicator-text">Replying to comment</span>
                                                <button type="button" class="chatbox-reply-cancel-btn chatbox-reply-cancel">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>

                                            <textarea
                                                name="comment"
                                                class="form-control @error('comment', 'commentPost_' . $post->id) is-invalid @enderror"
                                                rows="3"
                                                placeholder="Write a comment..."
                                                maxlength="500"
                                            >{{ session('open_modal') === 'commentsModal' . $post->id ? old('comment') : '' }}</textarea>
                                            @error('comment', 'commentPost_' . $post->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <div class="mt-2">
                                                <div class="chatbox-file-input-wrapper connectly-file-input-wrapper">
                                                    <input
                                                        type="file"
                                                        name="comment_image"
                                                        accept="image/*"
                                                        class="chatbox-file-input @error('comment_image', 'commentPost_' . $post->id) is-invalid @enderror"
                                                        id="commentImage{{ $post->id }}"
                                                    >
                                                    <label for="commentImage{{ $post->id }}" class="chatbox-file-label connectly-file-label-comment">
                                                        <i class="bi bi-image me-2"></i>
                                                        <span>Add an image (optional)</span>
                                                    </label>
                                                </div>
                                                @error('comment_image', 'commentPost_' . $post->id)
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn chatbox-comment-submit-btn connectly-comment-submit-btn">
                                                    <i class="bi bi-send-fill me-1"></i>
                                                    Add Comment
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


