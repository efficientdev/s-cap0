<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\User;

use App\Http\Controllers\{CaptureCtrl,CaptureLogCtrl};

Route::get('/', function () {
    //dd(User::all());
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/ev', function () {
    //dd(User::all());
    dd(echo shell_exec('env'));
});


//->prefix('v1')
Route::middleware(['auth'])->prefix('api')->group(function () {
        
    Route::post('/upload-photo', [CaptureCtrl::class, 'store']);//->middleware(['auth:sanctum']);
    Route::post('/enroll-photo', [CaptureCtrl::class, 'enroll']);//->middleware(['auth:sanctum']);
    Route::delete('/delete-photo', [CaptureCtrl::class, 'destroy']);//->middleware(['auth:sanctum']);

});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/capture', [CaptureCtrl::class,'index'])->middleware(['auth'])->name('capture');

Route::get('/capturelog', [CaptureLogCtrl::class,'index'])->middleware(['auth'])->name('capturel');

Route::get('/capturelog/{id}', [CaptureLogCtrl::class,'show'])->middleware(['auth'])->name('capturel2');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
