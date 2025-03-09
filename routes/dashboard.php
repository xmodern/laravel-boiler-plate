<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Dashboard\AnnouncementController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('/', [PageController::class, 'dashboard'])->name('index');

        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])
            ->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])
            ->name('announcements.store');
        Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])
            ->name('announcements.show');
        Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])
            ->name('announcements.edit');
        Route::patch('/announcements/{announcement}', [AnnouncementController::class, 'update'])
            ->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
            ->name('announcements.destroy');
    });
});


