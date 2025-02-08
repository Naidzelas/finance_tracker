<?php

namespace App\Http\Controllers;

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Http\Controllers\features\SWEDImportExpensesController;
use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    private const UNCATEGORIZED = 1;

    public function index(Expense $expense)
    {
        return Inertia::render('Home', [
            'expenses' => $expense->all()->toArray(),
            'current_expenses' => $expense->where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
                ->get(),
            'previous_expenses' => $expense->where('date', '>=', Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d'))
                ->get(),
            'goals' => Goal::query()->with('icon')->withSum('goal_deposit as deposit', 'deposit')->get(),
            'budget_types' => BudgetTypes::query()->with('icon')->get()->toArray(),
        ]);
    }

    public function store(Request $request, Expense $expense)
    {
        switch ($request->bank) {
            case 'seb':
                $seb = new SEBImportExpensesController;
                $data = $seb($request->avatar->path());
                break;
            case 'swed':
                $swed = new SWEDImportExpensesController;
                $data = $swed($request->avatar->path());
                break;
            default:
        }
        $budgetTypes = BudgetTypes::all()->keyBy('id')->toArray();

        foreach ($data as $item) {
            $expense->create([
                'type_id' => key(array_filter($budgetTypes, function ($type) use ($item) {
                    if (
                        strpos($item['transaction_name'], $type['filter_keys'])
                        || $item['transaction_name'] == $type['filter_keys']
                    ) {
                        return true;
                    }
                })) ?? self::UNCATEGORIZED,
                'transaction_name' => $item['transaction_name'],
                'amount' => (float) $item['amount'],
                'date' => $item['transaction_date'],
                'debit_credit' => $item['debit_credit'],
                'currency' => $item['currency'],
            ]);
        }
        return to_route('index');
    }

    public function update(Request $request) {}
}
