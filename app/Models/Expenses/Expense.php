<?php

namespace App\Models\Expenses;

use App\Models\Budget\BudgetTypes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type_id',
        'transaction_name',
        'amount',
        'currency',
        'debit_credit',
        'date',
        'iban'
    ];

    public function scopeCurrentPostway(Builder $query, $postway = 'C'): void
    {
        $query->select('type_id', 'amount')
            ->where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
            ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
            ->where('debit_credit', $postway);
    }

    public function budgetType(): HasMany
    {
        return $this->hasMany(BudgetTypes::class, 'id', 'type_id');
    }
}
