<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Printer extends Model
{
    protected $fillable = [
        'name',
        'identifier',
        'location',
        'ip_address',
        'conection_type',
        'connection_port',
    ];

    public function menuItem(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
