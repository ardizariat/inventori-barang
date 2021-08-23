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
        $tgl_awal = tanggal($request->awal);
        $tgl_akhir = tanggal($request->akhir);
        $title = 'Laporan barang masuk';
        $awal = Carbon::parse($request->awal)->format('Y-m-d H:i:s');
        $akhir = Carbon::parse($request->akhir)->format('Y-m-d H:i:s');

        $data = BarangMasuk::with('po')
            ->whereBetween('created_at', [$awal, $akhir])
            ->get();

        $pdf = PDF::loadView('admin.laporan.pdf.barang_masuk', compact(
            'tgl_awal',
            'tgl_akhir',
            'data',
            'title'
        ));
        activity()->log('Download file pdf data barang masuk');

        $pdf->setOptions([
            'page-size' => 'a4',
            "footer-right" => "[page]",
            'margin-top' => 8,
        ]);
        return $pdf->stream('barang-keluar.pdf');
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
        $tanggal_awal = Carbon::parse($request->awal)->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($request->akhir)->format('Y-m-d');

        $awal = Carbon::parse($request->awal)->format('Y-m-d H:i:s');
        $akhir = Carbon::parse($request->akhir)->format('Y-m-d H:i:s');
        $data = BarangKeluar::whereBetween('created_at', [$awal, $akhir])
            ->get();
        $title = 'Laporan barang keluar';
        $periode = tanggal($tanggal_awal) . ' ' . tanggal($tanggal_akhir);
        $total_item = $data->sum('qty');
        $total_harga = $data->sum('subtotal');

        $pdf = PDF::loadView('admin.laporan.pdf.barang_keluar', compact(
            'data',
            'title',
            'periode',
            'total_item',
            'total_harga',
        ));
        activity()->log('Download file pdf data barang keluar');
        $pdf->setOptions([
            'page-size' => 'a4',
            "footer-right" => "[page]",
            'margin-top' => 8,
        ]);
        return $pdf->stream('barang keluar.pdf');
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
        $title = "Produk";
        $type = $request->type;
        $awal = $request->awal;
        $akhir = $request->akhir;
        $kategori = $request->kategori;

        if ($type == 'all') {
            $typeExport = "Semua Produk";
            $data = Produk::latest()->get();
            $totalItemProduk = $data->count();
        } elseif ($type == 'tanggal') {
            $typeExport = "Berdasarkan Tanggal Pembelian";
            $awal = Carbon::parse($awal)->format('Y-m-d H:i:s');
            $akhir = Carbon::parse($akhir)->format('Y-m-d H:i:s');
            $data = Produk::whereBetween('created_at', [$awal, $akhir])->get();
            $totalItemProduk = $data->count();
        } elseif ($type == 'category') {
            $request->validate([
                'kategori' => 'required'
            ]);
            $data = Produk::where('kategori_id', '=', $kategori)->get();
            $category = Kategori::where('id', '=', $kategori)->pluck('kategori')->first();
            $typeExport = "Berdasarkan Kategori " . $category;
            $totalItemProduk = $data->count();
        }
        $pdf = PDF::loadView('admin.laporan.pdf.produk', compact(
            'data',
            'awal',
            'akhir',
            'typeExport',
            'totalItemProduk',
            'title'
        ));
        $pdf->setOptions([
            'page-size' => 'a4',
            "footer-right" => "[page]",
            'margin-top' => 10,
            'margin-bottom' => 16,
            'footer-line' => true,
        ]);
        activity()->log('Download file pdf data barang produk');
        return $pdf->stream('produk.pdf');
    }
}
