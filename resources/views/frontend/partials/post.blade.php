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
                                                        <a
                                                            href="{{ route('feed.posts.edit', $post->id) }}"
                                                            class="dropdown-item connectly-dropdown-item"
                                                        >
                                                            <i class="bi bi-pencil-square me-2"></i>
                                                            Edit
                                                        </a>
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

                                        <a
                                            href="{{ route('feed.posts.comments', $post->id) }}"
                                            class="btn btn-sm btn-outline-secondary"
                                        >
                                            <i class="bi bi-chat-dots-fill me-1"></i>
                                            Comments (<span class="chatbox-comments-count">{{ $post->comments_count }}</span>)
                                        </a>
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



