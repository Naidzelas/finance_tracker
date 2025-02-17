<?php

namespace App\Models\Goals;

use App\Models\Icons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'end_goal',
        'contribution',
        'icon_id',
        'is_main_priority',
        'active',
    ];

    public function goal_deposit(): HasMany
    {
        return $this->hasMany(GoalDeposit::class);
    }
    public function icon(): HasOne
    {
        return $this->hasOne(Icons::class, 'id', 'icon_id');
    }
}
