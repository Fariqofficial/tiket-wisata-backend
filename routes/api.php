<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GetProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Login Session
Route::post('/login', [AuthController::class, 'login']);
//Logout Session
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//Get Product
Route::apiResource('/api-products', GetProductController::class)->middleware('auth:sanctum');
//Get Category
Route::apiResource('/api-categories', CategoryController::class)->middleware('auth:sanctum');

