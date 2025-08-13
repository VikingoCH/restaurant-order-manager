<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'order_prefix',
        'quick_order_name',
        'tax',
        'rows_per_page',
        'printer_store_website',
        'printer_store_email',
        'printer_store_phone',
        'printer_store_address',
        'printer_store_name',
    ];
}
