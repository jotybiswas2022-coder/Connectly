<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private const REACTION_TYPES = [
        'like' => 'Like',
        'love' => 'Love',
        'haha' => 'Haha',
        'wow' => 'Wow',
        'sad' => 'Sad',
    ];

    public function showProfile($user_id)
    {
        $user = User::findOrFail((int) $user_id);
        $viewerId = (int) Auth::id();
        $isOwner = $viewerId === (int) $user->id;

        // Determine friend request status
        $friendRequest = null;
        $friendStatus = null;
        if (!$isOwner) {
            $friendRequest = FriendRequest::where(function ($q) use ($viewerId, $user) {
                $q->where('sender_id', $viewerId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($viewerId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $viewerId);
            })->first();

            if ($friendRequest) {
                $friendStatus = $friendRequest->status;
            }
        }

        $posts = Post::query()
            ->where('user_id', $user->id)
            ->with([
                'user:id,name,avatar_path',
                'comments' => function ($query) {
                    $query->latest()->with('user:id,name,avatar_path');
                },
                'reactions' => function ($query) use ($viewerId) {
                    $query->where('user_id', $viewerId);
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
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();

        // Friend count for the profile user
        $friendsCount = FriendRequest::where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        })
        ->where('status', 'accepted')
        ->count();

        $reactionTypes = self::REACTION_TYPES;

        return view('frontend.profile.index', compact('user', 'posts', 'reactionTypes', 'isOwner', 'friendRequest', 'friendStatus', 'friendsCount'));
    }

    public function showSettings($user_id)
    {
        $user = User::findOrFail((int) $user_id);
        if ((int) Auth::id() !== (int) $user->id) {
            abort(403);
        }

        return view('frontend.profile.settings', compact('user'));
    }

    public function updateProfile(Request $request, $user_id)
    {
        if ((int) Auth::id() !== (int) $user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_avatar' => 'nullable|boolean',
        ]);

        $user = User::findOrFail((int) $user_id);
        $user->name = trim((string) $validated['name']);
        $user->bio = $validated['bio'] ? trim((string) $validated['bio']) : null;

        $removeAvatar = (bool) ($validated['remove_avatar'] ?? false);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        } elseif ($removeAvatar && $user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
        }

        $user->save();

        return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully.');
    }

    public function togglePinPost($user_id, Post $post)
    {
        if ((int) Auth::id() !== (int) $user_id || (int) $post->user_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($post->is_pinned) {
            $post->update(['is_pinned' => false]);
            return redirect()->route('profile.show', $user_id)->with('success', 'Post unpinned.');
        }

        $pinnedCount = Post::query()
            ->where('user_id', (int) Auth::id())
            ->where('is_pinned', true)
            ->count();

        if ($pinnedCount >= 3) {
            return redirect()->route('profile.show', $user_id)->with('success', 'You can pin maximum 3 posts.');
        }

        $post->update(['is_pinned' => true]);
        return redirect()->route('profile.show', $user_id)->with('success', 'Post pinned successfully.');
    }
}
