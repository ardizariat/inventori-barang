<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produk;
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
        // dd($request->all());
        $now = Carbon::now()->format('d F Y, H:i A');
        $byDate = $request->byDate;
        $awal = $request->awal;
        $akhir = $request->akhir;
        $opsi = $request->opsi;
        $kategori = $request->kategori;
        if ($opsi == 'all') {
            $data = Produk::latest()->get();
            $totalProdukMasuk = $data->sum('jumlah');
            $totalItemProduk = $data->count();
        } elseif ($opsi == 'byDate') {
            $data = Produk::whereBetween('created_at', [$awal, $akhir])->get();
            $totalProdukMasuk = $data->sum('jumlah');
            $totalItemProduk = $data->count();
        } elseif ($opsi == null && $kategori) {
            $data = Produk::where('kategori_id', '=', $kategori)->get();
            $totalProdukMasuk = $data->sum('jumlah');
            $totalItemProduk = $data->count();
        }
        $pdf = PDF::loadView('admin.laporan.pdf.produk', [
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
        return $pdf->stream('produk.pdf');
    }
}
