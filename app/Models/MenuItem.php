<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'position',
        'name',
        'price',
        'image_path',
        'menu_section_id',
        'printer_id',
    ];

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }

    public function menuSection(): BelongsTo
    {
        return $this->belongsTo(MenuSection::class);
    }

    public function menuFixedSides(): BelongsToMany
    {
        return $this->belongsToMany(MenuSide::class, 'menu_fixed_sides');
    }

    public function menuSelectableSides(): BelongsToMany
    {
        return $this->belongsToMany(MenuSide::class, 'menu_selectable_sides');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
