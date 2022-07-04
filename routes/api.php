<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use \App\Models\Historic;
use \App\Models\Balance;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [ApiController::class, 'login']);

Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::get('/historic', [ApiController::class, 'get']);
    Route::post('/transfer', [ApiController::class, 'post']); 
});
