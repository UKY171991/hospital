<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'client_name',
        'mobile_no',
        'address',
        'items', // JSON array of items
        'total_amount',
        'total_discount',
        'grand_total',
        'remark',
    ];

    protected $casts = [
        'items' => 'array',
    ];
} 