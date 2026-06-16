<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'vehicle_id',
        'branch_id',
        'sold_by',
        'customer_id',
        'sale_price',
        'discount',
        'final_price',
        'status',
        'sale_date',
        'notes',
    ];

    protected $casts = [
        'sale_date'  => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function soldBy()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }
}