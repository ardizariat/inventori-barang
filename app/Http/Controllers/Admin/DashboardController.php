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

        $tersedia = Produk::whereColumn('stok', '>', 'minimal_stok')->count();
        $hampir_habis = Produk::whereColumn('stok', '<=', 'minimal_stok')->count();

        $countProduk = Produk::count();
        $countKategori = Kategori::count();

        $dt = Carbon::now();
        $jan = $dt->startOfYear();
        $jan = $jan->format('Y-m-d');
        $des = $dt->lastOfYear();
        $des = $des->format('Y-m-d');
        $tahun = date('Y');

        $bulan_barang_masuk = [];
        $barang_masuk = [];
        $data_barang_masuk = DB::table('barang_masuk')
            ->select([
                DB::raw('SUM(jumlah) as total'),
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
            ])

            ->groupBy(['bulan', 'tahun',])
            ->get();
        foreach ($data_barang_masuk as $data) {
            $barang_masuk[] = $data->total;
            $bulan_barang_masuk[] = $data->bulan;
        }
        $rata2_barang_masuk_sebulan = collect($barang_masuk)->avg();

        $bulan_barang_keluar = [];
        $barang_keluar = [];

        $data_barang_keluar = DB::table('barang_keluar')
            ->select([
                DB::raw('SUM(jumlah) as total'),
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
            ])
            ->groupBy(['tahun', 'bulan'])
            ->whereBetween('tanggal', [$jan, $des])
            ->get();

        foreach ($data_barang_keluar as $data) {
            $barang_keluar[] = $data->total;
            $bulan_barang_keluar[] = $data->bulan;
        }
        $rata2_barang_keluar_sebulan = collect($barang_keluar)->avg();

        return view('admin.dashboard.index', compact(
            'title',
            'countProduk',
            'countKategori',
            'bulan_barang_masuk',
            'barang_masuk',
            'barang_keluar',
            'bulan_barang_keluar',
            'tahun',
            'tersedia',
            'hampir_habis',
            'rata2_barang_masuk_sebulan',
            'rata2_barang_keluar_sebulan',
        ));
    }
}
