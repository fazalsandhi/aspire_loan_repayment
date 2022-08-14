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

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');
Route::middleware('auth:api')->group(function () {
    Route::prefix('/customer')->namespace('Customer')->group(function(){
        Route::post('/create_loan_request','CustomerLoansController@create_loan_request'); 
        Route::get('/requested_loan_list','CustomerLoansController@requested_loan_list'); 
        Route::get('/loand_detail/{id}','CustomerLoansController@loand_detail'); 
        Route::post('/loand_repayment','CustomerLoansController@loand_repayment'); 
        
    });

    Route::prefix('/admin')->namespace('Admin')->group(function(){
        Route::get('/loan_requests','LoansController@loan_requests'); 
        Route::get('/loand_detail/{id}','LoansController@loand_detail'); 
        Route::get('/approve_loan/{id}','LoansController@approve_loan'); 
    });
});