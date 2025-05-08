<?php

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Http\Controllers\features\SWEDImportExpensesController;

it('reads seb csv successfully', function () {

    $data = [
      ['Row of record datetime'],
      ['DOK_NR.;DATA;VALIUTA;SUMA;MOKĖTOJO_ARBA_GAVĖJO_PAVADINIMAS;MOKĖTOJO_ARBA_GAVĖJO_IDENTIFIKACINIS_KODAS;SĄSKAITA;KREDITO_ĮSTAIGOS_PAVADINIMAS;KREDITO_ĮSTAIGOS_SWIFT_KODAS;MOKĖJIMO_PASKIRTIS;TRANSAKCIJOS_KODAS;DOKUMENTO_DATA;TRANSAKCIJOS_TIPAS;NUORODA;DEBETAS/KREDITAS;SUMA_SĄSKAITOS_VALIUTA;SĄSKAITOS_NR;SĄSKAITOS_VALIUTA'],
      [str_repeat('testing;', 14)]
    ];
    $csvFile = fopen('test.csv', 'w');
    foreach ($data as $item){
      fputcsv($csvFile, $item);
    };
    fclose($csvFile);
    $seb = new SEBImportExpensesController;
    $result = $seb('test.csv');
    expect($result)->toBeArray()->toHaveCount(1);
    unlink('test.csv');
});

it('reads swedbank csv successfully', function () {
  // Create a test CSV file with a header and one valid data row
  $data = [
      ['Sąskaitos Nr.', '', 'Data', 'Gavėjas', 'Gavėjo sąskaita', 'Paaiškinimai', 'Suma', 'Valiuta', 'D/K', 'Įrašo Nr.', 'Kodas', 'Įmokos kodas', 'Dok. Nr.', 'Kliento kodas mokėtojo IS', 'Kliento kodas', 'Pradinis mokėtojas', 'Galutinis gavėjas'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
      ['LT123456789', '', '2023-10-01', 'John Doe', 'LT987654321', 'Payment for services', '100.00', 'EUR', 'D', '12345', '001', '1001', 'DOC123', 'CUST001', 'CUST002', 'Initial Payer', 'Final Receiver'],
  ];
  $csvFile = fopen('test.csv', 'w');
  foreach ($data as $item){
    fputcsv($csvFile, $item);
  };
  fclose($csvFile);
  $swed = new SWEDImportExpensesController;
  $result = $swed('test.csv');
  expect($result)->toBeArray()->toHaveCount(6);
  unlink('test.csv');
});