<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;

Route::get('/', [AssetController::class, 'index'])->name('assets.index');
Route::get('/assets/{id}', [AssetController::class, 'show'])->name('assets.show');
Route::get('/kelola-aset', [AssetController::class, 'manage'])->name('assets.manage');
Route::get('/faq', [AssetController::class, 'faq'])->name('faq');