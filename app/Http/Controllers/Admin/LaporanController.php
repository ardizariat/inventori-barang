<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function barangMasuk()
    {
        $title = "Laporan data barang masuk";
        return view('admin.laporan.barang_masuk', compact(
            'title'
        ));
    }

    public function pdfBarangMasuk(Request $request)
    {
        $request->validate([
            'awal' => 'required',
            'akhir' => 'required',
        ]);
        $now = Carbon::now()->format('d F Y, H:i A');
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = BarangMasuk::whereBetween('tanggal', [$awal, $akhir])->get();
        $totalProdukMasuk = $data->sum('jumlah');
        $totalProdukMasuk = number_format($totalProdukMasuk, 0, ',', '.');
        $totalItemProduk = $data->count();
        $totalItemProduk = number_format($totalItemProduk, 0, ',', '.');
        $pdf = PDF::loadView('admin.laporan.pdf.barang_masuk', [
            'data' => $data,
            'awal' => $awal,
            'akhir' => $akhir,
            'totalItemProduk' => $totalItemProduk,
            'totalProdukMasuk' => $totalProdukMasuk,
            'now' => $now,
            'title' => 'Ardi'
        ]);

        $pdf->setOptions([
            'page-size' => 'a4',
            "footer-center" => "[page]",
            'margin-top' => 8,
            // 'header-line' => true,
            'footer-line' => true,
        ]);
        return $pdf->stream('barang-masuk.pdf');
    }

    public function barangKeluar()
    {
        $title = "Laporan data barang keluar";
        return view('admin.laporan.barang_keluar', compact(
            'title'
        ));
    }

    public function pdfBarangKeluar(Request $request)
    {
        $request->validate([
            'awal' => 'required',
            'akhir' => 'required',
        ]);
        $now = Carbon::now()->format('d F Y, H:i A');
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = BarangKeluar::whereBetween('tanggal', [$awal, $akhir])->get();
        $totalProdukKeluar = $data->sum('jumlah');
        $totalProdukKeluar = number_format($totalProdukKeluar, 0, ',', '.');
        $totalItemProduk = $data->count();
        $totalItemProduk = number_format($totalItemProduk, 0, ',', '.');
        $pdf = PDF::loadView('admin.laporan.pdf.barang_keluar', [
            'data' => $data,
            'awal' => $awal,
            'akhir' => $akhir,
            'totalItemProduk' => $totalItemProduk,
            'totalProdukKeluar' => $totalProdukKeluar,
            'now' => $now,
            'title' => 'Ardi'
        ]);

        $pdf->setOptions([
            'page-size' => 'a4',
            "footer-center" => "[page]",
            'margin-top' => 8,
            // 'header-line' => true,
            'footer-line' => true,
        ]);
        return $pdf->stream('barang-keluar.pdf');
    }

    public function produk()
    {
        $title = "Laporan data produk";
        $daftar_kategori = Kategori::latest()->get();
        return view('admin.laporan.produk', compact(
            'title',
            'daftar_kategori'
        ));
    }

    public function pdfProduk(Request $request)
    {
        $now = Carbon::now()->format('d F Y, H:i A');
        $type = $request->type;
        $awal = $request->awal;
        $akhir = $request->akhir;
        $kategori = $request->kategori;

        if ($type == 'all') {
            $typeExport = "Semua Produk";
            $data = Produk::latest()->get();
            $totalProdukMasuk = $data->sum('jumlah');
            $totalItemProduk = $data->count();
        } elseif ($type == 'tanggal') {
            $typeExport = "Berdasarkan Tanggal";
            $data = Produk::whereBetween('created_at', [$awal, $akhir])->get();
            $totalProdukMasuk = $data->sum('jumlah');
            $totalItemProduk = $data->count();
        } elseif ($type == 'kategori') {
            $typeExport = "Berdasarkan Kategori";
            $data = Produk::where('kategori_id', '=', $kategori)->get();
            $totalProdukMasuk = $data->sum('jumlah');
            $totalItemProduk = $data->count();
        }
        $pdf = PDF::loadView('admin.laporan.pdf.produk', [
            'data' => $data,
            'awal' => $awal,
            'akhir' => $akhir,
            'typeExport' => $typeExport,
            'totalItemProduk' => $totalItemProduk,
            'totalProdukMasuk' => $totalProdukMasuk,
            'now' => $now,
            'title' => 'Ardi'
        ]);
        $pdf->setOptions([
            'page-size' => 'a4',
            "footer-center" => "[page]",
            'margin-top' => 8,
            // 'header-line' => true,
            'footer-line' => true,
        ]);
        return $pdf->stream('produk.pdf');
    }
}
