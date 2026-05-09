<?php

namespace App\Events;

use App\Models\Parking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParkingCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Parking $parking) {}

    public function broadcastOn(): array
    {
        return [new Channel('parkings')];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->parking->id,
            'car_number' => $this->parking->car_number,
            'start_time' => $this->parking->start_time?->toDateTimeString(),
            'end_time' => $this->parking->end_time?->toDateTimeString(),
            'duration' => $this->parking->duration,
            'parking_fee' => (float) ($this->parking->parking_fee ?? 0),
            'is_paid' => (bool) $this->parking->is_paid,
        ];
    }
}
