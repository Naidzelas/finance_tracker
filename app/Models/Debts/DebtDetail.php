<?php

namespace App\Models\Debts;

use Illuminate\Database\Eloquent\Model;

class DebtDetail extends Model
{
    public $fillable = [
        'debt_id',
        'loan_name',
        'paid_amount',
        'loan_iban'
    ];
}
