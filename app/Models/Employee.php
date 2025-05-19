<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relative_name',
        'mobile_no',
        'alternate_mobile_no',
        'email',
        'phone',
        'position',
        'dob',
        'gender',
        'aadhar_no',
        'pan_no',
        'current_address',
        'permanent_address',
        'marital_status',
        'blood_group',
        'education',
        'experience_year',
        'joining_date',
        'leaving_date',
        'role',
        'department',
        'bank_name',
        'branch_name',
        'account_no',
        'account_holder_name',
        'ifsc_code',
        'opening_balance',
        'salary',
        'photo',
        'hospital_id',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}