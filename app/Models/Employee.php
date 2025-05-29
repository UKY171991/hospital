<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'photo',
        'name',
        'employee_id',
        'relative_name',
        'mobile_no',
        'alternate_mobile_no',
        'email',
        'dob',
        'gender',
        'aadhar_no',
        'pan_no',
        'current_address',
        'permanent_address',
        'marital_status',
        'blood_group',
        'education',
        'joining_date',
        'leaving_date',
        'experience_year',
        'role',
        'department',
        'bank_name',
        'account_no',
        'account_holder_name',
        'ifsc_code',
        'salary_per_day',
        'opening_balance',
        'status',
    ];
}
