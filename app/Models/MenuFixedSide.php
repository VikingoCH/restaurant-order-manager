<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MenuFixedSide extends Model
{
    protected $fillable = [
        'menu_side_id',
        'menu_item_id',
    ];

    public function menuSide(): BelongsToMany
    {
        return $this->belongsToMany(MenuSide::class);
    }

    public function menuItem(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class);
    }
}
