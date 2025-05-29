<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeAssign extends Model
{
    protected $fillable = [
        'department_id',
        'item_name',
        'amount',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
