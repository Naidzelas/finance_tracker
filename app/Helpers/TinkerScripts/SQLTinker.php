<?php

use App\Http\Controllers\Services\TagService;
use App\Models\Goals\Goal;
use App\Models\Goals\GoalDeposit;
use Illuminate\Support\Str;

function run()
{
    // $compare = 'NARVESEN/LIETUVOS SPAUDA\TAIKOS PR. 101\KLAIPEDA\94198\LTULTU';
    // $comapreWith = '*'.Str::upper('narvesen/lietuvos Sp').'*';
    $tag = new TagService;
    $result = $tag->contains('draugas', 'DRAUGAS DRAUGUI\VINGIO G. 8\KLAIPEDA\UNKNOWN      LTU');
    return $result->getData();
}
