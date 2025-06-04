<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'select_type',
        'doctor_name',
        'date',
        'payment_ref_no',
        'before_due_amount',
        'discount',
        'paid_amount',
        'after_due_amount',
        'transaction_ref_no',
        'payment_mode',
        'payer_bank',
        'bank_account_number',
        'ifsc_code',
        'narration',
    ];
}
