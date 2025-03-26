<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\ChartService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\AuthKitAccountDeletionRequest;
use App\Models\Budget\BudgetTypes;
use App\Models\Debts\Debt;
use App\Models\investment\Investment;
use App\Services\Chart\Repositories\ChartRepositoryInterface;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        match (true) {
            $request->has('chartData') => $chartData = [
                'tab' => 'statistics', 
                'data' => Crypt::decrypt($request->input('chartData'))
            ],
            default => null
        };

        // TODO: find a better way to use the Chart Service 
        $chartRepository = app(ChartRepositoryInterface::class, ['model' => BudgetTypes::class]);
        $chartService = new ChartService($chartRepository);

        return Inertia::render('Profile', [
            'user' => $request->user(),
            'invested' => Investment::select('id', 'invested')->get()->sum('invested'),
            'debt' => [
                'total' => Debt::select('id', 'loan_final_amount')
                    ->where('user_id', $request->user()->id)
                    ->where('active', 1)
                    ->get()
                    ->sum('loan_final_amount'),
                'paid' => Debt::isActive()->select('id', 'type_id')
                    ->with(['budgetType' => fn($query) => $query->select('id')->with('expense:id,type_id,amount')])
                    ->get()
                    ->flatMap(function ($item) {
                        return  $item->budgetType?->expense->map(function ($expense) {
                            return $expense->amount;
                        })->all() ?? [];
                    })->sum(),
            ],
            'chartData' => $chartData ?? [],
            'budgetAllocation' => $chartService->getChartDataByType(1, 'pie'),
            'budgetTypes' => BudgetTypes::select('id', 'name')->where('user_id', $request->user()->id)->get(),
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Profile',
                    'route' => '/settings/profile'
                ],
            ],
        ]);
    }

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile settings.
     */
    public function update(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        // ]);
        User::find($request->user()->id)->update([
            'etoro_name' => $request->etoro_name,
            'income' => $request->income
        ]);
        // $request->user()->update([
        //     'etoro_name' => $request->etoro_name,
        //     'income' => $request->income
        // ]);

        return to_route('index');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(AuthKitAccountDeletionRequest $request): RedirectResponse
    {
        return $request->delete(
            using: fn(User $user) => $user->delete()
        );
    }
}
