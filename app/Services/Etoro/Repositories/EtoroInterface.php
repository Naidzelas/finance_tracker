<?php 

namespace App\Services\Etoro\Repositories;

use App\Services\Etoro\DTOs\InstrumentBySymbolData;
use App\Services\Etoro\DTOs\InvestorClosedPositionsData;
use App\Services\Etoro\DTOs\InvestorFactsheetData;
use App\Services\Etoro\DTOs\InvestorHistoryData;
use App\Services\Etoro\DTOs\InvestorPortfolioData;

interface EtoroInterface
{
    public function getInvestorsFactsheet(string $username): InvestorFactsheetData;
    public function getInvestorClosedPositions(string $username): InvestorClosedPositionsData;
    public function getInvestorPortfolio(string $username): InvestorPortfolioData;
    public function getInvestorHisotry(string $username): InvestorHistoryData;
    public function getInstrumentBySymbol(string $symbol): InstrumentBySymbolData;
}