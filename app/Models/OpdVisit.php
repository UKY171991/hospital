<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdVisit extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
