<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Kategori;
use Milon\Barcode\DNS2D;
use \Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use App\DataTables\ProdukDataTable;
use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Barang';
        $daftar_kategori = Kategori::latest()->get();
        $daftar_gudang = Gudang::latest()->get();
        $kategori = $request->kategori;
        if (request()->ajax()) {
            if (!empty($kategori)) {
                $data = Produk::where('kategori_id', '=', $kategori)
                    ->get();
            } else {
                $data = Produk::latest()->get();
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
                        'update' => route('produk.update', $data->id),
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
            'daftar_gudang',
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

        // Input produk
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
        $data->save();

        // Input barang masuk
        $barang_masuk = new BarangMasuk();
        $barang_masuk->produk_id = $data->id;
        $barang_masuk->jumlah = $data->stok;
        $barang_masuk->tanggal = Carbon::parse($data->created_at)->format('Y-m-d');
        $barang_masuk->keterangan = $data->keterangan;
        $barang_masuk->penerima = auth()->user()->name;
        $save = $barang_masuk->save();

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Produk berhasil ditambahkan!'
            ], 201);
        }
    }

    public function edit($id)
    {
        $data = Produk::findOrFail($id);
        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'kategori_id' => 'required',
            'nama_produk' => 'required|unique:produk,nama_produk,' . $id,
            'merek' => 'required',
            'satuan' => 'required',
            'minimal_stok' => 'required|numeric',
            'stok' => 'required|numeric',
        ));
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'text' => $validator->errors(),
            ], 422);
        }

        // Cari id
        $data = Produk::findOrFail($id);

        if ($request->hasFile('gambar')) {

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
            'stok' => $request->stok,
            'keterangan' => $request->keterangan,
        ]);

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
