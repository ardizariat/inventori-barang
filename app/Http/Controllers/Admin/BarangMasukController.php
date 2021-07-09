<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BarangMasukDataTable;
use App\Models\BarangMasuk;
use App\Models\Produk;

class BarangMasukController extends Controller
{
    public function index(BarangMasukDataTable $tableBarangMasuk, Request $request)
    {
        $title = 'Barang Masuk';
        $products = Produk::latest()->get();
        return $tableBarangMasuk->render('admin.barang_masuk.index', compact(
            'title',
            'products',
        ));
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = BarangMasuk::findOrFail($id);
            return response()->json([
                'data' => $data
            ], 200);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'produk_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $data = new BarangMasuk();
        $data->produk_id = $request->produk_id;
        $data->jumlah = $request->jumlah;
        $data->keterangan = $request->keterangan;
        $data->tanggal = $request->tanggal;
        $data->save();

        $produk = Produk::findOrFail($request->produk_id);
        $produk->stok = $produk->stok + $request->jumlah;
        $save = $produk->update();

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Barang masuk berhasil ditambahkan!'
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'produk_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $data = BarangMasuk::findOrFail($id);
        $produk = Produk::findOrFail($data->produk_id);

        // Produk
        $stokLama = $produk->stok - $data->jumlah;
        $produk->stok = $stokLama + $request->jumlah;
        $save = $produk->update();

        // Barang Masuk
        $data->produk_id = $request->produk_id;
        $data->jumlah = $request->jumlah;
        $data->keterangan = $request->keterangan;
        $data->tanggal = $request->tanggal;
        $data->update();


        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Barang masuk berhasil ditambahkan!'
            ], 200);
        }
    }

    public function changeData(Request $request)
    {
        if (request()->ajax()) {
            $id = $request->id;
            $data = Produk::where('id', '=', $id)->first();
            $stok = $data->stok;
            return response()->json([
                'data' => $data,
                'stok' => $stok,
            ], 200);
        }
    }

    public function destroy($id)

    {
        $stockIn = BarangMasuk::findOrFail($id);
        $jumlah = $stockIn->jumlah;
        $produk_id = $stockIn->produk_id;
        $produk = Produk::findOrFail($produk_id);
        $produk->stok = $produk->stok - $jumlah;
        $produk->update();
        $delete = $stockIn->delete();

        return response()->json([
            'text' => 'Data berhasil dihapus'
        ], 200);
    }
}
