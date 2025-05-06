<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SettingController;

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
