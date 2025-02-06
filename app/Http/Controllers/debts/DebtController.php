<?php

namespace App\Http\Controllers\Debts;

use App\Http\Controllers\Controller;
use App\Models\Debts\Debt;
use App\Models\Debts\DebtDetail;
use App\Models\Documents\Document;
use App\Models\Icons;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class DebtController extends Controller
{
    public function index()
    {
        $debt = Debt::query()->with([
            'icon',
            'debtDetail',
            'documents'
        ])->get();

        return Inertia::render('Debt', [
            'debts' => $debt,
            'detailsTab' => [
                'table' => self::buildDetailTable(),
                'documents' => $debt->keyBy('id'),
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
                'icon_id' => ['Select',],
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
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->avatar);
        $debt = Debt::create([
            'name' => $request->name,
            'loan_size' => $request->loan_size,
            'monthly_payment' => $request->monthly_payment,
            'loan_final_amount' => $request->loan_final_amount,
            'interest_rate' => $request->interest_rate,
            'icon_id' => $request->icon_id
        ]);

        if ($debt->id) {
            DebtDetail::create([
                'debt_id' => $debt->id,
                'payment_date' => $request->payment_date,
                'loan_end_date' => Carbon::createFromDate($request->loan_end_date)->format('Y-m-d'),
                'loan_iban' => $request->loan_iban
            ]);
        }
        foreach ($request->avatar as $avatar) {
            $document = new Document([
                'filename' => $avatar->getClientOriginalName(),
                'file_path' => $avatar->path()
            ]);
            $debt->documents()->save($document);
            // Document::create([
            //     'name' => $request->name,
            //     'file_name' => $avatar->getClientOriginalName(),
            // ]);
        };
        // dd();
        // $document = Document::create([

        // ]);

        return to_route('debt.index');
    }

    public function edit($debtId)
    {
        $debt = Debt::with(['debtDetail'])->find($debtId);
        return Inertia::render('Item', [
            'registerRoute' => 'debt/' . $debtId,
            'method' => 'put',
            'list' => [
                'name' => ['String', $debt->name],
                'icon_id' => ['Select', $debt->icon_id],
                'loan_size' => ['Number', $debt->loan_size],
                'monthly_payment' => ['Number', $debt->monthly_payment],
                'loan_final_amount' => ['Number', $debt->loan_final_amount],
                'interest_rate' => ['Number', $debt->interest_rate],
                'payment_date' => ['Number', $debt->debtDetail->payment_date],
                'loan_end_date' => ['Date', $debt->debtDetail->loan_end_date],
                'loan_iban' => ['String', $debt->debtDetail->loan_iban],
                'avatar' => ['Avatar',],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }

    public function update(Request $request, $debtId)
    {
        $debt = Debt::find($debtId);
        $debt->fill([
            'name' => $request->name,
            'loan_size' => $request->loan_size,
            'monthly_payment' => $request->monthly_payment,
            'loan_final_amount' => $request->loan_final_amount,
            'interest_rate' => $request->interest_rate,
            'icon_id' => $request->icon_id
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
        Debt::find($debtId)->delete();
    }

    private function buildDetailTable(): Collection
    {
        $table = [
            'thead' => [
                'Paid Amount',
                'Loan End Date',
                'Loan Iban'
            ]
        ];
        $debtDetail = DebtDetail::all();

        foreach ($debtDetail as $detail) {
            $table[$detail['id']]['tbody'][] = [
                $detail->paid_amount,
                $detail->payment_date,
                $detail->loan_iban ?? 'N/A'
            ];
        }
        return collect($table);
    }
}
