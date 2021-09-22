<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use Milon\Barcode\DNS2D;
use \Milon\Barcode\DNS1D;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Barang';
        $daftar_kategori = Kategori::latest()->get();
        if (request()->ajax()) {
            $kategori = $request->kategori;
            if (!empty($kategori)) {
                $data = Produk::where('kategori_id', '=', $kategori)
                    ->get();
            } else {
                $data = Produk::where('status', 'aktif')
                    ->latest()
                    ->get();
            }
            return datatables()->of($data)
                ->addColumn('kategori', function ($data) {
                    return $data->category->kategori;
                })
                ->addColumn('stok', function ($data) {
                    return $data->stok . ' ' . $data->satuan;
                })
                ->addColumn('minimal_stok', function ($data) {
                    return $data->minimal_stok . ' ' . $data->satuan;
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.produk._aksi', [
                        'data' => $data,
                        'delete' => route('produk.destroy', $data->id),
                        'edit' => route('produk.edit', $data->id),
                        'show' => route('produk.show', $data->id),
                    ]);
                })
                ->rawColumns(['kategori', 'aksi', 'minimal_stok', 'stok'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.produk.index', compact(
            'title',
            'daftar_kategori',
        ));
    }

    public function create()
    {
        $title = 'Tambah Produk';
        $url = route('produk.index');

        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();

        return view('admin.produk.create', compact(
            'title',
            'daftar_gudang',
            'daftar_kategori',
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
            'harga' => 'required|numeric',
        ]);
        $count = Produk::count();
        $count++;
        $kode = kode($count, 9);

        // Input produk
        $data = new Produk();
        $data->kategori_id = $request->kategori_id;
        $data->gudang_id = $request->gudang_id;
        $data->kode = $kode;
        $data->nama_produk = $request->nama_produk;
        $data->merek = $request->merek;
        $data->satuan = $request->satuan;
        $data->minimal_stok = $request->minimal_stok;
        $data->harga = $request->harga;
        $data->stok = 1;
        $data->status = 'aktif';
        $data->keterangan = $request->keterangan;
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|max:2048|mimes:png,jpg,jpeg,svg'
            ]);
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->nama_produk . '_' . time() . uniqid() . '.' . $extension;
            $path = $file->storeAs('/barang/', $filename);
            $data->gambar = $filename;
        }
        $data->save();

        activity()->log('menambahkan produk ' . $data->nama_produk);

        return response()->json([
            'data' => $data,
            'text' => 'Produk berhasil ditambahkan!'
        ], 201);
    }

    public function edit($id)
    {
        $title = 'Ubah Produk';
        $url = route('produk.index');
        $data = Produk::findOrFail($id);

        $daftar_gudang = Gudang::latest()->get();
        $daftar_kategori = Kategori::latest()->get();

        return view('admin.produk.edit', compact(
            'url',
            'title',
            'daftar_gudang',
            'daftar_kategori',
            'data'
        ));
    }

    public function update(Request $request, $id)
    {
        // Cari id
        $data = Produk::findOrFail($id);
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|unique:produk,nama_produk,' . $id,
            'merek' => 'required',
            'satuan' => 'required',
            'minimal_stok' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|max:2048|mimes:png,jpg,jpeg,svg'
            ]);
            // Gambar lama dihapus
            $oldFile = $data->gambar;
            if (!empty($oldFile)) {
                $deleteOldFile = Storage::delete('/barang/' . $oldFile);
            }
            // Upload gambar baru
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->nama_produk . '_' . time() . uniqid() . '.' . $extension;
            $path = $file->storeAs('/barang/', $filename);
            $data->update(['gambar' => $filename]);
        }

        $update = $data->update([
            'kategori_id' => $request->kategori_id,
            'gudang_id' => $request->gudang_id,
            'nama_produk' => $request->nama_produk,
            'merek' => $request->merek,
            'satuan' => $request->satuan,
            'minimal_stok' => $request->minimal_stok,
            'keterangan' => $request->keterangan,
        ]);

        activity()->log('mengubah produk ' . $data->nama_produk);

        if ($update) {
            return response()->json([
                'text' => 'Produk berhasil diubah!',
                'data' => $data,
            ], 200);
        }
    }

    public function show($id)
    {
        $data = Produk::findOrFail($id);
        $title = 'Detail Produk';
        $url = route('produk.index');

        $barang_masuk = BarangMasuk::where('produk_id', '=', $id)->latest()->get();
        $barang_keluar = BarangKeluar::where('produk_id', '=', $id)->latest()->get();

        $d = new DNS1D();
        $d->setStorPath(__DIR__ . '/cache/');
        $barcode = $d->getBarcodeHTML($data->kode, 'EAN13');

        $qr = new DNS2D();
        $qr->setStorPath(__DIR__ . '/cache/');
        $qrcode = $qr->getBarcodeHTML($data->kode, 'QRCODE');

        return view('admin.produk.show', compact(
            'data',
            'title',
            'url',
            'barcode',
            'qrcode',
            'barang_masuk',
            'barang_keluar',
        ));
    }
    public function destroy($id)

    {
        $produk = Produk::findOrFail($id);
        activity()->log('menghapus produk ' . $produk->nama_produk);
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

    public function barangMasuk($id)
    {
        if (request()->ajax()) {
            $data = BarangMasuk::with('product', 'po', 'penerimaBarang')
                ->where('produk_id', '=', $id)
                ->latest()
                ->get();
            return datatables()->of($data)
                ->addColumn('penerima', function ($data) {
                    return $data->penerimaBarang->name;
                })
                ->addColumn('supplier', function ($data) {
                    return $data->po->supplier->nama ?? '';
                })
                ->addColumn('tanggal', function ($data) {
                    return $data->created_at->format('d-m-Y');
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->rawColumns(['penerima', 'qty', 'tanggal', 'supplier'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function barangKeluar($id)
    {
        if (request()->ajax()) {
            $data = BarangKeluar::with('product', 'penerimaBarang')
                ->where('produk_id', '=', $id)
                ->latest()
                ->get();
            return datatables()->of($data)
                ->addColumn('penerima', function ($data) {
                    return $data->penerimaBarang->name;
                })
                ->addColumn('tanggal', function ($data) {
                    return $data->created_at->format('d-m-Y');
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->rawColumns(['penerima', 'qty', 'tanggal'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}