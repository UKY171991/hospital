<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'price',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
