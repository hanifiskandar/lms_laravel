<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\LeaveController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//employee

Route::prefix('setting')->group(function () {
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/designations', [DesignationController::class, 'index']);
    Route::get('/states', [SettingController::class, 'states']);
    Route::get('/leave-types', [SettingController::class, 'leaveTypes']);
});

// Authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
// Route::get('users/{id}', [UserController::class, 'show'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {

    // Route User
    // Route::get('users', [UserController::class, 'index']);
    // Route::get('users/{id}', [UserController::class, 'show']);  
    // Route::post('users', [UserController::class, 'store']);
    // Route::patch('users/{id}', [UserController::class, 'update']);
    // Route::delete('users/{id}', [UserController::class, 'destroy']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('leave-requests', LeaveController::class);
    Route::get('/leave/balances', [LeaveBalanceController::class,'index']);

    //Route Leave Request
    // Route::post('leave-request', [LeaveRequest::class, 'store']);
    // Route::post('leave-request/{id}', [LeaveRequest::class, 'show']);

});
