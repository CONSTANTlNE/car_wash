<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class WashPrice extends Model
{
    use BelongsToTenant;

    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }

    public function washType(): BelongsTo
    {
        return $this->belongsTo(WashType::class);
    }
}
