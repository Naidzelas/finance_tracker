<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\services\EtoroController;
use App\Models\investment\AssetPerformance;
use App\Models\investment\Investment;
use App\Models\investment\InvestmentIcon;
use App\Models\investment\InvestmentPosition;
use App\Models\investment\InvestmentSector;
use App\Models\investment\InvestmentType;
use Carbon\Carbon;

class InitialInvestmentLoadController
{
    public function __construct($user, EtoroController $etoro)
    {
        $portfolio = $etoro->getInvestorPortfolio($user->etoro_name)->getData();
        $trades = $etoro->getInvestorClosedPositions($user->etoro_name)->getData();
        self::alocateInvestmentData($portfolio->positions, $etoro, $trades, $user->id);
    }

    private function alocateInvestmentData($positions, $etoro, $trades, $userId)
    {
        // TODO this is dumb access to data. Will need to fix.. and api excludes the keys if they have no values... also need to figure out instrument query by multiple symbols at once.

        self::createInvestment($positions, $userId);
        foreach ($positions as $position) {
            $instrument = $etoro->getInstrumentBySymbol($position->symbol)->getData();
            self::createInvestmentSector($instrument->instrument->sector);
            self::createInvestmentType($instrument->instrument->type);
            self::createInvestmentIcon($instrument->instrument->name);
            self::updateInvestmentRecord($instrument->instrument->symbol, [
                'investment_type_id' => InvestmentType::query()->where('name', $instrument->instrument->type)->first()->id,
                'investment_sector_id' => InvestmentSector::query()->where('name', $instrument->instrument->sector)->first()->id,
                'investment_iconify_name' => InvestmentIcon::query()->where('name', $instrument->instrument->name)->first()->id,
                'instrument_id' => $instrument->instrument->instrumentId,
            ]);
            self::createAssetPerformanceRecord($instrument->instrument);
        }
        self::createInvestmentPositionRecord($trades);
    }

    private function createInvestment($positions, $userId)
    {
        foreach ($positions as $position) {
            Investment::create([
                'user_id' => $userId,
                'symbol' => $position->symbol,
                'profit_percent' => abs($position->netProfit),
                'is_green' => $position->netProfit > 0 ? true : false
            ]);
        }
    }

    private function createAssetPerformanceRecord($data)
    {
        AssetPerformance::create([
            'investment_id' => Investment::query()->where('symbol', $data->symbol)->first()->id,
            'revenue' => abs($data->salesOrRevenue),
            'is_green' => $data->salesOrRevenue > 0 ? true : false,
            'eps' => abs($data->eps),
            'is_eps_green' => $data->eps > 0 ? true : false,
            'pe_ratio' => abs($data->peRatio),
            'is_pe_green' => $data->peRatio > 0 ? true : false,
            'dividend' => $data->dividendYield ?? 0,
            'dividend_ex_date' => !empty($data->dividendExDate) ? Carbon::createFromDate($data->dividendExDate)->format('Y-m-d') : null,
            'dividend_pay_date' => !empty($data->dividendExDate) ? Carbon::createFromDate($data->dividendPayDate)->format('Y-m-d') : null,
            'dividend_frequency' => $data->dividendFrequency ?? null,
        ]);
    }

    private function updateInvestmentRecord(string $where, array $options)
    {
        Investment::where('symbol',  $where)->update($options);
    }

    private function createInvestmentType(string $type)
    {
        InvestmentType::firstOrCreate([
            'name' => $type
        ]);
    }

    private function createInvestmentSector(string $sector)
    {
        InvestmentSector::firstOrCreate([
            'name' => $sector
        ]);
    }

    private function createInvestmentIcon(string $company)
    {
        InvestmentIcon::firstOrCreate([
            'name' => $company,
            'iconify_name' => 'streamline:investment-selection'
        ]);
    }

    public function createInvestmentPositionRecord($trades)
    {
        foreach ($trades->positions as $trade) {
            InvestmentPosition::create([
                'investment_id' => Investment::query()->where('instrument_id', $trade->instrumentId)->first()->id,
                'open_datetime' => !empty($trade->openDateTime) ? Carbon::createFromDate($trade->openDateTime)->format('Y-m-d H:i:s') : null,
                'open_rate' => $trade->openRate,
                'profit_percent' => abs($trade->netProfit),
                'is_green' => $trade->netProfit > 0 ? true : false,
                'close_rate' => $trade->closeRate,
                'close_date' => !empty($trade->closeDateTime) ? Carbon::createFromDate($trade->closeDateTime)->format('Y-m-d H:i:s') : null,
            ]);
        }
    }
}
