<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'plan_type', 'start_date', 'end_date',
        'is_active', 'amount', 'currency', 'activated_at', 'expired_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'activated_at' => 'datetime',
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function subPayments()
    {
        return $this->hasMany(SubPayment::class);
    }
}