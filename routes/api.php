<?php


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


Route::group([
    'prefix' => 'v1',
    'namespace' => 'API',
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group([
        'middleware' => ['auth:api', 'roleChecker:' . config('constants.role.customer')],
    ], function () {
        Route::post('loan_request', 'LoanController@loan_requirement');
        Route::get('approve_view', 'LoanController@customer_view_loan');
        Route::put('repayment/{id}', 'LoanController@Repayment');
    });

    Route::group([
        'middleware' => ['auth:api', 'roleChecker:' . config('constants.role.admin')],
    ], function () {
        Route::get('loan_data', 'LoanController@display_loan_admin');
        Route::put('loan_approved/{id}', 'LoanController@loan_approve_admin');
    });
});
