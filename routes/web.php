<?php

use App\Http\Controllers\TenderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/get/tenders', [TenderController::class, 'importTenders'])->name('get.tenders');
    Route::get('/detail/{id}', [TenderController::class, 'tenderDetails'])->name('tender.details');
    Route::post('/dashboard/tender/file', [TenderController::class, 'downloadTenderFile'])->name('download.tender.file');



});
