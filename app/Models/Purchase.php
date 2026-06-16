<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'branch_id', 'purchased_by', 'supplier_name',
        'supplier_contact', 'purchase_price', 'payment_method',
        'reference_no', 'purchase_date', 'notes'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'purchase_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function purchasedBy()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }
}