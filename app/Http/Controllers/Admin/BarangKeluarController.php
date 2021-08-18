<?php

namespace App\Http\Controllers\Admin;

use App\Models\PB;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\PBDetail;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BarangKeluarDataTable;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Keluar';
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');
        $pb = PB::with('user')
            ->where('status_confirm_barang_keluar', '=', 'belum')
            ->get();
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangKeluar::whereBetween('created_at', [$from_date, $to_date])->get();
            } else {
                $data = BarangKeluar::where('status_barang', '=', 'dikeluarkan')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return datatables()->of($data)
                ->addColumn('produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->product->category->kategori;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = Carbon::parse($data->tanggal)->format('d F Y');
                    return $tanggal;
                })
                ->addColumn('qty', function ($data) {
                    $qty = formatAngka($data->qty) . ' ' . $data->product->satuan;
                    return $qty;
                })
                ->rawColumns(['produk', 'kategori', 'qty', 'tanggal'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_keluar.index', compact(
            'title',
            'pb',
        ));
    }

    public function store(Request $request, $id)
    {
        $pb_id = PB::findOrFail($id);
        $pb_id->status_confirm_barang_keluar = 'sudah';
        $pb_id->update();

        $pb_detail = PBDetail::where('pb_id', '=', $id)->get();
        $pemberi = auth()->user()->id;
        $penerima = $pb_id->pemohon;

        $data = $pb_detail;
        foreach ($data as $row) {
            $barang_keluar = new BarangKeluar();
            $barang_keluar->produk_id = $row->produk_id;
            $barang_keluar->qty = $row->qty;
            $barang_keluar->pb_id = $id;
            $barang_keluar->pemberi = $pemberi;
            $barang_keluar->penerima = $penerima;
            $barang_keluar->status_barang = 'dikeluarkan';
            $barang_keluar->save();

            $produk = Produk::findOrFail($row->produk_id);
            $produk->stok = $produk->stok - $row->qty;
            $produk->update();
        }

        return response()->json([
            'text' => "Sukses!"
        ], 201);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = BarangKeluar::findOrFail($id);
            $tanggal = tanggal($data->tanggal);
            $foto = $data->product->getGambar();
            return response()->json([
                'data' => $data,
                'tanggal' => $tanggal,
                'foto' => $foto,
            ], 200);
        }
    }
}
