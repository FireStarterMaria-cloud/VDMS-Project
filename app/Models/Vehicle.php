<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id', 'purchased_by', 'make', 'model', 'year',
        'registration_no', 'chassis_no', 'engine_no', 'colour',
        'variant', 'transmission', 'fuel_type', 'mileage',
        'purchase_price', 'selling_price', 'status', 'description'
    ];

    protected $casts = [
        'year' => 'integer',
        'mileage' => 'integer',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'status' => 'string',
         
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function purchasedBy()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function history()
    {
        return $this->hasMany(VehicleHistory::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function branchTransfers()
    {
        return $this->hasMany(BranchTransfer::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }
}