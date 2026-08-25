<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\AssetManagementController;
use App\Http\Controllers\Admin\UserManagementController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public
Route::get('/', [AssetController::class, 'index'])->name('assets.index');
Route::get('/assets', [AssetController::class, 'catalog'])->name('assets.catalog');
Route::get('/assets/{id}', [AssetController::class, 'show'])->name('assets.show');
Route::get('/faq', [AssetController::class, 'faq'])->name('faq');
Route::get('/settings', [AssetController::class, 'settings'])->name('settings');

// Fitur dari Teman (Map, Dashboard, Asset Detail)
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('welcome');
Route::get('/asset/{id}', function ($id) {
    return view('asset-detail', [
        'id' => $id
    ]);
})->name('asset.detail');

// Favorites
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Admin
Route::middleware(['auth', 'active_check', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('assets', AssetManagementController::class);
    Route::get('/kelola-aset-redirect', fn() => redirect()->route('admin.assets.index'))->name('assets.legacy_redirect');
});

// Super Admin
Route::middleware(['auth', 'active_check', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserManagementController::class)->except(['show', 'create', 'edit']);
    Route::post('users/{user}/kick', [UserManagementController::class, 'kickUser'])->name('users.kick');
});

// Legacy route alias
Route::get('/kelola-aset', fn() => redirect()->route('admin.assets.index'))
    ->middleware(['auth', 'active_check', 'role:admin,superadmin'])
    ->name('assets.manage');

