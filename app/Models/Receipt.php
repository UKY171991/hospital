<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'select_type',
        'patient_name',
        'date',
        'receipt_ref_no',
        'before_due_amount',
        'discount',
        'receipt_amount',
        'after_due_amount',
        'transaction_ref_no',
        'receipt_mode',
        'receiver_bank',
        'bank_account_number',
        'ifsc_code',
        'narration',
    ];
}
