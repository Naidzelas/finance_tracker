<?php

namespace App\Models\Expenses;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeCurrentPostway(Builder $query, $postway = 'C'): void
    {
        $query->select('type_id', 'amount')
            ->where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
            ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
            ->where('debit_credit', $postway);
    }
}
