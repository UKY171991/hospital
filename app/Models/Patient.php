<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'photo', 'name', 'patient_id', 'relation_name', 'relation_of_relative', 
        'relative_title', 'mobile', 'reg_date', 'address', 'status', 'gender', 
        'card_no', 'reference_doctor', 'aadhar_no', 'age', 'blood_group', 
        'color_vision', 'height_cm', 'weight_kg'
    ];
    
    protected $dates = ['reg_date'];
    
    // Define relationship to OPD records
    public function opds()
    {
        return $this->hasMany(Opd::class, 'patient_id', 'patient_id');
    }
} 