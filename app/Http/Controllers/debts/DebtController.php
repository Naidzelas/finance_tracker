<?php

namespace App\Http\Controllers\Debts;

use App\Http\Controllers\Controller;
use App\Models\Debts\Debt;
use App\Models\Icons;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DebtController extends Controller
{
    public function index()
    {
        return Inertia::render('Debt', [
            'debts' => Debt::query()->with([
                'icon'
            ])->get(),
            'detailsTab' => [
                'table' => '',
                'documents' => '',
                'notes' => ''
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Item', [
            'registerRoute' => 'debt',
            'method' => 'post',
            'list' => [
                'name' => ['String',],
                'loan_size' => ['Number',],
                'monthly_payment' => ['Number',],
                'loan_post_interest' => ['Number',],
                'payment_date' => ['Date',],
                'interest_rate' => ['Number',],
                'icon_id' => ['Select',],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }

    public function store(Request $request, Debt $debt)
    {
        $debt->fill($request->all());
        $debt->payment_date = now();
        $debt->document_id = 1;        
        $debt->save();
        return to_route('debt.index');
    }

    public function edit($debtId)
    {
        $debt = Debt::find($debtId);

        return Inertia::render('Item', [
            'registerRoute' => 'debt/' . $debtId,
            'method' => 'put',
            'list' => [
                'name' => ['String', $debt->name],
                'loan_size' => ['Number', $debt->loan_size],
                'monthly_payment' => ['Number', $debt->monthly_payment],
                'loan_post_interest' => ['Number', $debt->loan_post_interest],
                'payment_date' => ['Date', $debt->payment_date],
                'interest_rate' => ['Number', $debt->interest_rate],
                'icon_id' => ['Select', $debt->icon_id],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }

    public function update(Request $request, $debtId)
    {
        $debt = Debt::find($debtId);
        $debt->fill($request->all());
        $debt->save();

        return to_route('index');
    }


    public function destroy($debtId): void
    {
        Debt::find($debtId)->delete();
    }
}
