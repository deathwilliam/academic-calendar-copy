<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Calendar Route
Route::get('/calendar', [\App\Http\Controllers\PublicCalendarController::class, 'index'])->name('calendar.public');
Route::get('/calendar/export-pdf', [\App\Http\Controllers\PublicCalendarController::class, 'exportPdf'])->name('calendar.export-pdf');


// Auditor Routes (View events and history - Admin, Editor, Auditor)
Route::middleware(['auth', 'auditor'])->group(function () {
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}/audits', [\App\Http\Controllers\EventController::class, 'audits'])->name('events.audits');
});

// Editor Routes (Admin + Editor can create/edit)
Route::middleware(['auth', 'editor'])->group(function () {
    Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])->name('events.create');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
    Route::patch('/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
});

// Admin Only Routes (Delete, Revert)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::delete('/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/revert/{audit}', [\App\Http\Controllers\EventController::class, 'revert'])->name('events.revert');
});


/*
|--------------------------------------------------------------------------
| Database Seeding Routes (Development Only - Removed)
|--------------------------------------------------------------------------
|
| For seeding users and events, use Laravel seeders instead:
|   php artisan db:seed --class=RoleUsersSeeder
|   php artisan db:seed --class=EventSeeder
|
*/

require __DIR__ . '/auth.php';

