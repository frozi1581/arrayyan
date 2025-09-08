<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\MurajaahController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Auth::routes();

// Google OAuth routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Groups
    Route::resource('groups', GroupController::class);
    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    
    // Santris
    Route::resource('santris', SantriController::class);
    
    // Hafalans
    Route::resource('hafalans', HafalanController::class);
    Route::post('/hafalans/{hafalan}/complete', [HafalanController::class, 'complete'])->name('hafalans.complete');
    
    // Murajaahs
    Route::resource('murajaahs', MurajaahController::class);
    Route::post('/murajaahs/{murajaah}/complete', [MurajaahController::class, 'complete'])->name('murajaahs.complete');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/santris', [AdminController::class, 'santris'])->name('santris');
        Route::get('/hafalans', [AdminController::class, 'hafalans'])->name('hafalans');
        Route::get('/murajaahs', [AdminController::class, 'murajaahs'])->name('murajaahs');
        Route::post('/hafalans/{hafalan}/review', [AdminController::class, 'reviewHafalan'])->name('hafalans.review');
        Route::post('/murajaahs/{murajaah}/review', [AdminController::class, 'reviewMurajaah'])->name('murajaahs.review');
    });
});
