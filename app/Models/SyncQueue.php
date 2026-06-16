<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'user_id', 'model_type', 'model_id',
        'operation', 'payload', 'status', 'retry_count', 'conflict_note'
    ];

    protected $casts = [
        'payload' => 'array',
        'status' => 'string',
        'retry_count' => 'integer',
        'created_at' => 'datetime',
        'synced_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}