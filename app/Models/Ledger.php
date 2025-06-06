<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $fillable = [
        'report_type',
        'doctor_name',
        'transaction_date',
        'remarks',
        'credit',
        'debit',
        'balance',
    ];
}
