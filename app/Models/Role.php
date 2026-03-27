<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'status', 'permissions', 'view_all_records'];

    protected $casts = [
        'permissions' => 'array',
        'view_all_records' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
