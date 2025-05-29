<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ipd extends Model
{
    protected $fillable = [
        'ipd_no', 'uhid_no', 'patient_name', 'attendant_name', 'attendant_mobile', 'second_attendant_name', 'second_attendant_mobile', 'admission_date', 'discharge_date', 'doctor_name', 'disease', 'department', 'ward_name', 'room_no', 'bed_no', 'employee', 'bill_no', 'insurance', 'insurance_name', 'policy_id', 'policy_holder_name', 'status'
    ];
} 