<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    protected $fillable = ['report_type', 'month_year', 'credit', 'debit', 'balance'];
}
