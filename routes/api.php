<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Login Session
Route::post('/login', [AuthController::class, 'login']);
//Logout Session
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


