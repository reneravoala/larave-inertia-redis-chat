<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/messages/{id}', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/discussion/{id}', [MessagesController::class, 'show'])->name('messages.show');
    Route::post('/discussion/{id}/create', [MessagesController::class, 'create'])->name('messages.create');

    Route::put('/set-read', [MessagesController::class, 'setRead'])->name('messages.set-read');

    Route::get('/create-thread', [MessagesController::class, 'createThread'])->name('create-thread');
    Route::post('/store-thread', [MessagesController::class, 'storeThread'])->name('store-thread');
});

require __DIR__.'/auth.php';
