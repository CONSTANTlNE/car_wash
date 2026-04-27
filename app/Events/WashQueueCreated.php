<?php

namespace App\Events;

use App\Models\WashQueue;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WashQueueCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public WashQueue $queue) {}

    public function broadcastOn(): array
    {
        return [new Channel('wash-queues')];
    }

    public function broadcastWith(): array
    {
        $queue = $this->queue->load(['car', 'box', 'washer']);

        return [
            'id'                => $queue->id,
            'wash_date'         => $queue->wash_date,
            'car_number'        => $queue->car?->car_number,
            'car_type'          => $queue->car?->car_type,
            'wash_type'         => $queue->wash_type,
            'box_number'        => $queue->box?->box_number,
            'washer_name'       => $queue->washer?->name,
            'wash_price'        => (float) $queue->wash_price,
            'washer_commission' => (float) $queue->washer_commission,
            'status'            => $queue->status,
            'is_paid'           => (bool) $queue->is_paid,
        ];
    }
}
