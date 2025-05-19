<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_code',
        'purchase_price',
        'sales_price',
        'unit',
        'opening_stock',
        'current_stock',
        // 'hospital_id', // Uncomment if you add hospital_id to the table
    ];

    /**
     * If items belong to a hospital, define the relationship.
     */
    // public function hospital()
    // {
    //     return $this->belongsTo(Hospital::class);
    // }
}
