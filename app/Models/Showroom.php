<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    protected $fillable = [
        'name', 'city', 'country', 'address',
        'phone', 'email', 'logo', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function superAdmin()
    {
        return $this->hasOne(User::class)->where('role', 'superadmin');
    }
}