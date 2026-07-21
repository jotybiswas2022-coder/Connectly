<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{
    private const REACTION_TYPES = [
        'like' => 'Like',
        'love' => 'Love',
        'haha' => 'Haha',
        'wow' => 'Wow',
        'sad' => 'Sad',
    ];

    public function feed()
    {
        $userId = (int) Auth::id();

        $posts = Post::query()
            ->with([
                'user:id,name,avatar_path',
                'comments' => function ($query) use ($userId) {
                    $query->whereNull('parent_id')
                        ->latest()
                        ->with([
                            'user:id,name,avatar_path',
                            'reactions' => function ($reactionQuery) use ($userId) {
                                $reactionQuery->where('user_id', $userId);
                            },
                            'replies' => function ($replyQuery) use ($userId) {
                                $replyQuery->latest()->with([
                                    'user:id,name,avatar_path',
                                    'reactions' => function ($reactionQuery) use ($userId) {
                                        $reactionQuery->where('user_id', $userId);
                                    },
                                ])->withCount([
                                    'reactions',
                                    'reactions as like_count' => function ($countQuery) {
                                        $countQuery->where('reaction_type', 'like');
                                    },
                                    'reactions as love_count' => function ($countQuery) {
                                        $countQuery->where('reaction_type', 'love');
                                    },
                                    'reactions as haha_count' => function ($countQuery) {
                                        $countQuery->where('reaction_type', 'haha');
                                    },
                                    'reactions as wow_count' => function ($countQuery) {
                                        $countQuery->where('reaction_type', 'wow');
                                    },
                                    'reactions as sad_count' => function ($countQuery) {
                                        $countQuery->where('reaction_type', 'sad');
                                    },
                                ]);
                            },
                        ])
                        ->withCount([
                            'reactions',
                            'reactions as like_count' => function ($countQuery) {
                                $countQuery->where('reaction_type', 'like');
                            },
                            'reactions as love_count' => function ($countQuery) {
                                $countQuery->where('reaction_type', 'love');
                            },
                            'reactions as haha_count' => function ($countQuery) {
                                $countQuery->where('reaction_type', 'haha');
                            },
                            'reactions as wow_count' => function ($countQuery) {
                                $countQuery->where('reaction_type', 'wow');
                            },
                            'reactions as sad_count' => function ($countQuery) {
                                $countQuery->where('reaction_type', 'sad');
                            },
                        ]);
                },
                'reactions' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])
            ->withCount([
                'comments',
                'reactions',
                'reactions as like_count' => function ($query) {
                    $query->where('reaction_type', 'like');
                },
                'reactions as love_count' => function ($query) {
                    $query->where('reaction_type', 'love');
                },
                'reactions as haha_count' => function ($query) {
                    $query->where('reaction_type', 'haha');
                },
                'reactions as wow_count' => function ($query) {
                    $query->where('reaction_type', 'wow');
                },
                'reactions as sad_count' => function ($query) {
                    $query->where('reaction_type', 'sad');
                },
            ])
            ->latest()
            ->get();

        $reactionTypes = self::REACTION_TYPES;

        return view('frontend.feed.index', compact('posts', 'reactionTypes'));
    }

    public function showComments(Post $post)
    {
        $userId = (int) Auth::id();

        $post->load([
            'user:id,name,avatar_path',
            'comments' => function ($query) use ($userId) {
                $query->whereNull('parent_id')
                    ->latest()
                    ->with([
                        'user:id,name,avatar_path',
                        'reactions' => function ($reactionQuery) use ($userId) {
                            $reactionQuery->where('user_id', $userId);
                        },
                        'replies' => function ($replyQuery) use ($userId) {
                            $replyQuery->latest()->with([
                                'user:id,name,avatar_path',
                                'reactions' => function ($reactionQuery) use ($userId) {
                                    $reactionQuery->where('user_id', $userId);
                                },
                            ])->withCount([
                                'reactions',
                                'reactions as like_count' => function ($countQuery) {
                                    $countQuery->where('reaction_type', 'like');
                                },
                                'reactions as love_count' => function ($countQuery) {
                                    $countQuery->where('reaction_type', 'love');
                                },
                                'reactions as haha_count' => function ($countQuery) {
                                    $countQuery->where('reaction_type', 'haha');
                                },
                                'reactions as wow_count' => function ($countQuery) {
                                    $countQuery->where('reaction_type', 'wow');
                                },
                                'reactions as sad_count' => function ($countQuery) {
                                    $countQuery->where('reaction_type', 'sad');
                                },
                            ]);
                        },
                    ])
                    ->withCount([
                        'reactions',
                        'reactions as like_count' => function ($countQuery) {
                            $countQuery->where('reaction_type', 'like');
                        },
                        'reactions as love_count' => function ($countQuery) {
                            $countQuery->where('reaction_type', 'love');
                        },
                        'reactions as haha_count' => function ($countQuery) {
                            $countQuery->where('reaction_type', 'haha');
                        },
                        'reactions as wow_count' => function ($countQuery) {
                            $countQuery->where('reaction_type', 'wow');
                        },
                        'reactions as sad_count' => function ($countQuery) {
                            $countQuery->where('reaction_type', 'sad');
                        },
                    ]);
            },
            'reactions' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            },
        ])
        ->loadCount([
            'comments',
            'reactions',
            'reactions as like_count' => function ($query) {
                $query->where('reaction_type', 'like');
            },
            'reactions as love_count' => function ($query) {
                $query->where('reaction_type', 'love');
            },
            'reactions as haha_count' => function ($query) {
                $query->where('reaction_type', 'haha');
            },
            'reactions as wow_count' => function ($query) {
                $query->where('reaction_type', 'wow');
            },
            'reactions as sad_count' => function ($query) {
                $query->where('reaction_type', 'sad');
            },
        ]);

        $reactionTypes = self::REACTION_TYPES;

        return view('frontend.feed.comments', compact('post', 'reactionTypes'));
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required_without:images|nullable|string|max:600',
            'images' => 'sometimes|nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $content = isset($validated['content']) ? trim((string) $validated['content']) : '';
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $imagePaths[] = $image->store('posts', 'public');
                }
            }
        }

        Post::create([
            'user_id' => (int) Auth::id(),
            'content' => $content,
            'images' => !empty($imagePaths) ? $imagePaths : null,
        ]);

        return back()->with('success', 'Post published successfully.');
    }

    public function editPost(Post $post)
    {
        if ((int) $post->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $reactionTypes = self::REACTION_TYPES;

        return view('frontend.feed.edit', compact('post', 'reactionTypes'));
    }

    public function updatePost(Request $request, Post $post)
    {
        if ((int) $post->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'edit_content' => 'nullable|string|max:600',
            'edit_images' => 'sometimes|nullable|array',
            'edit_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('feed.posts.edit', $post->id)
                ->withErrors($validator, 'editPost_' . $post->id)
                ->withInput();
        }

        $validated = $validator->validated();

        $content = isset($validated['edit_content']) ? trim((string) $validated['edit_content']) : '';
        $currentImages = $post->images ?? [];
        $removeImages = $validated['remove_images'] ?? [];

        // Remove selected images from storage
        foreach ($removeImages as $removePath) {
            if (in_array($removePath, $currentImages)) {
                Storage::disk('public')->delete($removePath);
                $currentImages = array_values(array_filter($currentImages, fn($p) => $p !== $removePath));
            }
        }

        // Add new images
        if ($request->hasFile('edit_images')) {
            foreach ($request->file('edit_images') as $image) {
                if ($image && $image->isValid()) {
                    $currentImages[] = $image->store('posts', 'public');
                }
            }
        }

        if ($content === '' && empty($currentImages)) {
            return redirect()->route('feed.posts.edit', $post->id)
                ->withErrors(['edit_content' => 'Post cannot be empty.'], 'editPost_' . $post->id)
                ->withInput();
        }

        $post->update([
            'content' => $content,
            'images' => !empty($currentImages) ? $currentImages : null,
        ]);

        return redirect()->route('feed')->with('success', 'Post updated successfully.');
    }

    public function deletePost(Post $post)
    {
        if ((int) $post->user_id !== (int) Auth::id()) {
            abort(403);
        }

        // Delete all images from storage
        $images = $post->images ?? [];
        foreach ($images as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }

    public function toggleReaction(Request $request, Post $post)
    {
        $validated = $request->validate([
            'reaction_type' => 'nullable|string|in:like,love,haha,wow,sad',
        ]);

        $selectedReaction = $validated['reaction_type'] ?? 'like';
        $currentReactionType = null;
        $message = 'Reaction added.';

        $reaction = PostReaction::where('post_id', $post->id)
            ->where('user_id', (int) Auth::id())
            ->first();

        if ($reaction) {
            if ($reaction->reaction_type === $selectedReaction) {
                $reaction->delete();
                $message = 'Reaction removed.';
            } else {
                $reaction->update(['reaction_type' => $selectedReaction]);
                $currentReactionType = $selectedReaction;
                $message = 'Reaction updated.';
            }
        } else {
            PostReaction::create([
                'post_id' => $post->id,
                'user_id' => (int) Auth::id(),
                'reaction_type' => $selectedReaction,
            ]);
            $currentReactionType = $selectedReaction;
        }

        // Notify post owner on new/updated reaction (unless reacting to own post)
        $postOwnerId = (int) $post->user_id;
        $authId = (int) Auth::id();
        if ($currentReactionType !== null && $postOwnerId !== $authId) {
            $reactionLabel = self::REACTION_TYPES[$selectedReaction] ?? $selectedReaction;
            Notification::create([
                'user_id' => $postOwnerId,
                'from_user_id' => $authId,
                'type' => 'post_reaction',
                'message' => Auth::user()->name . ' reacted with ' . $reactionLabel . ' to your post.',
                'link' => route('feed'),
            ]);
        }

        if ($request->expectsJson() || $request->ajax()) {
            $reactionCounts = $this->reactionCountsForPost((int) $post->id);

            return response()->json([
                'success' => true,
                'message' => $message,
                'post_id' => (int) $post->id,
                'current_reaction' => $currentReactionType,
                'reaction_counts' => $reactionCounts,
                'total_reactions' => array_sum($reactionCounts),
            ]);
        }

        return back()->with('success', $message);
    }

    public function storeComment(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'nullable|string|max:500',
            'comment_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'parent_id' => 'nullable|integer|exists:post_comments,id',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->route('feed.posts.comments', $post->id)
                ->withErrors($validator, 'commentPost_' . $post->id)
                ->withInput();
        }

        $validated = $validator->validated();
        $commentText = isset($validated['comment']) ? trim((string) $validated['comment']) : '';
        $imagePath = null;

        if ($request->hasFile('comment_image')) {
            $imagePath = $request->file('comment_image')->store('comments', 'public');
        }

        if ($commentText === '' && !$imagePath) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please write a comment or upload an image.',
                    'errors' => ['comment' => ['Please write a comment or upload an image.']],
                ], 422);
            }

            return redirect()->route('feed.posts.comments', $post->id)
                ->withErrors(['comment' => 'Please write a comment or upload an image.'], 'commentPost_' . $post->id)
                ->withInput();
        }

        $parentId = isset($validated['parent_id']) ? (int) $validated['parent_id'] : null;

        if ($parentId !== null) {
            $parentComment = PostComment::query()
                ->where('id', $parentId)
                ->where('post_id', $post->id)
                ->first();

            if (!$parentComment) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid reply target.',
                        'errors' => ['comment' => ['Invalid reply target.']],
                    ], 422);
                }

            return redirect()->route('feed.posts.comments', $post->id)
                ->withErrors(['comment' => 'Invalid reply target.'], 'commentPost_' . $post->id)
                ->withInput();
            }
        }

        $comment = PostComment::create([
            'post_id' => $post->id,
            'parent_id' => $parentId,
            'user_id' => (int) Auth::id(),
            'comment' => $commentText,
            'image_path' => $imagePath,
        ]);

        // Notify post owner on new comment (unless commenting on own post)
        $authId = (int) Auth::id();
        $postOwnerId = (int) $post->user_id;
        if ($postOwnerId !== $authId) {
            Notification::create([
                'user_id' => $postOwnerId,
                'from_user_id' => $authId,
                'type' => 'post_comment',
                'message' => Auth::user()->name . ' commented on your post.',
                'link' => route('feed'),
            ]);
        }

        // If replying to a comment, also notify the comment author (unless it's the same person)
        if ($parentId !== null) {
            $parentCommentUser = PostComment::where('id', $parentId)->value('user_id');
            if ($parentCommentUser !== null && (int) $parentCommentUser !== $authId && (int) $parentCommentUser !== $postOwnerId) {
                Notification::create([
                    'user_id' => (int) $parentCommentUser,
                    'from_user_id' => $authId,
                    'type' => 'post_comment',
                    'message' => Auth::user()->name . ' replied to your comment.',
                    'link' => route('feed'),
                ]);
            }
        }

        if ($request->expectsJson() || $request->ajax()) {
            $comment->load('user:id,name,avatar_path');

            return response()->json([
                'success' => true,
                'post_id' => (int) $post->id,
                'comment' => [
                    'id' => (int) $comment->id,
                    'parent_id' => $comment->parent_id ? (int) $comment->parent_id : null,
                    'root_parent_id' => $comment->parent_id ? (int) $comment->parent_id : null,
                    'user_id' => (int) $comment->user_id,
                    'user_name' => (string) ($comment->user->name ?? 'User'),
                    'user_avatar_url' => $comment->user && $comment->user->avatar_path
                        ? route('media.show', ['path' => $comment->user->avatar_path])
                        : null,
                    'comment' => (string) ($comment->comment ?? ''),
                    'image_url' => $comment->image_path
                        ? route('media.show', ['path' => $comment->image_path])
                        : null,
                    'created_at_human' => $comment->created_at->diffForHumans(),
                    'reactions_count' => 0,
                    'reaction_counts' => [
                        'like' => 0,
                        'love' => 0,
                        'haha' => 0,
                        'wow' => 0,
                        'sad' => 0,
                    ],
                ],
            ]);
        }

        return redirect()->route('feed.posts.comments', $post->id)->with('success', 'Comment added.');
    }

    public function toggleCommentReaction(Request $request, PostComment $comment)
    {
        $validated = $request->validate([
            'reaction_type' => 'nullable|string|in:like,love,haha,wow,sad',
        ]);

        $selectedReaction = $validated['reaction_type'] ?? 'like';
        $currentReactionType = null;

        $reaction = PostCommentReaction::where('post_comment_id', $comment->id)
            ->where('user_id', (int) Auth::id())
            ->first();

        if ($reaction) {
            if ($reaction->reaction_type === $selectedReaction) {
                $reaction->delete();
            } else {
                $reaction->update(['reaction_type' => $selectedReaction]);
                $currentReactionType = $selectedReaction;
            }
        } else {
            PostCommentReaction::create([
                'post_comment_id' => $comment->id,
                'user_id' => (int) Auth::id(),
                'reaction_type' => $selectedReaction,
            ]);
            $currentReactionType = $selectedReaction;
        }

        // Notify comment author on new/updated reaction (unless reacting to own comment)
        $commentAuthorId = (int) $comment->user_id;
        $authId = (int) Auth::id();
        if ($currentReactionType !== null && $commentAuthorId !== $authId) {
            $reactionLabel = self::REACTION_TYPES[$selectedReaction] ?? $selectedReaction;
            Notification::create([
                'user_id' => $commentAuthorId,
                'from_user_id' => $authId,
                'type' => 'comment_reaction',
                'message' => Auth::user()->name . ' reacted with ' . $reactionLabel . ' to your comment.',
                'link' => route('feed'),
            ]);
        }

        if ($request->expectsJson() || $request->ajax()) {
            $reactionCounts = $this->reactionCountsForComment((int) $comment->id);

            return response()->json([
                'success' => true,
                'comment_id' => (int) $comment->id,
                'current_reaction' => $currentReactionType,
                'reaction_counts' => $reactionCounts,
                'total_reactions' => array_sum($reactionCounts),
            ]);
        }

        return redirect()->route('feed.posts.comments', $comment->post_id);
    }

    public function getReactors(Post $post)
    {
        $reactions = PostReaction::where('post_id', $post->id)
            ->with('user:id,name,avatar_path')
            ->get();

        $groups = [];
        foreach (array_keys(self::REACTION_TYPES) as $key) {
            $groups[$key] = ['count' => 0, 'users' => []];
        }

        foreach ($reactions as $reaction) {
            $type = $reaction->reaction_type;
            if (!isset($groups[$type])) continue;
            $groups[$type]['count']++;
            $groups[$type]['users'][] = [
                'id' => (int) $reaction->user->id,
                'name' => $reaction->user->name,
                'avatar_url' => $reaction->user->avatar_path
                    ? route('media.show', ['path' => $reaction->user->avatar_path])
                    : null,
            ];
        }

        return response()->json([
            'success' => true,
            'post_id' => (int) $post->id,
            'total' => $reactions->count(),
            'groups' => $groups,
        ]);
    }

    private function reactionCountsForPost(int $postId): array
    {
        $counts = array_fill_keys(array_keys(self::REACTION_TYPES), 0);

        $result = PostReaction::query()
            ->selectRaw('reaction_type, COUNT(*) as total')
            ->where('post_id', $postId)
            ->groupBy('reaction_type')
            ->pluck('total', 'reaction_type')
            ->all();

        foreach ($result as $reactionType => $total) {
            if (array_key_exists($reactionType, $counts)) {
                $counts[$reactionType] = (int) $total;
            }
        }

        return $counts;
    }

    private function reactionCountsForComment(int $commentId): array
    {
        $counts = array_fill_keys(array_keys(self::REACTION_TYPES), 0);

        $result = PostCommentReaction::query()
            ->selectRaw('reaction_type, COUNT(*) as total')
            ->where('post_comment_id', $commentId)
            ->groupBy('reaction_type')
            ->pluck('total', 'reaction_type')
            ->all();

        foreach ($result as $reactionType => $total) {
            if (array_key_exists($reactionType, $counts)) {
                $counts[$reactionType] = (int) $total;
            }
        }

        return $counts;
    }
}
