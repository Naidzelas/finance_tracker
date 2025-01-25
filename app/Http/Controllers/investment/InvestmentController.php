<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\EtoroController;
use App\Models\investment\AssetPerformance;
use App\Models\investment\Investment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Investment', [
            'investments' => Investment::query()->with([
                'investmentIcon',
                'investmentType',
                'investmentSector',
                'assetPerfomrance',
                'investmentPossition',
                'investmentNote'
            ])->get(),
            'detailsTab' => [
                'stats' => AssetPerformance::query()->with([
                    'investment.investmentType',
                    'investment.investmentSector'
                ])->get()->keyBy('investment_id'),
                'table' => '',
                'notes' => ''
            ]
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Item', [
            'registerRoute' => 'investment',
            'method' => 'post',
            'list' => [
                'username' => ['String',],
            ],
        ]);
    }

    public function store(Request $request, Investment $investment)
    {
        new InitialInvestmentLoadController($request->username, new EtoroController);
        // $investment->fill($request->all());
        // $investment->save();
        return to_route('investment.index');
    }
}
