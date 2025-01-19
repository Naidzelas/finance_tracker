<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    public $fillable = [
        'invested',
        'profit_loss_percent',
        'profit_loss',
        'average_buy_in',
    ];
}
