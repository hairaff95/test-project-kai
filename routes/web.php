<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\JatuhTempoController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PasswordResetRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — KAI Tracker App
|--------------------------------------------------------------------------
*/

// ================= TEST EMAIL (HAPUS SETELAH TESTING) =================
Route::get('/test-mail', function () {
    $mailer = config('mail.default');
    $host   = config('mail.mailers.smtp.host');
    $user   = config('mail.mailers.smtp.username');

    try {
        \Illuminate\Support\Facades\Mail::raw('Test OTP KAI - ' . now(), function ($msg) {
            $msg->to('satosinaka4@gmail.com')->subject('Test KAI ' . now());
        });
        return "SENT OK — mailer:{$mailer} host:{$host} user:{$user}";
    } catch (\Exception $e) {
        return "ERROR: " . $e->getMessage() . " — mailer:{$mailer} host:{$host} user:{$user}";
    }
});

// ================= AUTHENTICATION =================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ALUR RESET PASSWORD ADMIN =================
// Step 1: Admin klik "Ubah kata sandi" → form request ke super admin
Route::get('/ubah-kata-sandi/request', [PasswordResetRequestController::class, 'showRequestForm'])->name('password.request');
Route::post('/ubah-kata-sandi/request', [PasswordResetRequestController::class, 'submitRequest'])->name('password.submit-request');

// Status request
Route::get('/ubah-kata-sandi/status', [PasswordResetRequestController::class, 'requestStatus'])
    ->middleware(['auth', 'active_check'])
    ->name('password.request.status');

// Link dari email: admin akses halaman OTP via token (ID request)
Route::get('/ubah-kata-sandi/akses/{resetRequest}', [PasswordResetRequestController::class, 'accessViaToken'])->name('password.access-token');

// Step 2: Masukkan OTP
Route::get('/verifikasi-kode', [AuthController::class, 'showVerifyCode'])->name('password.verify');
Route::post('/verifikasi-kode', [PasswordResetRequestController::class, 'verifyOtp'])->name('password.verify.post');

// Step 3: Atur password baru
Route::get('/ubah-kata-sandi', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/ubah-kata-sandi', [PasswordResetRequestController::class, 'resetPassword'])->name('password.reset.post');

// ================= SUPER ADMIN PANEL =================
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'active_check', 'role:superadmin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Admin
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'adminIndex'])->name('index');
        Route::get('/create', [SuperAdminController::class, 'adminCreate'])->name('create');
        Route::post('/', [SuperAdminController::class, 'adminStore'])->name('store');
        Route::get('/{admin}/edit', [SuperAdminController::class, 'adminEdit'])->name('edit');
        Route::put('/{admin}', [SuperAdminController::class, 'adminUpdate'])->name('update');
        Route::patch('/{admin}/toggle', [SuperAdminController::class, 'adminToggleActive'])->name('toggle');
        Route::delete('/{admin}', [SuperAdminController::class, 'adminDestroy'])->name('destroy');
    });

    // Kelola Reset Password Requests
    Route::get('/reset-requests', [SuperAdminController::class, 'resetRequests'])->name('reset-requests');
    Route::patch('/reset-requests/{resetRequest}/approve', [SuperAdminController::class, 'approveRequest'])->name('reset-requests.approve');
    Route::patch('/reset-requests/{resetRequest}/reject', [SuperAdminController::class, 'rejectRequest'])->name('reset-requests.reject');

});

// ================= PENGATURAN =================
Route::get('/pengaturan', function () {
    return view('settings.index', ['active' => 'pengaturan']);
})->middleware(['auth', 'active_check'])->name('settings.index');

// ================= MAIN APP (semua user, termasuk guest) =================
Route::middleware(['active_check'])->group(function () {

    // Dashboard & Map
    Route::get('/', [DashboardController::class, 'index'])->name('welcome');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [MapController::class, 'index'])->name('map');

    // Daftar Kontrak
    Route::get('/daftar-kontrak', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.alias');

    // Jatuh Tempo
    Route::get('/jatuh-tempo', [JatuhTempoController::class, 'index'])->name('due-dates.index');

    // Backlog
    Route::get('/backlog', [BacklogController::class, 'index'])->name('backlog.index');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/reports', [LaporanController::class, 'index'])->name('reports.alias');

    // Detail Aset (read-only untuk semua)
    Route::get('/asset/{asset_number}', [AssetController::class, 'showKai'])->name('asset.detail');

});

// ================= ADMIN ONLY ROUTES (CRUD) =================
Route::middleware(['auth', 'active_check', 'role:admin,superadmin'])->group(function () {

    // Edit Kontrak
    Route::get('/daftar-kontrak/{asset_number}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/daftar-kontrak/{asset_number}', [ContractController::class, 'update'])->name('contracts.update');

    // Edit Jatuh Tempo
    Route::get('/jatuh-tempo/{asset_number}/edit', [JatuhTempoController::class, 'edit'])->name('due-dates.edit');
    Route::put('/jatuh-tempo/{asset_number}', [JatuhTempoController::class, 'update'])->name('due-dates.update');

    // Edit Backlog
    Route::get('/backlog/{asset_number}/edit', [BacklogController::class, 'edit'])->name('backlog.edit');
    Route::put('/backlog/{asset_number}', [BacklogController::class, 'update'])->name('backlog.update');

    // Edit Laporan
    Route::get('/laporan/{asset_number}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{asset_number}', [LaporanController::class, 'update'])->name('laporan.update');

    // Hapus Aset
    Route::delete('/asset/{asset_number}', [AssetController::class, 'destroy'])->name('admin.assets.destroy');
    Route::delete('/assets/{asset_number}', [AssetController::class, 'destroy'])->name('assets.destroy');

});
