<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'name',
        'description',
    ];
}
