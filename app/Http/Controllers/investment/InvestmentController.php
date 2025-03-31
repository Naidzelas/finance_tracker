<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\EtoroController;
use App\Http\Controllers\services\IconifyController;
use App\Models\investment\AssetPerformance;
use App\Models\investment\Investment;
use App\Models\investment\InvestmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return Inertia::render('Investment', [
            'investments' => Investment::query()->where('user_id', $user->id)->with([
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

            if (RequestFacade::input('suggestIcon')) {
                $icons = new IconifyController();
                $suggestionsIcon = $icons->searchIcons(RequestFacade::input('suggestIcon'))->getData();
            }

            $list = [
                'symbol' => ['String',],
                'invested' => ['Number',],
                'value' => ['Number',],
                'investment_type_id' => ['Select',],
                'iconify_name' => ['Select',],
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
                'iconify_name' => $suggestionsIcon->icons ?? [],
                'investment_type_id' => InvestmentType::query()->select('id', 'name as data')->get()->toArray(),
            ],
        ]);
    }

    public function edit($investmentId)
    {
        $investment = Investment::find($investmentId);

        if (RequestFacade::input('suggestIcon')) {
            $icons = new IconifyController();
            $suggestionsIcon = $icons->searchIcons(RequestFacade::input('suggestIcon'))->getData();
        }
        
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
                'iconify_name' => ['Select', $investment->iconify_name],
            ],
            'selectData' => [
                'iconify_name' => $suggestionsIcon->icons ?? [],
            ],
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
                'iconify_name' => 'required|integer',
            ]);

            Investment::create([
                'symbol' => $request->symbol,
                'invested' => $request->invested,
                'value' => $request->value,
                'investment_type_id' => $request->investment_type_id,
                'iconify_name' => $request->iconify_name,
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
            'invested' => 'numeric',
            'iconify_name' => 'string',
        ]);

        $invested = $request->invested;
        $investment = Investment::find($investmentId);

        Investment::find($investmentId)->update([
            'invested' => $request->invested,
            'iconify_name' => $request->iconify_name,
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
