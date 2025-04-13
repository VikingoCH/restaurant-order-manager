<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'position'
    ];


    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
