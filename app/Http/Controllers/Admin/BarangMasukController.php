<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BarangMasukDataTable;
use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index(BarangMasukDataTable $tableBarangMasuk)
    {
        $title = 'Barang Masuk';
        return $tableBarangMasuk->render('admin.barang_masuk.index', compact(
            'title',
        ));
    }
}
