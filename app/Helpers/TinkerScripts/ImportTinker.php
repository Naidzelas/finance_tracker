<?php

function run()
{
    $row = 1;
    if (($handle = fopen("C:\\Users\\Naidzelas\\Desktop\\statement.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $row++;
            $dataArray[] = $data;
        }
        fclose($handle);
        
        unset($dataArray[0]);
        array_splice($dataArray, count($dataArray) - 3, 3);
        foreach ($dataArray as $arrayItem){
            $array[] = [
                'transaction_date' => $arrayItem[2],
                'amount' => $arrayItem[5],
                'debit_credit' => $arrayItem[7],
                'currency' => $arrayItem[6],
                'transaction_name' => $arrayItem[3] ?: $arrayItem[4],
            ];
        }
        return $array;
    }
}