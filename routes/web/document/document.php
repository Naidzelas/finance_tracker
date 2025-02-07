<?php

use App\Http\Controllers\document\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/download/{filename}', [DocumentController::class, 'download'])->name('document.download');
Route::get('/open/{filename}', [DocumentController::class, 'open'])->name('document.open');
Route::delete('/delete/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');