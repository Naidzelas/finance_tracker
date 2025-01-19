<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;

class AssetPerformance extends Model
{
    public $fillable = [
        'asset_id',
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
}
