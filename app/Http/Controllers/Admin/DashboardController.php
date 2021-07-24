<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use Illuminate\Support\Str;
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

        $bulan = [];
        $total = [];
        $datas = DB::table('barang_masuk')
            ->select([
                DB::raw('SUM(jumlah) as total'),
                DB::raw('EXTRACT(MONTH from tanggal) as bulan'),
                DB::raw('EXTRACT(YEAR from tanggal) as tahun')
            ])
            ->groupBy(['bulan', 'tahun'])
            ->get();
        foreach ($datas as $data) {
            $bulan[] = $data->bulan;
            $total[] = $data->total;
        }

        return view('admin.dashboard.index', compact(
            'title',
            'countProduk',
            'countKategori',
            'bulan',
            'total',
        ));
    }
}
