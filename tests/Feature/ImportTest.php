<?php

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Http\Controllers\features\SWEDImportExpensesController;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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

  $data = [
    ['Sąskaitos_Nr.;blank1;Data;Gavėjas;Paaiškinimai;Suma;Valiuta;D/K;Įrašo_Nr.;Kodas;Įmokos_kodas;Dok_Nr.;Kliento_kodas_mokėtojo_IS;Kliento_kodas;Pradinis_mokėtojas;Galutinis_gavėjas;blank2'],
    [str_repeat('testing;', 17)],
    ["SWED calculation row"],
    ["SWED calculation row"],
    ["SWED calculation row"],
  ];
  $csvFile = fopen('test.csv', 'w');
  foreach ($data as $item){
    fputcsv($csvFile, $item);
  };
  fclose($csvFile);
  $swed = new SWEDImportExpensesController;
  $result = $swed('test.csv');
  expect($result)->toBeArray()->toHaveCount(1);
  unlink('test.csv');
});