<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id', 'branch_id', 'transaction_id',
        'payment_method', 'amount', 'currency', 'status', 'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'string',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}