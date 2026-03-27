<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PathologyRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'pathology_test_id',
        'doctor_id',
        'test_date',
        'result',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function pathologyTest()
    {
        return $this->belongsTo(PathologyTest::class, 'pathology_test_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
