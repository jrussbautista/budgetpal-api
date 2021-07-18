<?php

use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\LoginWithGoogleController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UpdateProfileController;
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
Route::post('/login/google', LoginWithGoogleController::class);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/forgot-password', ForgotPasswordController::class);
Route::post('/reset-password', ResetPasswordController::class);


Route::group(['middleware' => ['auth:sanctum']], function () {

    // Categories
    Route::apiResource('categories', CategoryController::class);

   // Current User Details
    Route::get('/account/me', MeController::class);

    Route::post('/account/change-password', ChangePasswordController::class);

    Route::post('/account/update-profile', UpdateProfileController::class);

    // Dashboard
    Route::get('/dashboard', DashboardController::class);

    // Budget
    Route::apiResource('budgets', BudgetController::class);

    //Transaction
    Route::apiResource('transactions', TransactionController::class);

    //Reports
    Route::get('/reports', [ReportController::class, 'index']);

    //Settings
    Route::put('/settings', [SettingsController::class, 'update']);


});




