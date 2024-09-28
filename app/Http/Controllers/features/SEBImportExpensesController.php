<?php

namespace App\Http\Controllers\features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SEBImportExpensesController extends Controller
{
    const TRANSCATION_DATE = 1;
    const AMOUNT = 3;
    const DEBIT_CREDIT = 14;
    const CURRENCY = 2;
    const TRANSACTION_NAME = 4;

    public function __invoke(String $filename): array
    {
        $row = 1;
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $row++;
                $dataArray[] = $data;
            }
            fclose($handle);
            
            unset($dataArray[0],$dataArray[1]);
            foreach ($dataArray as $arrayItem){
                $array[] = [
                    'transaction_date' => $arrayItem[self::TRANSCATION_DATE],
                    'amount' => str_replace(',', '.',$arrayItem[self::AMOUNT]),
                    'debit_credit' => $arrayItem[self::DEBIT_CREDIT],
                    'currency' => $arrayItem[self::CURRENCY],
                    'transaction_name' => $arrayItem[self::TRANSACTION_NAME],
                ];
            }
        }
        return $array;
    }
}
