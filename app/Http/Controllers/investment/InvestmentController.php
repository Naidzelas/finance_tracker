<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\EtoroController;
use App\Models\investment\AssetPerformance;
use App\Models\investment\Investment;
use App\Models\investment\InvestmentIcon;
use App\Models\investment\InvestmentSector;
use App\Models\investment\InvestmentType;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPUnit\Framework\isEmpty;

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

    public function create()
    {
        if (Investment::where('investment_type_id', 1)->count()) {
            $list = [
                'symbol' => ['String',],
                'invested' => ['Number',],
                'value' => ['Number',],
                'investment_type_id' => ['Select',],
                'investment_icon_id' => ['Select',],
            ];
        } else {
            $list = [
                'username' => ['String',],
            ];
        }

        return Inertia::render('Item', [
            'registerRoute' => 'investment',
            'method' => 'post',
            'list' => $list,
            'selectData' => [
                'investment_icon_id' => InvestmentIcon::query()->select('id','iconify_name as data')->get()->toArray(),
                'investment_type_id' => InvestmentType::query()->select('id', 'name as data')->get()->toArray(),
            ],
        ]);
    }

    public function edit($investmentId)
    {
        $investment = Investment::find($investmentId);

        return Inertia::render('Item', [
            'registerRoute' => 'investment/' . $investment->id,
            'method' => 'put',
            'list' => [
                'invested' => ['Number', $investment->invested],
            ],
            'selectData' => [],
        ]);
    }

    public function store(Request $request, Investment $investment)
    {

        if (Investment::where('investment_type_id', 1)->count()) {
            $investment->fill($request->all());
            $profit_percent = ($request->value - $request->invested)/abs($request->invested) * 100;
            $investment->profit_percent = $profit_percent;
            $investment->is_green = $request->invested < $request->value ? true : false;
            $investment->profit = $request->invested * ($profit_percent/100);
            $investment->save();
        } else {
            new InitialInvestmentLoadController($request->username, new EtoroController);
        };

        return to_route('investment.index');
    }

    public function update(Request $request, $investmentId)
    {
        $invested = $request->invested;
        $investment = Investment::find($investmentId);

        Investment::find($investmentId)->update([
            'invested' => $request->invested,
            'profit' => round($invested * ($investment->profit_percent / 100), 2),
            'value' => $investment->is_green ?
                round($invested + $invested * ($investment->profit_percent / 100), 2) :
                round($invested - $invested * ($investment->profit_percent / 100), 2),
        ]);
        return to_route('investment.index');
    }

    public function destroy($investmentId)
    {
        Investment::find($investmentId)->delete();
    }
}
