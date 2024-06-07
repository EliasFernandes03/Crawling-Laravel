<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;

Route::get('/currency/{codes}', [CurrencyController::class, 'fetchCurrency']);
Route::get('/getdata', [CurrencyController::class, 'fetchAllCurrencies']);
Route::get('/getone', [CurrencyController::class, 'fetchCurrencyByCodeAndDate']);