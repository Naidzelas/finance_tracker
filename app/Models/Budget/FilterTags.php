<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Model;

class FilterTags extends Model
{
    public $fillable = [
        'budget_type_id',
        'tag'
    ];
}
