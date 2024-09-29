<?php

namespace App\Http\Controllers\features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SWEDImportExpensesController extends Controller
{
    const TRANSACTION_DATE = 2;
    const AMOUNT = 5;
    const DEBIT_CREDIT = 7;
    const CURRENCY = 6;
    const TRANSACTION_NAME = 3;
    const TRANSACTION_NAME_NOT_FOUND = 4;

    public function __invoke(String $filename): array
    {
        $row = 1;
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                $dataArray[] = $data;
            }
            fclose($handle);
            
            unset($dataArray[0]);
            array_splice($dataArray, count($dataArray) - 3, 3);
            foreach ($dataArray as $arrayItem){
                $array[] = [
                    'transaction_date' => $arrayItem[self::TRANSACTION_DATE],
                    'amount' => $arrayItem[self::AMOUNT],
                    'debit_credit' => $arrayItem[self::DEBIT_CREDIT],
                    'currency' => $arrayItem[self::CURRENCY],
                    'transaction_name' => $arrayItem[self::TRANSACTION_NAME] ?: $arrayItem[self::TRANSACTION_NAME_NOT_FOUND],
                ];
            }
        }
        return $array;
    }
}