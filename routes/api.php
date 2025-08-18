<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaptureCtrl;

Route::post('/upload-photo', [CaptureCtrl::class, 'store'])->middleware(['auth']);
Route::post('/enroll-photo', [CaptureCtrl::class, 'enroll'])->middleware(['auth']);
Route::delete('/delete-photo', [CaptureCtrl::class, 'destroy'])->middleware(['auth']);

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/