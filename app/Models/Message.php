<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'message',
        'image_path',
        'edited_at',
        'deleted_at',
        'deleted_for_recipients',
    ];

    protected $casts = [
        'sender_id' => 'integer',
        'recipient_id' => 'integer',
        'deleted_for_recipients' => 'json',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function isVisibleTo(int $userId): bool
    {
        $deletedFor = $this->deleted_for_recipients ?? [];
        if (!is_array($deletedFor)) {
            $deletedFor = [];
        }

        return !in_array($userId, array_map('intval', $deletedFor), true);
    }

    public static function conversationPartnerIdsFor(int $userId): \Illuminate\Support\Collection
    {
        return static::query()
            ->where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->get()
            ->filter(fn (self $msg) => $msg->isVisibleTo($userId))
            ->map(fn (self $msg) => (int) $msg->sender_id === $userId
                ? (int) $msg->recipient_id
                : (int) $msg->sender_id)
            ->unique()
            ->filter(fn (int $id) => $id !== $userId)
            ->values();
    }
}
