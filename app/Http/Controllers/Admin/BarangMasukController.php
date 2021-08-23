<?php

namespace App\Http\Controllers\Admin;

use App\Models\PO;
use Carbon\Carbon;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Masuk';
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');
        $po = PO::pluck('no_dokumen', 'id');

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangMasuk::with(['po'])
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();
            } else {
                $data = BarangMasuk::with(['po'])
                    ->where('status', '=', 'sudah diterima')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->product->category->kategori;
                })
                ->addColumn('supplier', function ($data) {
                    return $data->po->supplier->nama;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = Carbon::parse($data->created_at)->format('d-m-Y');
                    return $tanggal;
                })
                ->addColumn('qty', function ($data) {
                    $qty = formatAngka($data->qty) . ' ' . $data->product->satuan;
                    return $qty;
                })
                ->rawColumns(['nama_produk', 'supplier', 'kategori', 'qty', 'tanggal'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_masuk.index.index', compact(
            'title',
            'po',
        ));
    }

    public function pilihBarangMasuk(Request $request)
    {
        if (request()->json()) {
            $id = $request->id;
            $po = PO::find($id);
            $pemohon = $po->pr->user->name;
            $supplier = $po->supplier->nama;
            $tanggal = $po->created_at->format('d-m-Y');
            $url = route('barang-masuk.po', $po->id);
            return response()->json([
                'data' => $po,
                'url' => $url,
                'supplier' => $supplier,
                'pemohon' => $pemohon,
                'tanggal' => $tanggal,
            ], 200);
        }
    }
}
