<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'cnic',
        'phone',
        'email',
        'address',
        'city',
        'country',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}