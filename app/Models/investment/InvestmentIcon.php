<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentIcon extends Model
{
    public $fillable = [
        'name',
        'symbol',
        'iconify_name',
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }
}
