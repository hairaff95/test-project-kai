<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Public
Route::get('/', [AssetController::class, 'index'])->name('assets.index');
Route::get('/assets/{id}', [AssetController::class, 'show'])->name('assets.show');
Route::get('/faq', [AssetController::class, 'faq'])->name('faq');

// Admin (protected)
Route::get('/kelola-aset', [AssetController::class, 'manage'])->name('assets.manage');