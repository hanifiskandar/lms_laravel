<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//employee
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);  
Route::post('users', [UserController::class, 'store']);
Route::patch('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

Route::get('/setting/departments', [DepartmentController::class, 'index']);
Route::get('/setting/designations', [DesignationController::class, 'index']);
Route::get('/setting/states', [SettingController::class, 'states']);


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/employees', [UserController::class, 'store']);
    // Route::get('/employees/{id}', [UserController::class, 'show']);
    // Route::put('/employees/{id}', [UserController::class, 'update']);
    // Route::get('/departments', [DepartmentController::class, 'index']);

    // Route::get('users', [UserController::class, 'index']);
    // Route::get('users/{id}', [UserController::class, 'show']);  
    // Route::post('users', [UserController::class, 'store']);
    // Route::patch('users/{id}', [UserController::class, 'update']);
    // Route::delete('users/{id}', [UserController::class, 'destroy']);
});
