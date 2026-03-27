<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $guarded = [];

    public function opdVisit()
    {
        return $this->belongsTo(OpdVisit::class);
    }
}
