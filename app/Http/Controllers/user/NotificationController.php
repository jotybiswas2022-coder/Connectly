<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotificationController extends Controller
{
    /**
     * SSE endpoint for real-time notifications via Server-Sent Events.
     * Uses Laravel's StreamedResponse for proper middleware integration.
     */
    public function stream()
    {
        $userId = (int) Auth::id();

        // Close the session early so other requests can use the session
        session()->save();

        return response()->stream(function () use ($userId) {
            // Prevent PHP timeout within the stream
            if (function_exists('set_time_limit')) {
                set_time_limit(0);
            }

            $lastUnreadCount = null;
            $lastCheck = now();

            while (true) {
                // Check if client disconnected
                if (connection_aborted()) {
                    break;
                }

                $currentCount = Notification::where('user_id', $userId)
                    ->unread()
                    ->count();

                // Fetch full data only if count changed or every 15 seconds
                $shouldFetch = ($currentCount !== $lastUnreadCount);
                $timeSinceLastCheck = now()->diffInSeconds($lastCheck);

                if ($shouldFetch || $timeSinceLastCheck >= 15) {
                    $lastUnreadCount = $currentCount;
                    $lastCheck = now();

                    $notifications = Notification::where('user_id', $userId)
                        ->with('fromUser:id,name,avatar_path')
                        ->latest()
                        ->take(10)
                        ->get()
                        ->map(function ($notification) {
                            return [
                                'id' => $notification->id,
                                'type' => $notification->type,
                                'message' => $notification->message,
                                'link' => $notification->link,
                                'is_read' => $notification->is_read,
                                'time' => $notification->created_at->diffForHumans(),
                                'from_user' => $notification->fromUser ? [
                                    'name' => $notification->fromUser->name,
                                    'avatar_path' => $notification->fromUser->avatar_path,
                                ] : null,
                            ];
                        });

                    $data = json_encode([
                        'unread_count' => $currentCount,
                        'notifications' => $notifications,
                    ]);

                    echo "event: notification\n";
                    echo "data: {$data}\n\n";

                    if (ob_get_level()) {
                        ob_flush();
                    }
                    flush();
                } else {
                    // Send heartbeat comment to keep connection alive
                    echo ": heartbeat\n\n";
                    if (ob_get_level()) {
                        ob_flush();
                    }
                    flush();
                }

                // Sleep for 3 seconds between checks
                sleep(3);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }
    /**
     * Get unread notification count and recent notifications (for AJAX).
     */
    public function fetch()
    {
        $userId = (int) Auth::id();

        $unreadCount = Notification::where('user_id', $userId)
            ->unread()
            ->count();

        $notifications = Notification::where('user_id', $userId)
            ->with('fromUser:id,name,avatar_path')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'message' => $notification->message,
                    'link' => $notification->link,
                    'is_read' => $notification->is_read,
                    'time' => $notification->created_at->diffForHumans(),
                    'from_user' => $notification->fromUser ? [
                        'name' => $notification->fromUser->name,
                        'avatar_path' => $notification->fromUser->avatar_path,
                    ] : null,
                ];
            });

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', (int) $id)
            ->where('user_id', (int) Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        Notification::where('user_id', (int) Auth::id())
            ->unread()
            ->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }
}
