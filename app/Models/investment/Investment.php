<?php

namespace App\Models\investment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Investment extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'symbol',
        'instrument_id',
        'investment_note_id',
        'investment_type_id',
        'iconify_name',
        'investment_sector_id',
        'invested',
        'profit',
        'profit_percent',
        'is_green',
        'value'
    ];

    public function investmentType(): HasOne
    {
        return $this->hasOne(InvestmentType::class, 'id', 'investment_type_id');
    }

    public function investmentSector(): HasOne
    {
        return $this->hasOne(InvestmentSector::class, 'id', 'investment_sector_id');
    }

    public function assetPerfomrance(): HasMany
    {
        return $this->hasMany(AssetPerformance::class);
    }

    public function investmentPossition(): HasMany
    {
        return $this->hasMany(InvestmentPosition::class);
    }
    
    public function investmentNote(): HasOne
    {
        return $this->hasOne(InvestmentNote::class, 'id', 'investment_note_id');
    }
}
