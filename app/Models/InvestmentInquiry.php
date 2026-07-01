<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentInquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'investment_range',
        'custom_amount',
        'investment_targets',
        'message',
        'status',
    ];

    protected $casts = [
        'investment_targets' => 'array',
    ];
}