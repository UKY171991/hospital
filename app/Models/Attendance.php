<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'type',
        'reference_id',
        'date',
        'name',
        'amount',
        'duty_type',
        'duty_chart_no',
    ];
}
