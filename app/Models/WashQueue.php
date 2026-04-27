<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Guarded([])]
class WashQueue extends Model
{
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function box(): BelongsTo
    {
        return $this->belongsTo(CarwashBox::class, 'car_wash_box_id');
    }

    public function washer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function washType(): BelongsTo
    {
        return $this->belongsTo(WashType::class, 'wash_type_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'wash_queues_id');
    }
}
