<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'from_branch_id', 'to_branch_id', 
        'requested_by', 'approved_by', 'status', 'reason',
        'requested_date', 'approved_date', 'completed_date'
    ];

    protected $casts = [
        'status' => 'string',
        'requested_date' => 'date',
        'approved_date' => 'date',
        'completed_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}