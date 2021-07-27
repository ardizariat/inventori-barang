<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BarangKeluarDataTable;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Keluar';
        $products = Produk::latest()->get();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangKeluar::whereBetween('tanggal', [$from_date, $to_date])->get();
            } else {
                $data = BarangKeluar::query()->orderBy('created_at', 'desc');
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
                ->addColumn('aksi', function ($data) {
                    return view('admin.barang_keluar._aksi', [
                        'delete' => route('barang-keluar.destroy', $data->id),
                        'show' => route('barang-keluar.destroy', $data->id),
                    ]);
                })
                ->rawColumns(['produk', 'kategori', 'tanggal', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_keluar.index', compact(
            'title',
            'products',
        ));
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

    public function store(Request $request)
    {

        $request->validate([
            'produk_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
            'penerima' => 'required',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $stok = $produk->stok;
        $nama_barang = $produk->nama_barang;

        if ($stok == 0) {
            $text = 'Stok barang ' . $nama_barang . ' kosong!';
            return response()->json([
                'text' => $text,
                'status' => 500
            ], 500);
        }

        if ($stok - $request->jumlah < 0) {
            $text = 'Barang yang dikeluarkan lebih besar dari stok yang tersedia !';
            return response()->json([
                'text' => $text,
                'status' => 500
            ], 500);
        }

        $data = new BarangKeluar();
        $data->produk_id = $request->produk_id;
        $data->jumlah = $request->jumlah;
        $data->tanggal = $request->tanggal;
        $data->keterangan = $request->keterangan;
        $data->penerima = $request->penerima;
        $data->pemberi = auth()->user()->name;
        $data->save();

        $save = $produk->update([
            'stok' => $stok - $request->jumlah
        ]);

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Barang keluar berhasil ditambahkan!'
            ], 201);
        }
    }

    public function destroy($id)

    {
        $stockIn = BarangKeluar::findOrFail($id);
        $jumlah = $stockIn->jumlah;
        $produk_id = $stockIn->produk_id;
        $produk = Produk::findOrFail($produk_id);
        $produk->stok = $produk->stok + $jumlah;
        $produk->update();
        $delete = $stockIn->delete();

        return response()->json([
            'text' => 'Data berhasil dihapus'
        ], 200);
    }
}
