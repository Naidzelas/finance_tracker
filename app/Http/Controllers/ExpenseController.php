<?php

namespace App\Http\Controllers;

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Http\Controllers\features\SWEDImportExpensesController;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Debts\Debt;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Models\investment\Investment;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Crypt;

class ExpenseController extends Controller
{
    private const UNCATEGORIZED = 1;

    public function index(Request $request)
    {
        $user = $request->user();

        match (true) {
            $request->has('previous_expenses') => $previous_expenses = Crypt::decrypt($request->input('previous_expenses')),
            $request->has('current_expenses') => $current_expenses = Crypt::decrypt($request->input('current_expenses')),
            default => null
        };

        return Inertia::render('Home', [
            'current_expenses' => $current_expenses ?? Expense::where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
                ->where('user_id', $user->id)
                ->orderBy('date')
                ->get(),
            'previous_expenses' => $previous_expenses ?? Expense::where('date', '>=', Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d'))
                ->where('user_id', $user->id)
                ->orderBy('date')
                ->get(),
            'goals' => Goal::where('user_id', $user->id)->with('icon')->withSum('goal_deposit as deposit', 'deposit')->get(),
            'budget_types' => BudgetTypes::query()->where('user_id', $user->id)->with([
                'icon',
            ])->get()
                ->map(function ($item) {
                    $item->budget_left = $item->amount + Expense::currentPostway()
                        ->sum('amount') -  Expense::currentPostway('D')->where('type_id', $item->id)->sum('amount');
                    return $item;
                }),
            'invested' => Investment::select('id', 'invested')->get()->sum('invested'),
            'debt' => [
                'total' => Debt::select('id', 'loan_final_amount')
                    ->where('user_id', $user->id)
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
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->hasFile('avatar')) {
            return;
        }

        foreach ($request->avatar as $file) {
            switch ($request->bank) {
                case 'seb':
                    $seb = new SEBImportExpensesController;
                    $data = $seb($file->path());
                    break;
                case 'swed':
                    $swed = new SWEDImportExpensesController;
                    $data = $swed($file->path());
                    break;
                default:
            }

            $filterTags = new FilterTags();
            foreach ($data as $item) {
                $expense = Expense::updateOrCreate([
                    'user_id' => $request->user()->id,
                    'type_id' => self::UNCATEGORIZED,
                    'transaction_name' => $item['transaction_name'],
                    'amount' => (float) $item['amount'],
                    'date' => $item['transaction_date'],
                    'debit_credit' => $item['debit_credit'],
                    'currency' => $item['currency'],
                    'iban' => $item['iban']
                ]);
                $tagRepository = app(TagRepositoryInterface::class, ['model' => $expense, 'availableTags' => $filterTags]);
                $tagService = new TagService($tagRepository);
                $tagService->applyTag();
            }
        }
        return to_route('index');
    }
}
