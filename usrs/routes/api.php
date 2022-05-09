<?php

use App\Http\Controllers\AuthController;
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

//public
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/upload',[AuthController::class,'upload']);

//prtected
Route::group(['middleware'=>['auth:sanctum']],function(){

Route::post('/logout',[AuthController::class,'logout']);
Route::post('/update',[AuthController::class,'update']);
Route::post('/update_username',[AuthController::class,'updateUsername']);

});

