<?php

namespace App\Models\Debts;

use App\Models\Icons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Debt extends Model
{
    public $fillable = [
        'name',
        'active',
        'loan_size',
        'monthly_payment',
        'loan_post_interest',
        'payment_date',
        'interest_rate',
        'icon_id',
        'document_id',
    ];

    public function icon(): HasOne
    {
        return $this->hasOne(Icons::class, 'id', 'icon_id');
    }

    public function debtDetail(): HasOne
    {
        return $this->hasOne(DebtDetail::class);
    }
}
