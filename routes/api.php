<?php

use Illuminate\Support\Facades\Route;
use LoanHistory\Modules\Auth\Api\v1\Controllers\AuthController;
use LoanHistory\Modules\Loan\Api\v1\Controllers\LoanCategoryController;
use LoanHistory\Modules\Loan\Api\v1\Controllers\LoanController;


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

/** Authentication Route */
Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', [AuthController::class,'login']);
    Route::get('user', [AuthController::class, 'getAuthUser'])->middleware('auth:api');
});

Route::group(['prefix' => 'auth',  'middleware' => 'auth:api'], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
});

    /** Loan Categories */
Route::group(['prefix' => 'loan',  'middleware' => 'auth:api'], function() {
    Route::get('category', [LoanCategoryController::class,'index']);
    Route::get('category/{id}', [LoanCategoryController::class,'show']);

    Route::group(['middleware' => 'super_admin'], function() {
        Route::post('category', [LoanCategoryController::class, 'add']);
        Route::post('category/{id}', [LoanCategoryController::class, 'update']);
        Route::delete('category/{id}', [LoanCategoryController::class, 'delete']);
    });

});


    /** Loan */
Route::group(['prefix' => 'loan',  'middleware' => 'auth:api'], function() {
    Route::group(['middleware' => 'super_admin'], function() {
        Route::post('approve', [LoanController::class,'approveLoan']);
        Route::post('', [LoanController::class,'createLoan']);
    });

    Route::post('request', [LoanController::class, 'requestLoan']);
    Route::get('', [LoanController::class, 'index']);
    Route::get('applied', [LoanController::class, 'appliedLoan']);
    Route::post('payback', [LoanController::class, 'makeDailyPayment']);

    /** Loan Transactions */
    Route::get('transaction', [LoanController::class, 'transaction']);


    /** Loan Interest */
    Route::get('interest', [LoanController::class, 'showLoanInterest']);
    /** Loan Penalty */
    Route::get('penalty', [LoanController::class, 'showLoanPenalties']);
});




