<?php

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::post('deposit', [App\Http\Controllers\BalanceController::class, 'store'])->name('deposit.store');       
    Route::get('deposit', [App\Http\Controllers\BalanceController::class, 'deposit'])->name('balance.deposit');       
    Route::get('balance', [App\Http\Controllers\BalanceController::class, 'index'])->name('admin.balance'); 
    
    Route::get('withdraw', [App\Http\Controllers\BalanceController::class, 'withdraw'])->name('balance.withdraw');
    Route::post('withdraw', [App\Http\Controllers\BalanceController::class, 'withdrawStore'])->name('withdraw.store');

    Route::get('transfer', [App\Http\Controllers\BalanceController::class, 'transfer'])->name('balance.transfer');
    Route::post('confirm-transfer', [App\Http\Controllers\BalanceController::class, 'confirmTransfer'])->name('confirm.transfer');
    Route::post('transfer', [App\Http\Controllers\BalanceController::class, 'transferStore'])->name('transfer.store');

    Route::get('historic', [App\Http\Controllers\BalanceController::class, 'historic'])->name('admin.historic');
    Route::any('historic-search', [App\Http\Controllers\BalanceController::class, 'searchHistoric'])->name('historic.search');
    
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');

});

Route::get('meu-perfil', [App\Http\Controllers\UserController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('atualizar-perfil', [App\Http\Controllers\UserController::class, 'profileUpdate'])->name('profile.update')->middleware('auth');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
