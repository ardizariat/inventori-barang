<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\KategoriController;

Route::resource('/kategori', KategoriController::class)->except([
  'edit', 'create'
]);

Route::resource('/gudang', GudangController::class)->except([
  'edit', 'create'
]);
