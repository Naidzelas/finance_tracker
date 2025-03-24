<?php

use App\Http\Controllers\document\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateSessionWithWorkOS;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('/download/{filename}', [DocumentController::class, 'download'])->name('document.download');
    Route::get('/open/{filename}', [DocumentController::class, 'open'])->name('document.open');
    Route::delete('/delete/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
});
