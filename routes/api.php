<?php

use App\Http\Controllers\Api\Admin\Categories\CategoryBaseController;
use App\Http\Controllers\Api\Admin\Categories\CategoryController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::put('/user/update', [AuthController::class, 'updateUserProfile'])->middleware('auth:api');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'admin']], function () {
    Route::apiResource('categories', CategoryController::class);
});
