<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'type',
        'item_name',
        'item_code',
        'hsn_sac_code',
        'sales_price',
        'purchase_price',
        'unit',
        'opening_stock',
        'current_stock',
        'status',
    ];
}
