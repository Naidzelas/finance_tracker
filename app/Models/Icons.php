<?php

namespace App\Models;

use App\Models\Budget\BudgetTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Icons extends Model
{
    protected $fillable = [
        'iconify_name'
    ];

    public function budgetType(): BelongsTo
    {
        return $this->belongsTo(BudgetTypes::class, 'icon_id');
    }
}
