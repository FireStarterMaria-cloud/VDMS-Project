<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDocument extends Model
{
    protected $fillable = [
        'vehicle_id',
        'uploaded_by',
        'file_path',
        'file_name',
        'file_type',
        'caption',
        'sort_order',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Can the given user view this document?
     * Rules:
     * - Chairwoman: sees everything
     * - Superadmin / HO_ADMIN: sees documents within their own showroom
     * - Everyone else (Branch Manager, Sales Staff, Accountant): only their own uploads
     */
    public function isVisibleTo(User $user): bool
    {
        if ($user->isChairwoman()) {
            return true;
        }

        if ($user->isHO()) {
            $docShowroomId = $this->vehicle?->branch?->showroom_id;
            return $docShowroomId && $docShowroomId === $user->showroom_id;
        }

        return $this->uploaded_by === $user->id;
    }
}