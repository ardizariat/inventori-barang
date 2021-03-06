<?php

namespace App\Http\Controllers\Admin;

use App\Models\PB;
use App\Models\PR;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\BarangKeluarSeeder;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $tersedia = Produk::whereColumn('stok', '>', 'minimal_stok')->count();
        $hampir_habis = Produk::whereColumn('stok', '<=', 'minimal_stok')->count();

        $countProduk = Produk::count();
        $countKategori = Kategori::count();
        $countSupplier = Supplier::count();
        $countUser = User::count();

        $dt = Carbon::now();
        $jan = $dt->startOfYear();
        $jan = $jan->format('Y-m-d');
        $des = $dt->lastOfYear();
        $des = $des->format('Y-m-d');
        $tahun = date('Y');

        // $bulan_barang_masuk = [];
        // $barang_masuk = [];
        // $data_barang_masuk = DB::table('barang_masuk')
        //     ->select([
        //         DB::raw('SUM(subtotal) as total'),
        //         DB::raw('MONTH(created_at) as bulan'),
        //         DB::raw('YEAR(created_at) as tahun'),
        //     ])

        //     ->groupBy(['bulan', 'tahun',])
        //     ->orderBy('created_at', 'asc')
        //     ->whereYear('created_at', $tahun)
        //     ->get();
        // foreach ($data_barang_masuk as $data) {
        //     $barang_masuk[] = $data->total;
        //     $bulan_barang_masuk[] = $data->bulan;
        // }
        // $rata2_barang_masuk_sebulan = collect($barang_masuk)->avg();


        // $bulan_barang_keluar = [];
        // $barang_keluar = [];
        // $data_barang_keluar = DB::table('barang_keluar')
        //     ->select([
        //         DB::raw('SUM(subtotal) as total'),
        //         DB::raw('MONTH(created_at) as bulan'),
        //         DB::raw('YEAR(created_at) as tahun'),
        //     ])

        //     ->groupBy(['bulan', 'tahun',])
        //     ->orderBy('created_at', 'asc')
        //     ->whereYear('created_at', $tahun)
        //     ->get();
        // foreach ($data_barang_keluar as $data) {
        //     $barang_keluar[] = $data->total;
        //     $bulan_barang_keluar[] = $data->bulan;
        // }
        // $rata2_barang_keluar_sebulan = collect($barang_keluar)->avg();

        $user = Auth::user();
        if ($user->hasRole('user')) {
            $pb = PB::where('pemohon', '=', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            $pr = PR::where('pemohon', '=', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $pb_approve = PB::where([
                ['pemohon', '=', $user->id],
                ['status', '=', 'sudah diterima']
            ])
                ->count();
            $pr_approve = PR::where([
                ['pemohon', '=', $user->id],
                ['status', '=', 'sudah diterima']
            ])
                ->count();

            $total_approve = $pr_approve + $pb_approve;


            return view('admin.dashboard.index', compact(
                'pb',
                'pr',
                'total_approve',
                'title',
                'tahun',
            ));
        }

        return view('admin.dashboard.index', compact(
            'title',
            'countProduk',
            'countKategori',
            'countUser',
            'countSupplier',
            'tahun',
            // 'tersedia',
            // 'hampir_habis',
            // 'bulan_barang_masuk',
            // 'barang_masuk',
            // 'rata2_barang_masuk_sebulan',
            // 'bulan_barang_keluar',
            // 'barang_keluar',
            // 'rata2_barang_keluar_sebulan',
        ));
    }

    public function date()
    {
        date_default_timezone_set('Asia/Jakarta');
        if (request()->json()) {
            $timestamp = date('H:i:s');
            return response()->json([
                'timestamp' => $timestamp
            ]);
        }
    }
}