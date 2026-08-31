<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\JatuhTempoController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — KAI Tracker App
|--------------------------------------------------------------------------
*/

// ================= AUTHENTICATION & PASSWORD RESET =================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verifikasi-kode', [AuthController::class, 'showVerifyCode'])->name('password.verify');
Route::get('/ubah-kata-sandi', [AuthController::class, 'showResetPassword'])->name('password.reset');

// ================= PENGATURAN =================
Route::get('/pengaturan', function () {
    return view('settings.admin', ['active' => 'pengaturan']);
})->name('settings.index');

Route::get('/pengaturan-admin', function () {
    return view('settings.admin', ['active' => 'pengaturan']);
})->name('settings.admin');

Route::get('/pengaturan-superadmin', function () {
    return view('settings.index', ['active' => 'pengaturan']);
})->name('settings.superadmin');

// ================= DASHBOARD & MAP =================
Route::get('/', [DashboardController::class, 'index'])->name('welcome');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/map', [MapController::class, 'index'])->name('map');

// ================= DAFTAR KONTRAK =================
Route::get('/daftar-kontrak', [ContractController::class, 'index'])->name('contracts.index');
Route::get('/daftar-kontrak/{asset_number}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
Route::put('/daftar-kontrak/{asset_number}', [ContractController::class, 'update'])->name('contracts.update');
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.alias');

// ================= JATUH TEMPO =================
Route::get('/jatuh-tempo', [JatuhTempoController::class, 'index'])->name('due-dates.index');
Route::get('/jatuh-tempo/{asset_number}/edit', [JatuhTempoController::class, 'edit'])->name('due-dates.edit');
Route::put('/jatuh-tempo/{asset_number}', [JatuhTempoController::class, 'update'])->name('due-dates.update');

// ================= BACKLOG =================
Route::get('/backlog', [BacklogController::class, 'index'])->name('backlog.index');
Route::get('/backlog/{asset_number}/edit', [BacklogController::class, 'edit'])->name('backlog.edit');
Route::put('/backlog/{asset_number}', [BacklogController::class, 'update'])->name('backlog.update');

// ================= LAPORAN =================
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/{asset_number}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
Route::put('/laporan/{asset_number}', [LaporanController::class, 'update'])->name('laporan.update');
Route::get('/reports', [LaporanController::class, 'index'])->name('reports.alias');

// ================= DETAIL & HAPUS ASET =================
Route::get('/asset/{asset_number}', [AssetController::class, 'showKai'])->name('asset.detail');
Route::delete('/asset/{asset_number}', [AssetController::class, 'destroy'])->name('admin.assets.destroy');
Route::delete('/assets/{asset_number}', [AssetController::class, 'destroy'])->name('assets.destroy');
