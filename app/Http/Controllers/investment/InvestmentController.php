<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\EtoroController;
use App\Models\investment\AssetPerformance;
use App\Models\investment\Investment;
use App\Models\investment\InvestmentIcon;
use App\Models\investment\InvestmentType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return Inertia::render('Investment', [
            'investments' => Investment::query()->where('user_id', $user->id)->with([
                'investmentIcon',
                'investmentType',
                'investmentSector',
                'assetPerfomrance',
                'investmentPossition',
                'investmentNote'
            ])->get(),
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Investment',
                    'route' => '/investment'
                ],
            ],
            'detailsTab' => [
                'stats' => AssetPerformance::query()->with([
                    'investment.investmentType',
                    'investment.investmentSector'
                ])->get()->keyBy('investment_id'),
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
            $request = request();
            $this->store($request);
            return;
        }

        return Inertia::render('Item', [
            'registerRoute' => 'investment',
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Investment',
                    'route' => '/investment'
                ],
                [
                    'label' => 'Create',
                    'route' => '/investment/create'
                ]
            ],
            'method' => 'post',
            'list' => $list,
            'selectData' => [
                'investment_icon_id' => InvestmentIcon::query()->select('id', 'iconify_name as data')->get()->toArray(),
                'investment_type_id' => InvestmentType::query()->select('id', 'name as data')->get()->toArray(),
            ],
        ]);
    }

    public function edit($investmentId)
    {
        $investment = Investment::find($investmentId);

        return Inertia::render('Item', [
            'registerRoute' => 'investment/' . $investment->id,
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Investment',
                    'route' => '/investment'
                ],
                [
                    'label' => 'Edit',
                    'route' => '/investment' . '/' . $investmentId . '/edit'
                ]
            ],
            'method' => 'put',
            'list' => [
                'invested' => ['Number', $investment->invested],
            ],
            'selectData' => [],
        ]);
    }

    public function store(Request $request)
    {
        if (Investment::where('investment_type_id', 1)->count()) {
            $request->validate([
                'symbol' => 'required|string',
                'invested' => 'required|numeric',
                'value' => 'required|numeric',
                'investment_type_id' => 'required|integer',
                'investment_icon_id' => 'required|integer',
            ]);

            Investment::create([
                'symbol' => $request->symbol,
                'invested' => $request->invested,
                'value' => $request->value,
                'investment_type_id' => $request->investment_type_id,
                'investment_icon_id' => $request->investment_icon_id,
                'user_id' => $request->user()->id,
                'profit_percent' => ($request->value - $request->invested) / abs($request->invested) * 100,
                'is_green' => $request->invested < $request->value ? true : false,
                'profit' => $request->invested * (($request->value - $request->invested) / abs($request->invested)),
            ]);
        } else {
            new InitialInvestmentLoadController($request->user(), new EtoroController);
        };

        return to_route('investment.index');
    }

    public function update(Request $request, $investmentId)
    {
        $request->validate([
            'invested' => 'required|numeric',
        ]);

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
