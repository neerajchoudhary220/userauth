<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\employee\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeCrud;


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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/upload', [AuthController::class, 'upload']);
Route::post('/addemployee', [EmployeeController::class, 'addemployee']);
Route::post('/update_employee', [EmployeeController::class, 'update']);
Route::post('/destroy_employee', [EmployeeController::class, 'deleteEmployee']);
Route::get('/view', [EmployeeController::class, 'viewEmployeeList']);

Route::resource('/emp', EmployeeCrud::class, [
    'only' => ['show', 'update', 'index', 'store']
]);



Route::get('/emp/search', [EmployeeCrud::class, 'search']);

// Route::resource('/emp/search', EmployeeCrud::class, 'search');


//prtected
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/update_username', [ProfileController::class, 'updateUsername']);
});
