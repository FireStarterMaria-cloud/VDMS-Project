<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'image_url', 'image_name', 'file_size', 
        'is_primary', 'sort_order'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}