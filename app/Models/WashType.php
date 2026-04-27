<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class WashType extends Model
{
    public function washQueues(): HasMany
    {
        return $this->hasMany(WashQueue::class, 'wash_type_id');
    }
}
