<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Kategori;
use Milon\Barcode\DNS2D;
use \Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use App\DataTables\ProdukDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(ProdukDataTable $tableProduk)
    {
        $title = 'Produk';
        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();

        return $tableProduk->render('admin.produk.index', compact(
            'title',
            'daftar_gudang',
            'daftar_kategori',
        ));
    }

    public function create()
    {
        $title = 'Tambah Produk';
        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();
        $url = route('produk.index');

        $count = Produk::count();
        $count++;
        $kode = kode($count, 9);

        return view('admin.produk.create', compact(
            'title',
            'daftar_gudang',
            'daftar_kategori',
            'kode',
            'url'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|unique:produk,nama_produk',
            'merek' => 'required',
            'satuan' => 'required',
            'minimal_stok' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        $count = Produk::count();
        $count++;
        $kode = kode($count, 9);

        $data = new Produk();
        $data->kategori_id = $request->kategori_id;
        $data->gudang_id = $request->gudang_id;
        $data->kode = $kode;
        $data->nama_produk = $request->nama_produk;
        $data->merek = $request->merek;
        $data->satuan = $request->satuan;
        $data->minimal_stok = $request->minimal_stok;
        $data->stok = $request->stok;
        $data->keterangan = $request->keterangan;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->nama_produk . '_' . time() . uniqid() . '.' . $extension;
            $path = $file->storeAs('/barang/', $filename);
            $data->gambar = $filename;
        }
        $save = $data->save();
        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Produk berhasil ditambahkan!'
            ], 200);
        }
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $title = 'Ubah Produk';
        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();
        $url = route('produk.index');
        return view('admin.produk.edit', compact(
            'produk',
            'daftar_gudang',
            'daftar_kategori',
            'url',
            'title'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|unique:produk,nama_produk,' . $id,
            'merek' => 'required',
            'satuan' => 'required',
            'minimal_stok' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $data = Produk::findOrFail($id);
        $data->kategori_id = $request->kategori_id;
        $data->gudang_id = $request->gudang_id;
        $data->kode = $data->kode;
        $data->nama_produk = $request->nama_produk;
        $data->merek = $request->merek;
        $data->satuan = $request->satuan;
        $data->minimal_stok = $request->minimal_stok;
        $data->stok = $request->stok;
        $data->keterangan = $request->keterangan;
        if ($request->hasFile('gambar')) {
            $files = $request->file('gambar');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $request->nama_produk . '_' . time() . uniqid() . '.' . $extension;
                if (count($files) == 1) {
                    $path = $file->storeAs('/barang/', $filename);
                    $data->gambar1 = $filename;
                } elseif (count($files) == 2) {
                    $path = $file->storeAs('/barang/', $filename);
                    $data->gambar1 = $filename;
                    $data->gambar2 = $filename;
                } else {
                    $path = $file->storeAs('/barang/', $filename);
                    $data->gambar1 = $filename;
                    $data->gambar2 = $filename;
                    $data->gambar3 = $filename;
                }
            }
        }
        $update = $data->update();
        if ($update) {
            return response()->json([
                'data' => $data,
                'text' => 'Produk berhasil diubah!'
            ], 200);
        }
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        $title = 'Detail Produk';
        $url = route('produk.index');
        $d = new DNS1D();
        $d->setStorPath(__DIR__ . '/cache/');
        $barcode = $d->getBarcodeHTML($produk->kode, 'EAN13');

        $qr = new DNS2D();
        $qr->setStorPath(__DIR__ . '/cache/');
        $qrcode = $qr->getBarcodeHTML($produk->kode, 'QRCODE');

        return view('admin.produk.show', compact(
            'produk',
            'title',
            'url',
            'barcode',
            'qrcode'
        ));
    }
    public function destroy($id)

    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar == null) {
            $delete = $produk->delete();
        } else {
            Storage::delete('/barang/' . $produk->gambar);
            $delete = $produk->delete();
        }

        return response()->json([
            'text' => 'Data berhasil dihapus'
        ], 200);
    }
}
