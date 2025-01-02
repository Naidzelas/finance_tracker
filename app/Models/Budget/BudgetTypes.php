<?php

namespace App\Models\Budget;

use App\Models\Icons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BudgetTypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'icon_id',
        'filter_keys'
    ];

    public function icon():HasOne
    {
        return $this->hasOne(Icons::class, 'id', 'icon_id');
    }
}
