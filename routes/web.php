<?php

use App\Http\Controllers\CarriereController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployePresenceController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('postes', PosteController::class);
    Route::resource('employes', EmployeController::class);
    Route::resource('presences', PresenceController::class);
    Route::resource('carrieres', CarriereController::class);
    Route::resource('conges', CongeController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('users', UserController::class);
});
Route::get('emp/presence', [EmployePresenceController::class, 'index']);
Route::post('emp/presence/check', [EmployePresenceController::class, 'check']);
Route::view('/qr-presence', 'presences.qr');

require __DIR__.'/auth.php';
