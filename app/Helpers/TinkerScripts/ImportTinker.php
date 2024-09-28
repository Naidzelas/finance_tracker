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
        // var_dump($dataArray);
        // unset($dataArray[0],$dataArray[1]);
        // foreach ($dataArray as $arrayItem){
        //     $array[] = [
        //         'document_date' => $arrayItem[1],
        //         'amount' => $arrayItem[3],
        //         'debit_credit' => $arrayItem[14],
        //         'currency' => $arrayItem[2],
        //         'transaction_name' => $arrayItem[4],
        //     ];
        // }
        return $dataArray[1];
    }
}