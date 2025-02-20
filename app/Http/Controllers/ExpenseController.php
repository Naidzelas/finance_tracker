<?php

namespace App\Http\Controllers;

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Http\Controllers\features\SWEDImportExpensesController;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    private const UNCATEGORIZED = 1;

    public function index(Request $request)
    {
        return Inertia::render('Home', [
            'current_expenses' => $request->current_expenses ?? Expense::where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
                ->orderBy('date')
                ->get(),
            'previous_expenses' => $request->previous_expenses ?? Expense::where('date', '>=', Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d'))
                ->orderBy('date')
                ->get(),
            'goals' => Goal::query()->with('icon')->withSum('goal_deposit as deposit', 'deposit')->get(),
            'budget_types' => BudgetTypes::query()->with('icon')->get()->toArray(),
        ]);
    }

    public function store(Request $request)
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
        
        $filterTags = new FilterTags();
        foreach ($data as $item) {
            $expense = Expense::updateOrCreate([
                'type_id' => self::UNCATEGORIZED,
                'transaction_name' => $item['transaction_name'],
                'amount' => (float) $item['amount'],
                'date' => $item['transaction_date'],
                'debit_credit' => $item['debit_credit'],
                'currency' => $item['currency'],
            ]);
            $tagRepository = app(TagRepositoryInterface::class, ['model' => $expense, 'availableTags' => $filterTags]);
            $tagService = new TagService($tagRepository);
            $tagService->applyTag();
        }
        return to_route('index');
    }

    public function update(Request $request) {}
}
