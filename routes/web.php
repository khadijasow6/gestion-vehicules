<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ClientController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('reservations', ReservationController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class)->only(['index','show']);
});



require __DIR__.'/auth.php';
