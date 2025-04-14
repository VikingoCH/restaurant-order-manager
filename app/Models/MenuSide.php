<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuSide extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
    ];

    public function menuItemsFixed(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_fixed_sides');
    }

    public function menuItemsSelectable(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_selectable_sides');
    }
}
