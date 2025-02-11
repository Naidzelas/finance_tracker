<?php

namespace App\Models\Debts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebtDetail extends Model
{
    public $fillable = [
        'debt_id',
        'paid_amount',
        'payment_date',
        'loan_end_date',
        'loan_iban'
    ];

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }
}
