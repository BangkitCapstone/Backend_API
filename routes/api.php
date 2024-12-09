<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::post('/images',[ImageController::class,'uploadToCloudStorage']);

Route::prefix('histories')->group(function () {
    Route::get('user/{userId}', [HistoryController::class, 'userHistories']);
    Route::get('user/{userId}/upload/{uploadId}', [HistoryController::class, 'userUploadHistory']);
    Route::post('', [HistoryController::class, 'store']);
});


