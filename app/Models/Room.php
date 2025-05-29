<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'ward_id',
        'name',
        'description',
        'status',
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
