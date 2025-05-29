<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'doctor_id',
        'mobile',
        'email',
        'dob',
        'joining_date',
        'gender',
        'qualification',
        'experience',
        'address',
        'aadhar_no',
        'pan_no',
        'account_no',
        'ifsc_code',
        'bank_name',
        'opening_balance',
        'photo',
        'status',
    ];
}
