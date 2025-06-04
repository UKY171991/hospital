<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeExpense extends Model
{
    protected $fillable = [
        'date',
        'type',
        'category',
        'item_id',
        'amount',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }

    public function item()
    {
        return $this->belongsTo(IncomeItem::class, 'item_id');
    }
} 