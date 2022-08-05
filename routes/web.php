<?php

use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/apply-loan', [LoanController::class, 'applyLoan'])->name('apply-loan');
Route::post('/approve-loan', [LoanController::class, 'approveLoan'])->name('approve-loan');
Route::get('/loan-details/{user}', [LoanController::class, 'loanDetails'])->name('loan-Details');
Route::get('/pay/{loan}', [LoanController::class, 'pay'])->name('loan-Details');
// Route::get('/apply-loan', function () {
//     dd('apply-loan');
// })->name('apply-loan');
