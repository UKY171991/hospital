<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'contact_no',
        'email',
        'dob',
        'qualification',
        'address',
        'pan_no',
        'aadhar_no',
        'bank_name',
        'account_no',
        'ifsc_code',
        'opening_balance',
        'photo',
        'status',
    ];
} 