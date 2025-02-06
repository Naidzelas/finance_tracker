<?php

namespace App\Http\Controllers\document;

use App\Http\Controllers\Controller;
use App\Http\Controllers\debts\DebtFileController;

class DocumentController extends Controller
{
    public function download($filename)
    {
        $file = new DebtFileController($filename);
        return $file->download();
    }
    public function open($filename)
    {
        $file = new DebtFileController($filename);
        return $file->open();
    }
}
