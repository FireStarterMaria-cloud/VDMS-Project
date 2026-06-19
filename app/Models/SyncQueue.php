<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncQueue extends Model
{
    protected $table = 'sync_queue';

    protected $fillable = [
        'branch_id',
        'user_id',
        'model_type',
        'model_id',
        'operation',
        'payload',
        'status',
        'retry_count',
        'conflict_note',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    // Timestamps disable kiye hain kyunke table mein updated_at nahi hai
    public $timestamps = false;
}