<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMapping extends Model
{
    protected $fillable = [
        'type', 'date', 'patient_name', 'patient_contact_no', 'item_name', 'item_code', 'sale_price', 'quantity', 'amount', 'status'
    ];
} 