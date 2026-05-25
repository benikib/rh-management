<?php

use App\Http\Controllers\CarriereController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CritereController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('directions', DirectionController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('postes', PosteController::class);
    Route::resource('employes', EmployeController::class);
    Route::resource('presences', PresenceController::class);
    Route::resource('carrieres', CarriereController::class);
    Route::resource('conges', CongeController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('users', UserController::class);
    Route::resource('criteres', CritereController::class);

    Route::get('/dashboard/stats/global', [DashboardController::class, 'globalStats'])->name('dashboard.stats.global');
    Route::get('/dashboard/stats/departments', [DashboardController::class, 'departmentStats'])->name('dashboard.stats.departments');
    Route::get('/dashboard/stats/directions', [DashboardController::class, 'directionStats'])->name('dashboard.stats.directions');

    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/preview', [App\Http\Controllers\ReportController::class, 'preview'])->name('reports.preview');
    Route::post('/reports/export/pdf', [App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::post('/reports/export/excel', [App\Http\Controllers\ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/{report}/download', [App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');
    Route::delete('/reports/{report}', [App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.destroy');
    Route::post('/reports/{report}/regenerate', [App\Http\Controllers\ReportController::class, 'regenerate'])->name('reports.regenerate');
});
Route::get('emp/presence', [EmployePresenceController::class, 'index']);
Route::post('emp/presence/check', [EmployePresenceController::class, 'check']);
Route::view('/qr-presence', 'presences.qr');
use App\Http\Controllers\QRCodeController;

// Routes QR Code


// Routes QR Code
Route::prefix('qr')->group(function () {
    Route::get('/', [QRCodeController::class, 'index'])->name('qr.index');
    Route::get('/scan/{token}', [QRCodeController::class, 'scanForm']);
    Route::post('/pointage', [QRCodeController::class, 'pointage']);
    Route::post('/pointage-manuel', [QRCodeController::class, 'pointageManuel']); // Nouvelle route
    Route::post('/regenerate', [QRCodeController::class, 'regenerate']);
});

Route::post('/qr/verifier-employe', [QRCodeController::class, 'verifierEmploye']);

use App\Http\Controllers\EvaluationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/evaluations', [EvaluationController::class, 'all'])->name('evaluations.all');
    Route::get('/evaluations/employe/{matricule}', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/employe/{matricule}/create', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::post('/evaluations/store', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluations/{evaluation}', [EvaluationController::class, 'show'])->name('evaluations.show');
    Route::get('/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
    Route::put('/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluations.update');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');
});

require __DIR__.'/auth.php';
