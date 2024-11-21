<?php

use App\Http\Controllers\Conversion\ConversionController;
use App\Http\Controllers\Currency\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:10,1'])->group(function () {
    Route::get('/convert', [ConversionController::class, 'convertForm']);
    Route::post('/convert', [ConversionController::class, 'convert'])->name('convert');
    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
});
