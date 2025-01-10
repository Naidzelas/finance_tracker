<?php

namespace App\Models\Goals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalDeposit extends Model
{
    protected $fillable = [
        'goal_id',
        'deposit'
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}
