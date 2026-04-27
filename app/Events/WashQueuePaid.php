<?php

namespace App\Events;

use App\Models\WashQueue;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WashQueuePaid implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public WashQueue $queue, public string $paymentMethod) {}

    public function broadcastOn(): array
    {
        return [new Channel('wash-queues')];
    }

    public function broadcastWith(): array
    {
        $queue = $this->queue->load(['car', 'washer']);

        return [
            'queue_id'       => $queue->id,
            'car_number'     => $queue->car?->car_number,
            'wash_type'      => $queue->wash_type,
            'wash_price'     => (float) $queue->wash_price,
            'washer_name'    => $queue->washer?->name,
            'payment_method' => $this->paymentMethod,
        ];
    }
}
