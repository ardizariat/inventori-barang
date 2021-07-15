<?php

namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;

Route::resource('/kategori', KategoriController::class)->except([
  'edit', 'create'
]);

Route::resource('/gudang', GudangController::class)->except([
  'edit', 'create',
]);

Route::resource('/produk', ProdukController::class);

Route::resource('/barang-masuk', BarangMasukController::class);
Route::post('/barang-masuk/change-data', [BarangMasukController::class, 'changeData'])->name('barang-masuk.change-data');

Route::resource('/barang-keluar', BarangKeluarController::class);
Route::post('/barang-keluar/change-data', [BarangKeluarController::class, 'changeData'])->name('barang-keluar.change-data');

Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
Route::post('/laporan/barang-masuk', [LaporanController::class, 'pdfBarangMasuk'])->name('laporan.barang-masuk.pdf');

Route::get('/laporan/produk', [LaporanController::class, 'produk'])->name('laporan.produk');
Route::post('/laporan/produk', [LaporanController::class, 'pdfProduk'])->name('laporan.produk.pdf');
