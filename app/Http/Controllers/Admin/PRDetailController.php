<?php

namespace App\Http\Controllers\Admin;

use App\Models\PR;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\PRDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PRDetailController extends Controller
{
    public function create()
    {
        $title = 'Buat Permintaan Pembelian Barang PR';
        $url = route('pr.index');
        $categories = Kategori::all()->pluck('id', 'kategori');
        $pr_id = session('pr_id');
        if (!$pr_id) {
            return abort(404);
        }
        $pr = PR::findOrFail($pr_id);

        return view('admin.pr.create.create', compact(
            'categories',
            'title',
            'url',
            'pr',
            'pr_id',
        ));
    }

    public function produkStore(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|unique:produk,nama_produk',
            'merek' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
        ]);
        $count = Produk::count();
        $count++;
        $kode = kode($count, 9);

        // Input produk
        $produk = new Produk();
        $produk->kategori_id = $request->kategori_id;
        $produk->kode = $kode;
        $produk->nama_produk = $request->nama_produk;
        $produk->merek = $request->merek;
        $produk->satuan = $request->satuan;
        $produk->minimal_stok = 0;
        $produk->harga = $request->harga;
        $produk->stok = 0;
        $produk->keterangan = $request->keterangan;
        $produk->status = 'tidak aktif';
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|max:2048|mimes:png,jpg,jpeg,svg'
            ]);
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->nama_produk . '_' . time() . uniqid() . '.' . $extension;
            $path = $file->storeAs('/barang/', $filename);
            $produk->gambar = $filename;
        }
        $produk->save();

        $pr_detail = new PRDetail();
        $pr_detail->pr_id = $request->pr_id;
        $pr_detail->produk_id = $produk->id;
        $pr_detail->qty = 1;
        $pr_detail->harga = $produk->harga;
        $pr_detail->subtotal = $produk->harga;
        $pr_detail->save();

        $pr = PR::findOrFail($pr_detail->pr_id);
        $pr->total_item = $pr->total_item + $pr_detail->qty;
        $pr->total_harga = $pr->total_harga + $pr_detail->harga;
        $pr->update();

        activity()->log('menambahkan produk ' . $produk->nama_produk);

        return response()->json([
            'text' => 'Produk berhasil ditambahkan!'
        ], 201);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = PRDetail::with('product')->where('pr_id', $id)->get();
            $total_item = $data->sum('qty');
            $total_harga = $data->sum('subtotal');
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    return view('admin.pr.create.aksi', [
                        'delete' => route('pr-detail.destroy', $data->id),
                    ]);
                })
                ->addColumn('qty', function ($data) use ($total_item, $total_harga) {
                    return view('admin.pr.create.qty', [
                        'data' => $data,
                        'total_item' => formatAngka($total_item),
                        'total_harga' => formatAngka($total_harga),
                    ]);
                })
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('satuan', function ($data) {
                    return $data->product->satuan;
                })
                ->addColumn('harga', function ($data) {
                    return formatAngka($data->harga);
                })
                ->addColumn('subtotal', function ($data) {
                    return formatAngka($data->subtotal);
                })
                ->rawColumns(['nama_produk', 'satuan', 'aksi', 'qty', 'harga', 'subtotal'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function update(Request $request, $id)
    {
        $pr_detail = PRDetail::findOrFail($id);
        $pr_detail->qty = $request->qty;
        $pr_detail->subtotal = $pr_detail->harga * $request->qty;
        $pr_detail->update();

        $pr_id = PRDetail::where('pr_id', $pr_detail->pr_id)->get();
        $total_item = $pr_id->sum('qty');
        $total_harga = $pr_id->sum('subtotal');

        $pr = PR::findOrFail($pr_detail->pr_id);
        $pr->total_item = $total_item;
        $pr->total_harga = $total_harga;
        $pr->update();

        activity()->log('Mengubah qty permintaan barang PR');

        return response()->json([
            'text' => 'Data berhasil diubah'
        ], 200);
    }

    public function destroy($id)
    {
        $pr_detail = PRDetail::findOrFail($id);
        $pr_id = PR::findOrFail($pr_detail->pr_id);
        $produk = Produk::findOrFail($pr_detail->produk_id);

        $total_item = $pr_id->total_item - $pr_detail->qty;
        $total_harga = $pr_id->total_harga - $pr_detail->subtotal;
        $pr_id->total_item = $total_item;
        $pr_id->total_harga = $total_harga;
        $pr_id->update();

        $produk->delete();
        $pr_detail->delete();

        return response()->json([
            'text' => 'Data berhasil dihapus'
        ], 204);
    }
}
