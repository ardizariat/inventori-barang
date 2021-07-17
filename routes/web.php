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


//------------------------- Admin -------------------------//
Route::prefix('admin')->group(function () {
  Route::group(['middleware' => ['auth', 'verified', 'role:super-admin|admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('/kategori', KategoriController::class)->except([
      'edit', 'create'
    ]);

    Route::resource('/gudang', GudangController::class)->except([
      'edit', 'create',
    ]);

    Route::resource('/produk', ProdukController::class);

    Route::resource('/barang-masuk', BarangMasukController::class)->except([
      'edit', 'create', 'update'
    ]);
    Route::post('/change-data', [BarangMasukController::class, 'changeData'])->name('barang-masuk.change-data');

    Route::resource('/barang-keluar', BarangKeluarController::class)->except([
      'edit', 'update', 'create'
    ]);

    Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
    Route::post('/laporan/barang-masuk', [LaporanController::class, 'pdfBarangMasuk'])->name('laporan.barang-masuk.pdf');


    Route::get('/laporan/produk', [LaporanController::class, 'produk'])->name('laporan.produk');
    Route::post('/laporan/produk', [LaporanController::class, 'pdfProduk'])->name('laporan.produk.pdf');
  });
});
//------------------------- Admin -------------------------//

require __DIR__ . '/auth.php';
