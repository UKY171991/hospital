<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable = [
        'department_id',
        'disease',
        'description',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
