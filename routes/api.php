<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\performanceController;
use App\Http\Controllers\userController;

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



Route::group(['prefix' => 'user'], function()
{
    Route::get('consultans', [userController::class, 'consultans']);
});



Route::group(['prefix' => 'peformance'], function()
{
    Route::get('users', [performanceController::class, 'users']);
});
