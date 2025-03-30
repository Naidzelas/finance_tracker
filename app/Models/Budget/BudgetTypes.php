<?php

namespace App\Models\Budget;

use App\Models\Expenses\Expense;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetTypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'iconify_name',
    ];

    public function tag(): HasMany
    {
        return $this->hasMany(FilterTags::class, 'budget_type_id');
    }

    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class, 'type_id');
    }
}
