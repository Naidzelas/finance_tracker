<?php

namespace App\Models\Goals;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'saving_account_iban',
        'type_id',
        'end_goal',
        'contribution',
        'iconify_name',
        'is_main_priority',
    ];

    public function goal_deposit(): HasMany
    {
        return $this->hasMany(GoalDeposit::class);
    }
}
