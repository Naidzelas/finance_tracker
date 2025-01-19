<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;

class InvestmentPossition extends Model
{
    public $fillable = [
        'investment_id',
        'open_datetime',
        'open_rate',
        'invested',
        'profit',
        'profit_percent',
        'is_green',
        'close_rate',
        'close_date',
    ];
}
