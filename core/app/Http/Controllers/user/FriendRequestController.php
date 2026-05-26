<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /**
     * Show friends list page.
     */
    public function friends()
    {
        $authId = (int) Auth::id();

        // Get accepted friends
        $friends = FriendRequest::where(function ($q) use ($authId) {
            $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
        })
        ->where('status', 'accepted')
        ->with(['sender:id,name,email,avatar_path', 'receiver:id,name,email,avatar_path'])
        ->latest()
        ->get()
        ->map(function ($request) use ($authId) {
            return (int) $request->sender_id === $authId ? $request->receiver : $request->sender;
        });

        // Get incoming pending requests (people who sent me a request)
        $incomingRequests = FriendRequest::where('receiver_id', $authId)
            ->where('status', 'pending')
            ->with('sender:id,name,email,avatar_path')
            ->latest()
            ->get();

        // Get outgoing pending requests (people I sent a request to)
        $outgoingRequests = FriendRequest::where('sender_id', $authId)
            ->where('status', 'pending')
            ->with('receiver:id,name,email,avatar_path')
            ->latest()
            ->get();

        return view('frontend.friends.index', compact('friends', 'incomingRequests', 'outgoingRequests'));
    }

    /**
     * Send a friend request to another user.
     */
    public function send(Request $request, $receiver_id)
    {
        $receiverId = (int) $receiver_id;
        $senderId = (int) Auth::id();

        if ($senderId === $receiverId) {
            return back()->with('success', 'You cannot send a friend request to yourself.');
        }

        // Check if receiver exists
        $receiver = User::find($receiverId);
        if (!$receiver) {
            return back()->with('success', 'User not found.');
        }

        // Check if a friend request already exists
        $existing = FriendRequest::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        if ($existing) {
            if ($existing->status === 'accepted') {
                return back()->with('success', 'You are already friends with this user.');
            }
            if ($existing->status === 'pending') {
                // If the receiver sent us a request, accept it automatically
                if ((int) $existing->sender_id === $receiverId) {
                    $existing->update(['status' => 'accepted']);

                    // Notify the original sender that their request was accepted
                    Notification::create([
                        'user_id' => $receiverId,
                        'from_user_id' => $senderId,
                        'type' => 'friend_request_accepted',
                        'message' => Auth::user()->name . ' accepted your friend request.',
                        'link' => route('profile.show', $senderId),
                    ]);

                    return back()->with('success', 'Friend request accepted!');
                }
                return back()->with('success', 'Friend request already sent.');
            }
            if ($existing->status === 'rejected') {
                // If it was rejected, update the old request to pending again
                if ((int) $existing->sender_id === $senderId) {
                    $existing->update(['status' => 'pending']);

                    Notification::create([
                        'user_id' => $receiverId,
                        'from_user_id' => $senderId,
                        'type' => 'friend_request',
                        'message' => Auth::user()->name . ' sent you a friend request.',
                        'link' => route('friends'),
                    ]);

                    return back()->with('success', 'Friend request sent!');
                }
                // Otherwise create a new request
                FriendRequest::create([
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'status' => 'pending',
                ]);

                Notification::create([
                    'user_id' => $receiverId,
                    'from_user_id' => $senderId,
                    'type' => 'friend_request',
                    'message' => Auth::user()->name . ' sent you a friend request.',
                    'link' => route('friends'),
                ]);

                return back()->with('success', 'Friend request sent!');
            }
        }

        FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        // Create notification for the receiver
        Notification::create([
            'user_id' => $receiverId,
            'from_user_id' => $senderId,
            'type' => 'friend_request',
            'message' => Auth::user()->name . ' sent you a friend request.',
            'link' => route('friends'),
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    /**
     * Accept a friend request.
     */
    public function accept($request_id)
    {
        $friendRequest = FriendRequest::findOrFail((int) $request_id);

        if ((int) $friendRequest->receiver_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($friendRequest->status !== 'pending') {
            return back()->with('success', 'This request is no longer pending.');
        }

        $friendRequest->update(['status' => 'accepted']);

        // Notify the sender that their request was accepted
        Notification::create([
            'user_id' => (int) $friendRequest->sender_id,
            'from_user_id' => (int) Auth::id(),
            'type' => 'friend_request_accepted',
            'message' => Auth::user()->name . ' accepted your friend request.',
            'link' => route('profile.show', Auth::id()),
        ]);

        return back()->with('success', 'Friend request accepted!');
    }

    /**
     * Reject a friend request.
     */
    public function reject($request_id)
    {
        $friendRequest = FriendRequest::findOrFail((int) $request_id);

        if ((int) $friendRequest->receiver_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($friendRequest->status !== 'pending') {
            return back()->with('success', 'This request is no longer pending.');
        }

        $friendRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Friend request rejected.');
    }

    /**
     * Cancel a sent friend request.
     */
    public function cancel($request_id)
    {
        $friendRequest = FriendRequest::findOrFail((int) $request_id);

        if ((int) $friendRequest->sender_id !== (int) Auth::id()) {
            abort(403);
        }

        $friendRequest->delete();

        return back()->with('success', 'Friend request cancelled.');
    }

    /**
     * Unfriend a user.
     */
    public function unfriend($user_id)
    {
        $userId = (int) $user_id;
        $authId = (int) Auth::id();

        $friendship = FriendRequest::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })->where('status', 'accepted')->first();

        if (!$friendship) {
            return back()->with('success', 'You are not friends with this user.');
        }

        $friendship->delete();

        return back()->with('success', 'Unfriended successfully.');
    }
}
