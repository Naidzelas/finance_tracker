<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;

class InvestmentStock extends Model
{
    public $fillable = [
        'name',
        'iconify_name',
        'price',
        'eps',
        'pe'
    ]; 
}

