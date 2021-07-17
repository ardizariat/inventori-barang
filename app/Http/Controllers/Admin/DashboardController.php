<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $countProduk = Produk::count();
        $countKategori = Kategori::count();


        $data = DB::table('barang_masuk')
            ->select([
                DB::raw('sum(jumlah) as jumlah'),
                DB::raw('EXTRACT(MONTH from tanggal) as bulan'),
                DB::raw('EXTRACT(YEAR from tanggal) as tahun')
            ])
            ->groupBy(['bulan', 'tahun'])
            ->get();
        foreach ($data as $item) {
            $jumlah = $item->jumlah;
            $bulan = $item->bulan;
        }

        return view('admin.dashboard.index', compact(
            'title',
            'countProduk',
            'countKategori',
            'jumlah',
            'bulan'
        ));
    }
}
