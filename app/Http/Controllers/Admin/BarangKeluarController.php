<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BarangKeluarDataTable;
use App\Models\BarangKeluar;

class BarangKeluarController extends Controller
{
    public function index(BarangKeluarDataTable $tableBarangKeluar, Request $request)
    {
        $title = 'Barang Keluar';
        $products = Produk::latest()->get();
        return $tableBarangKeluar->render('admin.barang_keluar.index', compact(
            'title',
            'products',
        ));
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = BarangKeluar::findOrFail($id);
            $nama_produk = $data->product->nama_produk;
            return response()->json([
                'data' => $data,
                'nama_produk' => $nama_produk,
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

        $produk = Produk::findOrFail($request->produk_id);
        $stok = $produk->stok;
        $nama_barang = $produk->nama_barang;

        if ($stok == 0) {
            $text = 'Stok barang ' . $nama_barang . ' kosong!';
            return response()->json([
                'text' => $text
            ], 200);
        }

        $data = new BarangKeluar();
        $data->produk_id = $request->produk_id;
        $data->jumlah = $request->jumlah;
        $data->tanggal = $request->tanggal;
        $data->keterangan = $request->keterangan;
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
    public function update(Request $request, $id)
    {

        $request->validate([
            'produk_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $data = BarangKeluar::findOrFail($id);
        $produk = Produk::findOrFail($data->produk_id);

        $stok = $produk->stok;
        $nama_barang = $produk->nama_barang;

        if ($stok == 0) {
            $text = 'Stok barang ' . $nama_barang . ' kosong!';
            return response()->json([
                'text' => $text
            ], 200);
        }

        // Produk
        $stokLama = $produk->stok - $data->jumlah;
        $produk->stok = $stokLama - $request->jumlah;
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
}
