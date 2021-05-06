<?php

use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\TransactionController;
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

   // Current User Details
    Route::get('/users/me', MeController::class);


    Route::post('/change-password', ChangePasswordController::class);

    // Dashboard
    Route::get('/dashboard', DashboardController::class);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Budget
    Route::apiResource('budgets', BudgetController::class);

    //Transaction
    Route::apiResource('transactions', TransactionController::class);



});




