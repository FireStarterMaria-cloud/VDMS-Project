<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'branch_id',
        'showroom_id',
        'phone',
        'profile_picture',
        'is_active',
        'last_login_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
        'last_login_at'     => 'datetime',
        'role'              => Role::class,
    ];

    // ===== Relationships =====
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function showroom()
    {
        return $this->belongsTo(Showroom::class);
    }

    // ===== Role Helper Methods =====
    public function isChairwoman(): bool
    {
        return $this->role === Role::CHAIRWOMAN;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === Role::SUPERADMIN;
    }

    public function isHOAdmin(): bool
    {
        return $this->role === Role::HO_ADMIN;
    }

    public function isBranchManager(): bool
    {
        return $this->role === Role::BRANCH_MANAGER;
    }

    public function isSalesStaff(): bool
    {
        return $this->role === Role::SALES_STAFF;
    }

    public function isAccountant(): bool
    {
        return $this->role === Role::ACCOUNTANT;
    }

    public function isHO(): bool
    {
        return $this->isChairwoman() || $this->isSuperAdmin() || $this->isHOAdmin();
    }

    public function canManageAllBranches(): bool
    {
        return $this->isChairwoman() || $this->isSuperAdmin() || $this->isHOAdmin();
    }

    public function canAccessBranch(int $branchId): bool
    {
        if ($this->isChairwoman() || $this->isSuperAdmin() || $this->isHOAdmin()) {
            return true;
        }
        return $this->branch_id === $branchId;
    }

    public function canAccessShowroom(int $showroomId): bool
    {
        if ($this->isChairwoman()) return true;
        return $this->showroom_id === $showroomId;
    }
}