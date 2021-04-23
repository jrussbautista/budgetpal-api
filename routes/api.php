<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/budgets', [\App\Http\Controllers\Api\BudgetController::class, 'index']);
    Route::post('/budgets', [\App\Http\Controllers\Api\BudgetController::class, 'store']);
    Route::put('/budgets/{budget}', [\App\Http\Controllers\Api\BudgetController::class, 'update']);
    Route::delete('/budgets/{budget}', [\App\Http\Controllers\Api\BudgetController::class, 'destroy']);
});




