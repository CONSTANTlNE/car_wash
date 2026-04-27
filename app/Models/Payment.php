<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class Payment extends Model
{
    public function washQueue(): BelongsTo
    {
        return $this->belongsTo(WashQueue::class, 'wash_queues_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
