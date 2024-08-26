<?php

namespace App\Models\Goals;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'goal_deposit_id',
        'icon_id',
        'is_main_priority',
    ];
}

