<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use PDF;

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
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = BarangMasuk::whereBetween('tanggal', [$awal, $akhir])->get();
        $pdf = PDF::loadView('admin.laporan.pdf.barang_masuk', [
            'data' => $data,
            'title' => 'Ardi'
        ]);

        $pdf->setOptions([
            'margin-top' => 5,
            'margin-bottom' => 5,
            'page-size' => 'a4',
        ]);
        return $pdf->stream('invoice.pdf');
    }
}
