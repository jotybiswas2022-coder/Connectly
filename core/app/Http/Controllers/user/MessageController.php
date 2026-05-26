<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function media($path)
    {
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);
        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath);
    }

    public function message($user_id)
    {
        $recipient = User::findOrFail($user_id);
        $messages = $this->conversationMessages((int) $user_id);

        return view('frontend.message', compact('user_id', 'recipient', 'messages'));
    }

    public function fetchMessages(Request $request, $user_id)
    {
        User::findOrFail($user_id);

        $afterId = max(0, (int) $request->query('after', 0));
        $messages = $this->conversationMessages((int) $user_id)
            ->filter(fn ($msg) => (int) $msg->id > $afterId)
            ->values();

        return response()->json([
            'html' => $this->renderMessageRows($messages, (int) $user_id),
            'last_id' => $messages->isNotEmpty()
                ? (int) $messages->last()->id
                : $afterId,
        ]);
    }

    public function sendMessage(Request $request, $user_id)
    {
        User::findOrFail($user_id);

        if (is_array($request->input('message'))) {
            $request->merge(['message' => null]);
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if (!$request->filled('message') && !$request->hasFile('image')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Please provide a message or attach an image.',
                ], 422);
            }

            return back()->withErrors(['message' => 'Please provide a message or attach an image.']);
        }

        $filePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Uploaded image is not valid.'], 422);
                }

                return back()->with('error', 'Uploaded image is not valid.');
            }

            try {
                $filePath = $file->store('messages', 'public');
            } catch (\Exception $e) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Failed to save image.'], 500);
                }

                return back()->with('error', 'Failed to save image.');
            }
        }

        $messageText = $request->input('message');
        if ($messageText !== null) {
            $messageText = trim($messageText);
            if ($messageText === '') {
                $messageText = null;
            }
        }

        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $user_id,
            'message' => $messageText,
            'image_path' => $filePath,
        ]);

        // Create notification for the recipient (unless sending to self)
        if ((int) $user_id !== (int) auth()->id()) {
            $preview = $messageText !== null ? Str::limit($messageText, 60) : 'sent an image.';
            Notification::create([
                'user_id' => (int) $user_id,
                'from_user_id' => (int) auth()->id(),
                'type' => 'new_message',
                'message' => auth()->user()->name . ' sent you a message: ' . $preview,
                'link' => route('message', auth()->id()),
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'html' => $this->renderMessageRows(collect([$message]), (int) $user_id),
                'message_id' => (int) $message->id,
            ]);
        }

        return back()->with('success', 'Message sent successfully!');
    }

    public function updateMessage(Request $request, $user_id, $message_id)
    {
        User::findOrFail($user_id);
        $message = Message::findOrFail($message_id);

        if ((int) $message->sender_id !== auth()->id() || (int) $message->recipient_id !== (int) $user_id) {
            abort(403);
        }

        if (is_array($request->input('message'))) {
            $request->merge(['message' => null]);
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $messageText = $request->input('message');
        if ($messageText !== null) {
            $messageText = trim($messageText);
            if ($messageText === '') {
                $messageText = null;
            }
        }

        if (!$messageText && !$message->image_path) {
            return back()->withErrors(['message' => 'Please provide a message or keep the attached image.']);
        }

        $message->update([
            'message' => $messageText,
            'edited_at' => now(),
        ]);

        return back()->with('success', 'Message updated successfully!');
    }

    public function deleteMessage($user_id, $message_id)
    {
        User::findOrFail($user_id);
        $message = Message::findOrFail($message_id);

        if ((int) $message->sender_id !== auth()->id() || (int) $message->recipient_id !== (int) $user_id) {
            abort(403);
        }

        if ($message->image_path) {
            Storage::disk('public')->delete($message->image_path);
        }

        $message->update([
            'deleted_at' => now(),
            'message' => null,
            'image_path' => null,
        ]);

        return back()->with('success', 'Message unsent successfully!');
    }

    public function deleteMessageForMe($user_id, $message_id)
    {
        $currentUserId = auth()->id();
        $message = Message::findOrFail($message_id);

        $isParticipant = (int) $message->sender_id === (int) $currentUserId
            || (int) $message->recipient_id === (int) $currentUserId;
        $isCorrectConversation = (int) $message->sender_id === (int) $user_id
            || (int) $message->recipient_id === (int) $user_id;

        if (!$isParticipant || !$isCorrectConversation) {
            abort(403);
        }

        $deletedFor = is_array($message->deleted_for_recipients)
            ? $message->deleted_for_recipients
            : [];

        $deletedFor = array_map('intval', $deletedFor);

        if (!in_array((int) $currentUserId, $deletedFor, true)) {
            $deletedFor[] = (int) $currentUserId;
            $message->update(['deleted_for_recipients' => $deletedFor]);
        }

        return back()->with('success', 'Message deleted for you!');
    }

    private function conversationMessages(int $user_id): Collection
    {
        $senderId = auth()->id();

        if ($senderId === $user_id) {
            $messages = Message::where('sender_id', $senderId)
                ->where('recipient_id', $senderId)
                ->orderBy('created_at')
                ->get();
        } else {
            $messages = Message::where(function ($query) use ($senderId, $user_id) {
                $query->where('sender_id', $senderId)
                    ->where('recipient_id', $user_id);
            })
                ->orWhere(function ($query) use ($senderId, $user_id) {
                    $query->where('sender_id', $user_id)
                        ->where('recipient_id', $senderId);
                })
                ->orderBy('created_at')
                ->get();
        }

        return $messages
            ->filter(fn ($msg) => $msg->isVisibleTo((int) $senderId))
            ->values();
    }

    private function renderMessageRows(Collection $messages, int $user_id): string
    {
        if ($messages->isEmpty()) {
            return '';
        }

        $recipient = User::findOrFail($user_id);
        $recipientInitial = strtoupper(substr($recipient->name ?? 'U', 0, 1));
        $senderInitial = strtoupper(substr(auth()->user()->name ?? 'Y', 0, 1));
        $recipientAvatarPath = $recipient->avatar_path;
        $senderAvatarPath = auth()->user()->avatar_path;

        return $messages->map(function (Message $message) use (
            $user_id,
            $recipientInitial,
            $senderInitial,
            $recipientAvatarPath,
            $senderAvatarPath
        ) {
            return view('frontend.partials.message-row', [
                'message' => $message,
                'user_id' => $user_id,
                'recipientInitial' => $recipientInitial,
                'senderInitial' => $senderInitial,
                'recipientAvatarPath' => $recipientAvatarPath,
                'senderAvatarPath' => $senderAvatarPath,
            ])->render();
        })->implode('');
    }
}
