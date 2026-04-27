<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class CarwashBox extends Model
{
    public function washQueues(): HasMany
    {
        return $this->hasMany(WashQueue::class, 'car_wash_box_id');
    }
}
