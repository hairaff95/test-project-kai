<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\JatuhTempoController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\NotificationController;
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

use App\Http\Controllers\ExcelImportController;

// ================= PENGATURAN =================
Route::get('/pengaturan', function () {
    if (auth()->check() && auth()->user()->isSuperAdmin()) {
        return view('settings.index', ['active' => 'pengaturan']);
    }
    return view('settings.admin', ['active' => 'pengaturan']);
})->name('settings.index');

Route::get('/pengaturan-admin', function () {
    return view('settings.admin', ['active' => 'pengaturan']);
})->name('settings.admin');

Route::get('/pengaturan-superadmin', function () {
    return view('settings.index', ['active' => 'pengaturan']);
})->name('settings.superadmin');

Route::get('/superadmin/dashboard', function () {
    return redirect()->route('settings.superadmin');
})->name('superadmin.dashboard');

// ================= DASHBOARD & MAP =================
Route::get('/', [DashboardController::class, 'index'])->name('welcome');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/map', [MapController::class, 'index'])->name('map');

// ================= DAFTAR KONTRAK =================
Route::get('/daftar-kontrak', [ContractController::class, 'index'])->name('contracts.index');
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.alias');

// ================= JATUH TEMPO =================
Route::get('/jatuh-tempo', [JatuhTempoController::class, 'index'])->name('due-dates.index');

// ================= BACKLOG =================
Route::get('/backlog', [BacklogController::class, 'index'])->name('backlog.index');

// ================= LAPORAN =================
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/reports', [LaporanController::class, 'index'])->name('reports.alias');

// ================= DETAIL ASET =================
Route::get('/asset/{asset_number}', [AssetController::class, 'showKai'])->name('asset.detail')->where('asset_number', '.*');

// ================= AUTH PROTECTED CRUD & MUTATIONS (ADMIN ONLY) =================
Route::middleware('auth')->group(function () {
    // Import Excel
    Route::post('/pengaturan/import-excel', [ExcelImportController::class, 'import'])->name('settings.import-excel');
    Route::get('/pengaturan/download-template', [ExcelImportController::class, 'downloadTemplate'])->name('settings.download-template');

    // Kontrak / Tambah Aset
    Route::get('/daftar-kontrak/tambah', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/daftar-kontrak', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/daftar-kontrak/{asset_number}/edit', [ContractController::class, 'edit'])->name('contracts.edit')->where('asset_number', '.*');
    Route::put('/daftar-kontrak/{asset_number}', [ContractController::class, 'update'])->name('contracts.update')->where('asset_number', '.*');
    Route::get('/asset/tambah', [ContractController::class, 'create'])->name('assets.create');

    // Jatuh Tempo
    Route::get('/jatuh-tempo/{asset_number}/edit', [JatuhTempoController::class, 'edit'])->name('due-dates.edit')->where('asset_number', '.*');
    Route::put('/jatuh-tempo/{asset_number}', [JatuhTempoController::class, 'update'])->name('due-dates.update')->where('asset_number', '.*');

    // Backlog
    Route::get('/backlog/{asset_number}/edit', [BacklogController::class, 'edit'])->name('backlog.edit')->where('asset_number', '.*');
    Route::put('/backlog/{asset_number}', [BacklogController::class, 'update'])->name('backlog.update')->where('asset_number', '.*');

    // Laporan
    Route::get('/laporan/{asset_number}/edit', [LaporanController::class, 'edit'])->name('laporan.edit')->where('asset_number', '.*');
    Route::put('/laporan/{asset_number}', [LaporanController::class, 'update'])->name('laporan.update')->where('asset_number', '.*');

    // Detail Lanjutan Update
    Route::put('/asset/{asset_number}', [AssetController::class, 'update'])->name('assets.update')->where('asset_number', '.*');
    Route::post('/asset/{asset_number}/edit', [AssetController::class, 'update'])->name('assets.update.post')->where('asset_number', '.*');

    // Hapus Aset / Kontrak
    Route::delete('/asset/{asset_number}', [AssetController::class, 'destroy'])->name('admin.assets.destroy')->where('asset_number', '.*');
    Route::delete('/assets/{asset_number}', [AssetController::class, 'destroy'])->name('assets.destroy')->where('asset_number', '.*');
});

// ================= NOTIFIKASI =================
Route::get('/api/notifications/new-assets', [NotificationController::class, 'newAssets'])->name('notifications.new-assets');
