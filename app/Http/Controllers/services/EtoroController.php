<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;
use App\Services\Etoro\Exceptions\EtoroException;
use App\Services\Etoro\Facades\Etoro;

class EtoroController extends Controller
{
    public function getInvestorFactsheet($username)
    {
        try {
            /** @var \App\Services\Etoro\DTOs\InvestorFactsheetData */
            $etoro = Etoro::getInvestorsFactsheet(username: $username);

        } catch (EtoroException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'username' => $etoro->portfolio,
            'hisotry' => $etoro->history,
            'returns' => $etoro->returns
        ]);
    }

    public function getInvestorClosedPositions($username)
    {
        try {
            /** @var \App\Services\Etoro\DTOs\InvestorClosedPositionsData */
            $etoro = Etoro::getInvestorClosedPositions($username);

        } catch (EtoroException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'positions' => $etoro->positions,
            'instruments' => $etoro->instruments,
        ]);
    }

    public function getInvestorPortfolio($username)
    {
        try {
            /** @var \App\Services\Etoro\DTOs\InvestorPortfolioData */
            $etoro = Etoro::getInvestorPortfolio($username);

        } catch (EtoroException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'balance' => $etoro->balance,
            'positions' => $etoro->positions,
        ]);
    }

    public function getInvestorHistory($username)
    {
        try {
            /** @var \App\Services\Etoro\DTOs\InvestorHistoryData */
            $etoro = Etoro::getInvestorHisotry($username);

        } catch (EtoroException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'insturments' => $etoro->instruments,
            'daily' => $etoro->daily
        ]);
    }

    public function getInstrumentBySymbol($symbol)
    {
        try {
            /** @var \App\Services\Etoro\DTOs\InstrumentBySymbolData */
            $etoro = Etoro::getInstrumentBySymbol($symbol);

        } catch (EtoroException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'insturment' => $etoro->instrument,
        ]);
    }
}
