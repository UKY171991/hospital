<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type',
        'name',
        'price',
        'unit',
    ];

    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }
}
