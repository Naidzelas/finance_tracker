<?php

namespace App\Models\Expenses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_id',
        'transaction_name',
        'amount',
        'currency',
        'debit_credit',
        'date'
    ];
}
