<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetPerformance extends Model
{
    public $fillable = [
        'investment_id',
        'revenue',
        'is_green',
        'eps',
        'is_eps_green',
        'pe_ratio',
        'is_pe_green',
        'dividend',
        'dividend_ex_date',
        'dividend_pay_date',
        'dividend_frequency'
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }
}
