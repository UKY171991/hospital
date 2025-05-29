<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'date',
        'supplier_id',
        'purchase_order_no',
        'eway_bill_no',
        'items', // JSON array of items
        'total_amount',
        'total_discount',
        'grand_total',
        'remark',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
} 