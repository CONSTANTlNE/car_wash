<?php

namespace App\Events;

use App\Models\Parking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParkingPaid implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Parking $parking, public string $paymentMethod) {}

    public function broadcastOn(): array
    {
        return [new Channel('parkings')];
    }

    public function broadcastWith(): array
    {
        return [
            'parking_id' => $this->parking->id,
            'car_number' => $this->parking->car_number,
            'parking_fee' => (float) ($this->parking->parking_fee ?? 0),
            'payment_method' => $this->paymentMethod,
        ];
    }
}
