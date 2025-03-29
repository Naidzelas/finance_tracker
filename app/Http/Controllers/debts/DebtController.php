<?php

namespace App\Http\Controllers\Debts;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\document\PDF;
use App\Http\Controllers\services\IconifyController;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Debts\Debt;
use App\Models\Debts\DebtDetail;
use App\Models\Documents\Document;
use App\Models\Expenses\Expense;
use App\Models\Icons;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $debt = Debt::where('user_id', $user->id)
            ->with(['budgetType.expense:id,type_id,amount', 'debtDetail', 'documents'])
            ->get()
            ->map(function ($debt) {
                if ($debt->toArray()['budget_type']) {
                    $debt->paid = array_sum(array_column($debt->toArray()['budget_type']['expense'], 'amount')) ?? 0;
                }
                return $debt;
            });

        return Inertia::render('Debt', [
            'debts' => $debt,
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Debt',
                    'route' => '/debt'
                ],
            ],
            'detailsTab' => [
                'table' => self::buildDetailTable($debt),
                'documents' => $debt->keyBy('id'),
            ]
        ]);
    }

    public function create()
    {
        if (RequestFacade::input('suggestIcon')) {
            $icons = new IconifyController();
            $suggestions = $icons->searchIcons(RequestFacade::input('suggestIcon'))->getData();
        }
        
        return Inertia::render('Item', [
            'registerRoute' => 'debt',
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Debt',
                    'route' => '/debt'
                ],
                [
                    'label' => 'Create',
                    'route' => '/debt/create'
                ]
            ],
            'method' => 'post',
            'list' => [
                'name' => ['String',],
                'iconify_name' => ['Select',],
                'loan_size' => ['Number',],
                'monthly_payment' => ['Number',],
                'loan_final_amount' => ['Number',],
                'interest_rate' => ['Number',],
                'payment_date' => ['Number',],
                'loan_end_date' => ['Date',],
                'loan_iban' => ['String',],
                'avatar' => ['Avatar',],
            ],
            'selectData' => [
                'iconify_name' => $suggestions->icons ?? [],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'iconify_name' => 'required|string',
            'loan_size' => 'required|numeric',
            'monthly_payment' => 'required|numeric',
            'loan_final_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'payment_date' => 'required|numeric|lte:31',
            'loan_end_date' => 'required|date',
            'loan_iban' => 'nullable|string',
            'avatar' => 'nullable|array',
        ]);

        $user = $request->user();
        $budgetType = BudgetTypes::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'amount' => $request->monthly_payment,
            'iconify_name' => $request->iconify_name,
        ]);

        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        if ($request?->loan_iban) {
            $tagService->applyTagsByIban($request->loan_iban, $budgetType->id);
        }
        event(new NotificationEvent('Budget item has been created'));

        $debt = Debt::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'type_id' => $budgetType->id,
            'loan_size' => $request->loan_size,
            'monthly_payment' => $request->monthly_payment,
            'loan_final_amount' => $request->loan_final_amount,
            'interest_rate' => $request->interest_rate,
            'iconify_name' => $request->iconify_name
        ]);

        if ($debt->id) {
            DebtDetail::create([
                'debt_id' => $debt->id,
                'payment_date' => $request->payment_date,
                'loan_end_date' => Carbon::createFromDate($request->loan_end_date)->format('Y-m-d'),
                'loan_iban' => $request->loan_iban
            ]);
        }

        if ($request->avatar) {
            foreach ($request->avatar as $avatar) {
                $document = new Document([
                    'filename' => $avatar->getClientOriginalName(),
                    'file_path' => $avatar->path()
                ]);
                $debt->documents()->save($document);
                $store = new PDF($avatar->getClientOriginalName(), $avatar->get());
                $store->upload();
            };
        }

        return to_route('debt.index');
    }

    public function edit($debtId)
    {
        $debt = Debt::with(['debtDetail'])->find($debtId);

        if (RequestFacade::input('suggestIcon')) {
            $icons = new IconifyController();
            $suggestions = $icons->searchIcons(RequestFacade::input('suggestIcon'))->getData();
        }

        return Inertia::render('Item', [
            'registerRoute' => 'debt/' . $debtId,
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Debt',
                    'route' => '/debt'
                ],
                [
                    'label' => 'Edit',
                    'route' => '/debt' . '/' . $debtId . '/edit'
                ]
            ],
            'method' => 'put',
            'list' => [
                'name' => ['String', $debt->name],
                'iconify_name' => ['Select', $debt->iconify_name],
                'loan_size' => ['Number', $debt->loan_size],
                'monthly_payment' => ['Number', $debt->monthly_payment],
                'loan_final_amount' => ['Number', $debt->loan_final_amount],
                'interest_rate' => ['Number', $debt->interest_rate],
                'payment_date' => ['Number', $debt->debtDetail->payment_date],
                'loan_end_date' => ['Date', $debt->debtDetail->loan_end_date],
                'loan_iban' => ['String', $debt->debtDetail->loan_iban],
                // 'avatar' => 'nullable|array',
            ],
            'selectData' => [
                'iconify_name' => $suggestions->icons ?? [],
            ]
        ]);
    }

    public function update(Request $request, $debtId)
    {
        $request->validate([
            'name' => 'required|string',
            'iconify_name' => 'required|string',
            'loan_size' => 'required|numeric',
            'monthly_payment' => 'required|numeric',
            'loan_final_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'payment_date' => 'required|numeric|lte:31',
            'loan_end_date' => 'required|date',
            'loan_iban' => 'nullable|string',
        ]);

        // TODO file upload only works for POST method so can't put it here. Will need to add file attach functionality.

        $debt = Debt::find($debtId);
        if($debt?->type_id){
            BudgetTypes::findOrNew($debt->type_id)->update([
                'name' => $request->name,
                'amount' => $request->monthly_payment,
                'iconify_name' => $request->iconify_name,
            ]);
        }
        
        $debt->fill([
            'name' => $request->name,
            'loan_size' => $request->loan_size,
            'monthly_payment' => $request->monthly_payment,
            'loan_final_amount' => $request->loan_final_amount,
            'interest_rate' => $request->interest_rate,
            'iconify_name' => $request->iconify_name
        ])->save();

        if ($debtId) {
            $debtDetails = DebtDetail::find($debtId);
            $debtDetails->fill([
                'debt_id' => $debt->id,
                'payment_date' => $request->payment_date,
                'loan_end_date' => Carbon::createFromDate($request->loan_end_date)->format('Y-m-d'),
                'loan_iban' => $request->loan_iban
            ])->save();
        }

        return to_route('debt.index');
    }


    public function destroy($debtId): void
    {
        $debt = Debt::with('debtDetail')->find($debtId);
        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        if ($debt->debtDetail?->loan_iban) {
            $tagService->removeTagsByIban($debt->debtDetail->loan_iban);
        }
        // TODO Possibly add DB constraint on delete.
        $debtDetail = DebtDetail::find($debt->id);
        if ($debtDetail) {
            $debtDetail->delete();
        }
        $budgetTypes = BudgetTypes::find($debt->type_id);
        if ($budgetTypes) {
            $budgetTypes->delete();
        }
        $debt->delete();
    }

    private function buildDetailTable($debt): Collection
    {
        $table = [
            'thead' => [
                'loan_payed',
                'loan_end_date',
                'loan_final_amount',
                'loan_iban'
            ]
        ];

        foreach ($debt->toArray() as $detail) {
            $table[$detail['debt_detail']['id']]['tbody'][] = [
                array_key_exists('paid', $detail) ? round($detail['paid'], 2) : 0,
                Carbon::parse($detail['debt_detail']['loan_end_date'])->format('Y-m-d'),
                $detail['loan_final_amount'],
                $detail['debt_detail']['loan_iban'] ?? 'N/A'
            ];
        }

        return collect($table);
    }
}
