<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;

class InvestmentIcon extends Model
{
    public $fillable = [
        'name',
        'symbol',
        'iconify_name',
    ];
}
