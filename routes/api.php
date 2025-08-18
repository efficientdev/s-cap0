<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaptureCtrl;

//->prefix('v1')
Route::middleware(['auth:sanctum'])->group(function () {
	    
	Route::post('/upload-photo', [CaptureCtrl::class, 'store']);//->middleware(['auth:sanctum']);
	Route::post('/enroll-photo', [CaptureCtrl::class, 'enroll']);//->middleware(['auth:sanctum']);
	Route::delete('/delete-photo', [CaptureCtrl::class, 'destroy']);//->middleware(['auth:sanctum']);

});
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/