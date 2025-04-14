<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'position',
    ];

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
