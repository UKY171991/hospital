<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = [
        'invoice_no', 'date', 'supplier_name', 'purchase_order_no', 'eway_bill_no', 'total_amount', 'remarks'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
