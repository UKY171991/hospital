<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignBed extends Model
{
    protected $fillable = [
        'bed_id',
        'patient_name',
        'assign_date',
        'release_date',
        'status',
    ];

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}
