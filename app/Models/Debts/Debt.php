<?php

namespace App\Models\Debts;

use App\Models\Budget\BudgetTypes;
use App\Models\Documents\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Debt extends Model
{
    /** @use HasFactory<\Database\Factories\DebtFactory> */
    use HasFactory;

    public $fillable = [
        'user_id',
        'name',
        'type_id',
        'active',
        'loan_size',
        'monthly_payment',
        'loan_final_amount',
        'interest_rate',
        'iconify_name',
        'document_id',
    ];

    public function debtDetail(): HasOne
    {
        return $this->hasOne(DebtDetail::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function budgetType(): HasOne
    {
        return $this->hasOne(BudgetTypes::class, 'id', 'type_id');
    }

    public function scopeIsActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
