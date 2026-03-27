<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineSale extends Model
{
    protected $fillable = [
        'patient_id',
        'medicine_id',
        'quantity',
        'total_amount',
        'sale_date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
