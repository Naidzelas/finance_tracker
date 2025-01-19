<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\Controller;
use App\Models\investment\Investment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Investment', [
            'investments' => Investment::query()->get(),
            'detailsTab' => [
                // 'table' => self::buildDetailTable(),
                // TODO this is an Example, remove later
                // 'documents' => '',
                'notes' => ''
            ]
        ]);
    }
}
