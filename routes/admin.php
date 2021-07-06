<?php

use App\Http\Controllers\Admin\BarangMasukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\KategoriController;

Route::resource('/kategori', KategoriController::class)->except([
  'edit', 'create'
]);

Route::resource('/gudang', GudangController::class)->except([
  'edit', 'create'
]);

Route::resource('/produk', ProdukController::class);

Route::resource('/barang-masuk', BarangMasukController::class);
