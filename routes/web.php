<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); 
});

Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('welcome');

Route::get('/asset/{id}', function ($id) {
    return view('asset-detail', [
        'id' => $id
    ]);
})->name('asset.detail');