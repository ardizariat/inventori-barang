<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;

Route::get('/', function () {
  return view('welcome');
});


Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
