<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\employee\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeCrud;
use App\Http\Controllers\Mycontroller\MyController;


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



Route::get('/company', [MyController::class, 'company_related']);
// Route::get('/', [MyController::class, 'member_related']);
//public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/upload', [AuthController::class, 'upload']);
Route::post('/addemployee', [EmployeeController::class, 'addemployee']);
Route::post('/update_employee', [EmployeeController::class, 'update']);
Route::post('/destroy_employee', [EmployeeController::class, 'deleteEmployee']);
Route::get('/view', [EmployeeController::class, 'viewEmployeeList']);




Route::get('/emp', [EmployeeCrud::class, 'index']);
Route::post('/emp/create', [EmployeeCrud::class, 'store']);
Route::get('/emp/view/{id}', [EmployeeCrud::class, 'show']);
Route::put('/emp/update/{id}', [EmployeeCrud::class, 'update']);
Route::delete('/emp/delete/{id}', [EmployeeCrud::class, 'destroy']);
Route::get('/emp/status/{status}', [EmployeeCrud::class, 'statusFilter']);
Route::get('/emp/gender/{gender}', [EmployeeCrud::class, 'GenderFilter']);
Route::get('/emp/search/{search}', [EmployeeCrud::class, 'search']);

////
Route::get('/emp', [EmployeeCrud::class, 'index']); //search,filter
Route::post('/emp', [EmployeeCrud::class, 'store']); //store
Route::put('/emp/{id}', [EmployeeCrud::class, 'update']); //update
Route::delete('/emp/{id}', [EmployeeCrud::class, 'destroy']); //delete
Route::get('/emp/{employee}', [EmployeeCrud::class, 'show']); //show
////



//prtected
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/update_username', [ProfileController::class, 'updateUsername']);
});
