<?php

namespace App\Models\Debts;

use App\Models\Documents\Document;
use App\Models\Icons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Debt extends Model
{
    public $fillable = [
        'name',
        'type_id',
        'active',
        'loan_size',
        'monthly_payment',
        'loan_final_amount',
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

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
