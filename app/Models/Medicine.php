<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(MedicineCategory::class, 'medicine_category_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(MedicineManufacturer::class, 'medicine_manufacturer_id');
    }
}
