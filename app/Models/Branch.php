<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;   // ← Removed SoftDeletes

    protected $fillable = [
        'name', 'city', 'state_province', 'country', 'currency',
        'exchange_rate', 'address', 'phone', 'email', 'manager_id', 'is_active'
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function branchTransfersSent()
    {
        return $this->hasMany(BranchTransfer::class, 'from_branch_id');
    }

    public function branchTransfersReceived()
    {
        return $this->hasMany(BranchTransfer::class, 'to_branch_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function syncQueues()
    {
        return $this->hasMany(SyncQueue::class);
    }
}