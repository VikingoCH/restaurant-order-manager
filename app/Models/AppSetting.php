<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'order_prefix',
        'tax',
        'rows_per_page',
    ];
}
