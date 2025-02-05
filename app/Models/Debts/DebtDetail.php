<?php

namespace App\Models\Debts;

use Illuminate\Database\Eloquent\Model;

class DebtDetail extends Model
{
    public $fillable = [
        'debt_id',
        'paid_amount',
        'payment_date',
        'loan_end_date',
        'loan_iban'
    ];
}
