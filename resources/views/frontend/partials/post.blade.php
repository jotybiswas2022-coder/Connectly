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
                        <article class="connectly-post-card" data-pinned="{{ $post->is_pinned ? 'true' : 'false' }}">
                            <div class="d-flex align-items-start gap-3">
                                @if($post->user->avatar_path)
                                    <img src="{{ route('media.show', ['path' => $post->user->avatar_path]) }}"
                                         alt="{{ $post->user->name }} avatar"
                                         class="connectly-post-avatar connectly-feed-avatar-image"
                                         loading="lazy">
                                @else
                                    <div class="connectly-post-avatar connectly-post-avatar-fallback">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="flex-grow-1" style="min-width:0;">
                                    {{-- Post Header --}}
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <h6 class="mb-0 fw-bold connectly-post-user-name">
                                                <a href="{{ route('profile.show', $post->user_id) }}" class="text-decoration-none">{{ $post->user->name }}</a>
                                            </h6>
                                            <span class="connectly-post-time-dot">&middot;</span>
                                            <span class="connectly-post-time">{{ $post->created_at->diffForHumans() }}</span>
                                            @if($post->is_pinned)
                                                <span class="connectly-post-pin-badge">
                                                    <i class="bi bi-pin-angle-fill"></i> Pinned
                                                </span>
                                            @endif
                                        </div>

                                        @if ((int) $post->user_id === (int) auth()->id())
                                            <div class="connectly-post-actions-dropdown">
                                                <button
                                                    type="button"
                                                    class="connectly-post-actions-trigger"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                >
                                                    <i class="bi bi-three-dots"></i>
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

                                    {{-- Post Content --}}
                                    @if (filled($post->content))
                                        <p class="mb-3 connectly-post-text">{!! nl2br(e($post->content)) !!}</p>
                                    @endif

                                    {{-- Post Images --}}
                                    @if ($imageCount > 0)
                                        <div class="connectly-post-images {{ $imageCount === 1 ? 'img-1' : ($imageCount === 2 ? 'img-2' : ($imageCount === 3 ? 'img-3' : ($imageCount === 4 ? 'img-4' : 'img-many'))) }}">
                                            @foreach ($postImages as $index => $imgPath)
                                                @if ($index < 4 || ($index === 4 && $imageCount <= 4))
                                                    <div class="connectly-post-image-wrap" onclick="openImageModal('{{ route('media.show', ['path' => $imgPath]) }}')">
                                                        <img src="{{ route('media.show', ['path' => $imgPath]) }}" alt="Post image {{ $index + 1 }}" loading="lazy">
                                                        <div class="connectly-post-image-shimmer"></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if ($imageCount > 4)
                                                <div class="connectly-post-image-wrap" onclick="openImageModal('{{ route('media.show', ['path' => $postImages[4]]) }}')">
                                                    <img src="{{ route('media.show', ['path' => $postImages[4]]) }}" alt="Post image 5" loading="lazy">
                                                    <div class="connectly-post-image-overlay">+{{ $imageCount - 4 }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Action Bar --}}
                                    <div class="connectly-post-actions-bar">
                                        {{-- Reaction Button --}}
                                        <div class="connectly-reaction-wrap" data-post-id="{{ $post->id }}">
                                            <form action="{{ route('feed.posts.react', $post->id) }}" method="POST" data-reaction-form="main">
                                                @csrf
                                                <input type="hidden" name="reaction_type" value="{{ $currentReactionType ?? 'like' }}" class="connectly-react-input">
                                                <button type="submit" class="connectly-react-btn {{ $currentReactionType ? 'is-reacted' : '' }}">
                                                    <span class="connectly-react-emoji">{{ $currentReactionEmoji }}</span>
                                                    <span class="connectly-react-label">{{ $currentReactionLabel }}</span>
                                                    @if($post->reactions_count > 0)
                                                        <span class="connectly-react-count">{{ $post->reactions_count }}</span>
                                                    @endif
                                                </button>
                                            </form>

                                            <div class="connectly-react-float" aria-label="Reaction options">
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
                                                    <form action="{{ route('feed.posts.react', $post->id) }}" method="POST" data-reaction-form="option">
                                                        @csrf
                                                        <input type="hidden" name="reaction_type" value="{{ $reactionKey }}">
                                                        <button
                                                            type="submit"
                                                            class="connectly-react-emojibtn {{ $currentReactionType === $reactionKey ? 'active' : '' }}"
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

                                        {{-- Comment Button --}}
                                        <a
                                            href="{{ route('feed.posts.comments', $post->id) }}"
                                            class="connectly-comment-link"
                                        >
                                            <i class="bi bi-chat-dots"></i>
                                            <span>Comment</span>
                                            @if($post->comments_count > 0)
                                                <span class="connectly-comment-count">{{ $post->comments_count }}</span>
                                            @endif
                                        </a>
                                    </div>

                                    {{-- Reaction Summary --}}
                                    @php
                                        $hasReactions = false;
                                        foreach (array_keys($reactionTypes) as $reactionKey) {
                                            $reactionCountField = $reactionKey . '_count';
                                            if ((int) ($post->{$reactionCountField} ?? 0) > 0) { $hasReactions = true; break; }
                                        }
                                    @endphp
                                    @if ($hasReactions)
                                        <div class="connectly-reaction-summary">
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
                                                <span class="connectly-reaction-badge {{ $reactionCount > 0 ? '' : 'd-none' }}" data-reaction-badge="{{ $reactionKey }}">
                                                    <span class="connectly-reaction-badge-emoji">{{ $reactionEmoji }}</span>
                                                    <span class="connectly-reaction-badge-count">{{ $reactionCount }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>


