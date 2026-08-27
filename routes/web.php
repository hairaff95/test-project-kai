<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\JatuhTempoController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AssetManagementController;
use App\Http\Controllers\Admin\UserManagementController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public — redirect ke map karena pakai schema baru
Route::get('/', fn() => redirect()->route('map'))->name('assets.index');
Route::get('/assets', fn() => redirect()->route('map'))->name('assets.catalog');
Route::get('/assets/{id}', fn() => redirect()->route('map'))->name('assets.show');
Route::get('/faq', fn() => view('faq.index', ['role' => 'user']))->name('faq');
Route::get('/settings', fn() => view('settings.index', ['user' => null]))->name('settings');

// Fitur dari Teman (Map, Dashboard, Asset Detail, Daftar Kontrak, Jatuh Tempo)
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('welcome');
Route::get('/daftar-kontrak', [ContractController::class, 'index'])->name('contracts.index');
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.alias');
Route::get('/jatuh-tempo', [JatuhTempoController::class, 'index'])->name('due-dates.index');
Route::get('/backlog', [BacklogController::class, 'index'])->name('backlog.index');
Route::get('/asset/{asset_number}', [AssetController::class, 'showKai'])->name('asset.detail');

// Edit & Update aset — pakai KaiAsset (asset_number sebagai key)
Route::get('/admin/assets/{asset_number}/edit', function ($asset_number) {
    $asset = \App\Models\KaiAsset::with('contract.financial', 'contract.monthlySchedules')
        ->where('asset_number', $asset_number)->firstOrFail();
    return view('assets.edit', compact('asset'));
})->name('admin.assets.edit');

Route::put('/admin/assets/{asset_number}', [\App\Http\Controllers\Admin\AssetManagementController::class, 'updateKai'])->name('admin.assets.update');
Route::delete('/admin/assets/{asset_number}', [\App\Http\Controllers\Admin\AssetManagementController::class, 'destroyKai'])->name('admin.assets.destroy');

// Favorites — dinonaktifkan (tabel tidak ada di schema baru)
Route::get('/favorites', fn() => redirect()->route('map'))->name('favorites.index');
Route::post('/favorites/toggle', fn() => response()->json(['is_favorited' => false]))->name('favorites.toggle');

// Admin
Route::middleware(['auth', 'active_check', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('assets', AssetManagementController::class)->except(['edit', 'update', 'destroy']);
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

