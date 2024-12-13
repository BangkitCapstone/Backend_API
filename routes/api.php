<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::post('/users/change-password', [UserController::class, 'changePassword']);
Route::post('/users/profile', [UserController::class, 'updateUser']);

Route::prefix('histories')->group(function () {
    Route::post('/user/all', [HistoryController::class, 'userHistories']);
    Route::post('/user/single', [HistoryController::class, 'userUploadHistory']);
    Route::post('/user/upload', [HistoryController::class, 'store']);
});

