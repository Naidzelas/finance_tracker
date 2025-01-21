<?php

namespace App\Services\Etoro\Repositories;

use App\Services\Etoro\DTOs\InstrumentBySymbolData;
use App\Services\Etoro\DTOs\InvestorClosedPositionsData;
use App\Services\Etoro\DTOs\InvestorFactsheetData;
use App\Services\Etoro\DTOs\InvestorHistoryData;
use App\Services\Etoro\DTOs\InvestorPortfolioData;
use App\Services\Etoro\Exceptions\EtoroException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class EtoroRepository implements EtoroInterface
{
    private PendingRequest $http;

    public function __construct()
    {
        // Globaly set the base url and accept json
        $this->http = Http::baseUrl('https://api.bullaware.com')
            ->acceptJson();
    }

    public function getInvestorsFactsheet(string $username): InvestorFactsheetData
    {
        $response = $this->http->get('v1/factsheets/'.$username, [
            'apikey' => config('services.etoro.key'),
        ]);
        
        throw_if($response->failed(), EtoroException::class, 'Unable to fetch etoro investor factsheet data');
        return InvestorFactsheetData::fromArray($response->json());
    }

    public function getInvestorClosedPositions(string $username): InvestorClosedPositionsData
    {
        $response = $this->http->get('v1/investors/'.$username.'/trades', [
            'apikey' => config('services.etoro.key'),
        ]);
        
        throw_if($response->failed(), EtoroException::class, 'Unable to fetch etoro investor closed positions data');
        return InvestorClosedPositionsData::fromArray($response->json());
    }

    public function getInvestorPortfolio(string $username): InvestorPortfolioData
    {
        $response = $this->http->get('v1/investors/'.$username.'/portfolio', [
            'apikey' => config('services.etoro.key'),
        ]);
        
        throw_if($response->failed(), EtoroException::class, 'Unable to fetch etoro investor portfolio data');
        return InvestorPortfolioData::fromArray($response->json());
    }

    public function getInvestorHisotry(string $username): InvestorHistoryData
    {
        $response = $this->http->get('v1/investors/'.$username.'/history', [
            'apikey' => config('services.etoro.key'),
        ]);
        
        throw_if($response->failed(), EtoroException::class, 'Unable to fetch etoro investor history data');
        return InvestorHistoryData::fromArray($response->json());
    }

    public function getInstrumentBySymbol(string $symbol): InstrumentBySymbolData
    {
        $response = $this->http->get('v1/instruments/'.$symbol, [
            'apikey' => config('services.etoro.key'),
        ]);
        
        throw_if($response->failed(), EtoroException::class, 'Unable to fetch etoro instrument by symbol data');
        return InstrumentBySymbolData::fromArray($response->json());
    }
}