<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\User;

use App\Http\Controllers\{CaptureCtrl,CaptureLogCtrl,StateCtrl,RecordsCtrl,Statel,Lgal};

Route::get('/', function () {
    //dd(User::all());
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('records', RecordsCtrl::class)->names('records');

Route::resource('states', StateCtrl::class)->names('statesl');
Route::resource('state2', Statel::class);//->names('statesl');
Route::resource('lga2', Lgal::class);//->names('statesl');
//StateCtrl

Route::get('/ev', function () {
    //dd(User::all());
    echo shell_exec('env');
    //dd();
});


//->prefix('v1')
Route::middleware(['auth'])->prefix('api')->group(function () {
        
    Route::post('/upload-photo', [CaptureCtrl::class, 'store']);//->middleware(['auth:sanctum']);
    Route::post('/enroll-photo', [CaptureCtrl::class, 'enroll']);//->middleware(['auth:sanctum']);
    Route::delete('/delete-photo', [CaptureCtrl::class, 'destroy']);//->middleware(['auth:sanctum']);

});

Route::get('/dashboard', [RecordsCtrl::class,'index'])->middleware(['auth'])->name('dashboard');

/*
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/


Route::get('/capture', [CaptureCtrl::class,'index'])->middleware(['auth'])->name('capture');

Route::get('/capturelog', [CaptureLogCtrl::class,'index'])->middleware(['auth'])->name('capturel');

Route::get('/capturelog/{id}', [CaptureLogCtrl::class,'show'])->middleware(['auth'])->name('capturel2');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
