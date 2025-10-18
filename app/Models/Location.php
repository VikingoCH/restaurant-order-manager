<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'id',
        'name',
        'position',
        'physical'
    ];


    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
