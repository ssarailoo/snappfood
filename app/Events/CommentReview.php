<?php

namespace App\Events;

use App\Enums\CommentStatus;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CommentReview implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */


    public function __construct(public Comment $comment)
    {
        Log::info('CommentReview event constructed for comment ID: ' . $comment->id);

    }

    public function broadcastOn()
    {
        return new Channel('my-channel');
    }

    public function broadcastAs()
    {
        return 'my-event';
    }

    public function broadcastWhen(): bool
    {
        return ($this->comment->status === CommentStatus::RECONSIDERING_BY_CUSTOMER->value and $this->comment->reconsidered === 1)
            or $this->comment->status === CommentStatus::REVIEWING_BY_ADMIN->value;
    }
}
