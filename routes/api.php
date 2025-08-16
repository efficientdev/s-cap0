<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaptureCtrl;

Route::post('/upload-photo', [CaptureCtrl::class, 'store']);
Route::post('/enroll-photo', [CaptureCtrl::class, 'enroll']);
Route::delete('/delete-photo', [CaptureCtrl::class, 'destroy']);

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/