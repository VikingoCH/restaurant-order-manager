<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number',
        'total',
        'is_open',
        'table',
        'place_id'
    ];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
