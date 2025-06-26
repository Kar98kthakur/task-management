<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    
    Route::get('/teams/join', [TeamController::class, 'joinForm'])->name('teams.join');
    Route::post('/teams/join', [TeamController::class, 'join'])->name('teams.join.submit');
});


Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
