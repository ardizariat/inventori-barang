<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PBController;
use App\Http\Controllers\Admin\PBDetailController;
use App\Http\Controllers\Admin\PRController;
use App\Http\Controllers\Admin\PRDetailController;
use App\Http\Controllers\Admin\POController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LogActivityController;
use App\Http\Controllers\Admin\ProfileUserController;

Route::group(['middleware' => ['auth', 'role:super-admin|admin|direktur|dept_head|sect_head']], function () {

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
  Route::get('/dashboard/date', [DashboardController::class, 'date'])->name('dashboard.date');

  Route::resource('/kategori', KategoriController::class)->except([
    'create', 'edit'
  ]);

  Route::resource('/supplier', SupplierController::class)->except([
    'create', 'edit'
  ]);

  Route::resource('/gudang', GudangController::class)->except([
    'create', 'edit'
  ]);

  Route::resource('/produk', ProdukController::class);
  Route::get('/produk/barang-masuk/{id}', [ProdukController::class, 'barangMasuk'])->name('produk.barang-masuk');
  Route::get('/produk/barang-keluar/{id}', [ProdukController::class, 'barangKeluar'])->name('produk.barang-keluar');


  Route::resource('/user', UserController::class)->except([
    'update', 'edit', 'show', 'destroy'
  ]);

  //------------------------- PB -----------------------------------//
  Route::resource('/pb', PBController::class)->except([
    'store', 'edit', 'update'
  ]);
  Route::post('/pb/{id}/download-pdf', [PBController::class, 'downloadPdf'])->name('pb.download-pdf');
  Route::put('/pb/{id}/update-status', [PBController::class, 'updateStatus'])->name('pb.update-status');
  Route::delete('/pb/{id}/delete-item', [PBController::class, 'deleteItem'])->name('pb.delete-item');

  Route::get('/pb-detail/produk/{id}', [PBDetailController::class, 'produk'])->name('pb-detail.produk');
  Route::resource('/pb-detail', PBDetailController::class)->except([
    'index', 'edit'
  ]);

  //------------------------- PR -----------------------------------//
  Route::resource('/pr', PRController::class)->except([
    'store', 'edit', 'update'
  ]);
  Route::post('/pr/{id}/download-pdf', [PRController::class, 'downloadPdf'])->name('pr.download-pdf');
  Route::put('/pr/{id}/update-status', [PRController::class, 'updateStatus'])->name('pr.update-status');
  Route::delete('/pr/{id}/delete-item', [PRController::class, 'deleteItem'])->name('pr.delete-item');
  Route::delete('/pr/{id}/cancel', [PRController::class, 'cancel'])->name('pr.cancel');

  Route::get('/pr-detail/produk/{id}', [PRDetailController::class, 'produk'])->name('pr-detail.produk');
  Route::resource('/pr-detail', PRDetailController::class)->except([
    'index', 'edit', 'store'
  ]);
  Route::post('/pr-detail/produk', [PRDetailController::class, 'produkStore'])->name('pr.produk.store');

  //------------------------- PO -----------------------------------// 
  Route::resource('/po', POController::class)->except([
    'create', 'edit', 'destroy'
  ]);
  Route::post('/po/{id}/download-pdf', [POController::class, 'downloadPdf'])->name('po.download-pdf');
  Route::post('/po/data', [POController::class, 'data'])->name('po.data');
  Route::delete('/po/{id}/delete-item', [POController::class, 'deleteItem'])->name('po.delete-item');


  //------------------------- BarangMasuk -----------------------------------// 
  Route::resource('/barang-masuk', BarangMasukController::class)->except([
    'store', 'create', 'show', 'update', 'destroy'
  ]);
  Route::get('/barang-masuk/{id}/po', [BarangMasukController::class, 'showPo'])->name('barang-masuk.po-show');
  Route::post('/barang-masuk/po/', [BarangMasukController::class, 'po'])->name('barang-masuk.po');
  Route::post('/barang-masuk/show-po/', [BarangMasukController::class, 'dataPo'])->name('barang-masuk.show-po');
  Route::put('/barang-masuk/terima-barang/{id}/po', [BarangMasukController::class, 'terimaBarang'])->name('barang-masuk.terima-barang.po');

  //------------------------- BarangKeluar -----------------------------------// 
  Route::resource('/barang-keluar', BarangKeluarController::class)->except([
    'store', 'create', 'show', 'update', 'destroy'
  ]);
  Route::get('/barang-keluar/pb/{id}', [BarangKeluarController::class, 'pb'])->name('barang-keluar.pb');
  Route::get('/barang-keluar/pr/{id}', [BarangKeluarController::class, 'pr'])->name('barang-keluar.pr');
  Route::post('/barang-keluar/pilih-data', [BarangKeluarController::class, 'pilihBarangKeluar'])->name('barang-keluar.change-data');
  Route::post('/barang-keluar/{id}', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
  Route::put('/barang-keluar/{id}/serah-terima-pb', [BarangKeluarController::class, 'serahTerimaPB'])->name('barang-keluar.serah-terima-pb');
  Route::put('/barang-keluar/{id}/serah-terima-pr', [BarangKeluarController::class, 'serahTerimaPR'])->name('barang-keluar.serah-terima-pr');

  //------------------------- Laporan -----------------------------------// 
  Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
  Route::post('/laporan/barang-masuk', [LaporanController::class, 'pdfBarangMasuk'])->name('laporan.barang-masuk.pdf');

  Route::get('/laporan/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.barang-keluar');
  Route::post('/laporan/barang-keluar', [LaporanController::class, 'pdfBarangKeluar'])->name('laporan.barang-keluar.pdf');

  Route::get('/laporan/produk', [LaporanController::class, 'produk'])->name('laporan.produk');
  Route::post('/laporan/produk', [LaporanController::class, 'pdfProduk'])->name('laporan.produk.pdf');

  //------------------------- Ubah Profile -----------------------------------// 
  Route::get('/profile-user', [ProfileUserController::class, 'index'])->name('profile-user.index');
  Route::get('/profile-user/edit', [ProfileUserController::class, 'edit'])->name('profile-user.edit');
  Route::post('/profile-user', [ProfileUserController::class, 'update'])->name('profile-user.update');
  Route::get('/profile-user/edit-password', [ProfileUserController::class, 'edit_password'])->name('profile-user.edit_password');
  Route::post('/profile-user/edit-password', [ProfileUserController::class, 'update_password'])->name('profile-user.update_password');

  //------------------------- Setting -----------------------------------// 
  Route::get('/pengaturan', [SettingController::class, 'index'])->name('setting.index');
  Route::post('/pengaturan', [SettingController::class, 'update'])->name('setting.update');

  //------------------------- Actvity Log -----------------------------------// 
  Route::get('/riwayat-aktifitas', [LogActivityController::class, 'index'])->name('activity-log.index');
});

Route::group(['middleware' => ['auth', 'role:user|super-admin|admin|direktur|dept_head|sect_head']], function () {

  //------------------------- dashboard -----------------------------------//
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
  Route::get('/dashboard/date', [DashboardController::class, 'date'])->name('dashboard.date');

  //------------------------- PB -----------------------------------//
  Route::resource('/pb', PBController::class)->except([
    'store', 'edit', 'update'
  ]);
  Route::post('/pb/{id}/download-pdf', [PBController::class, 'downloadPdf'])->name('pb.download-pdf');
  Route::delete('/pb/{id}/delete-item', [PBController::class, 'deleteItem'])->name('pb.delete-item');

  Route::get('/pb-detail/produk/{id}', [PBDetailController::class, 'produk'])->name('pb-detail.produk');
  Route::resource('/pb-detail', PBDetailController::class)->except([
    'index', 'edit'
  ]);

  //------------------------- PR -----------------------------------//
  Route::resource('/pr', PRController::class)->except([
    'store', 'edit', 'update'
  ]);
  Route::post('/pr/{id}/download-pdf', [PRController::class, 'downloadPdf'])->name('pr.download-pdf');
  Route::resource('/pr-detail', PRDetailController::class)->except([
    'index', 'edit', 'store'
  ]);
  Route::post('/pr-detail/produk', [PRDetailController::class, 'produkStore'])->name('pr.produk.store');

  //------------------------- Actvity Log -----------------------------------// 
  Route::get('/riwayat-aktifitas', [LogActivityController::class, 'index'])->name('activity-log.index');
});
