<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BarangMasukDataTable;
use App\Models\Produk;

class BarangMasukController extends Controller
{
    public function index(BarangMasukDataTable $tableBarangMasuk)
    {
        $title = 'Barang Masuk';
        $products = Produk::latest()->get();
        return $tableBarangMasuk->render('admin.barang_masuk.index', compact(
            'title',
            'products',
        ));
    }
}
