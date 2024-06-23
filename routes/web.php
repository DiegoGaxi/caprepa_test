<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanAmountsController;

Route::resource('loans', LoanController::class);

Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientsController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store');
Route::get('/clients/{cliente}', [ClientsController::class, 'show'])->name('clients.show');
Route::get('/clients/{cliente}/edit', [ClientsController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{cliente}', [ClientsController::class, 'update'])->name('clients.update');
Route::delete('/clients/{cliente}', [ClientsController::class, 'destroy'])->name('clients.destroy');


Route::get('/loan_amounts', [LoanAmountsController::class, 'index'])->name('loan_amounts.index');
Route::get('/loan_amounts/create', [LoanAmountsController::class, 'create'])->name('loan_amounts.create');
Route::post('/loan_amounts', [LoanAmountsController::class, 'store'])->name('loan_amounts.store');
Route::get('/loan_amounts/{montoPrestamo}', [LoanAmountsController::class, 'show'])->name('loan_amounts.show');
Route::get('/loan_amounts/{montoPrestamo}/edit', [LoanAmountsController::class, 'edit'])->name('loan_amounts.edit');
Route::put('/loan_amounts/{montoPrestamo}', [LoanAmountsController::class, 'update'])->name('loan_amounts.update');
Route::delete('/loan_amounts/{montoPrestamo}', [LoanAmountsController::class, 'destroy'])->name('loan_amounts.destroy');


Route::get('/', function () {
    return view('app');
});
