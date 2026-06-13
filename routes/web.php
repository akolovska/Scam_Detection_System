<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScamReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('reports.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/reports', [ScamReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/create', [ScamReportController::class, 'create'])
        ->name('reports.create');
    Route::get('/reports/{id}', [ScamReportController::class, 'show'])
        ->name('reports.show');

    Route::post('/reports', [ScamReportController::class, 'store'])
        ->name('reports.store');

    Route::delete('/reports/{id}', [ScamReportController::class, 'destroy'])
        ->name('reports.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
