<?php

namespace App\Http\Controllers\features;

use App\Http\Controllers\Controller;

class SWEDImportExpensesController extends Controller
{
    private const TRANSACTION_DATE = 2;
    private const AMOUNT = 6;
    private const DEBIT_CREDIT = 8;
    private const CURRENCY = 7;
    private const TRANSACTION_NAME = 3;
    private const TRANSACTION_NAME_NOT_FOUND = 5;
    private const IBAN = 4;

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
            foreach ($dataArray as $arrayItem) {
                $array[] = [
                    'transaction_date' => $arrayItem[self::TRANSACTION_DATE],
                    'amount' => $arrayItem[self::AMOUNT],
                    'debit_credit' => str_replace('K', 'C', $arrayItem[self::DEBIT_CREDIT]),
                    'currency' => $arrayItem[self::CURRENCY],
                    'transaction_name' => $arrayItem[self::TRANSACTION_NAME] ?: $arrayItem[self::TRANSACTION_NAME_NOT_FOUND],
                    'iban' => $arrayItem[self::IBAN]
                ];
            }
        }
        return $array;
    }
}
