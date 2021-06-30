<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\DataTables\ProdukDataTable;
use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\Kategori;

class ProdukController extends Controller
{
    public function index(ProdukDataTable $tableProduk)
    {
        $title = 'Produk';
        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();
        return $tableProduk->render('admin.produk.index', compact(
            'title',
            'daftar_gudang',
            'daftar_kategori',
        ));
    }

    public function create()
    {
        $title = 'Tambah Produk';
        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();
        return view('admin.produk.create', compact(
            'title',
            'daftar_gudang',
            'daftar_kategori',
        ));
    }
}
