<?php

namespace App\Http\Controllers\Admin;

use App\Models\PB;
use App\Models\Produk;
use App\Models\PBDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PBDetailController extends Controller
{
    public function create()
    {
        $pb_id = session('pb_id');
        $title = 'Buat Permintaan Barang PB';
        $url = route('pb.index');
        $produk = Produk::where([
            ['status', '=', 'aktif'],
            ['stok', '>=', 5]
        ])
            ->get();
        if (!$pb_id) {
            return abort(404);
        }
        $pb = PB::findOrFail($pb_id);
        $pb_detail = PBDetail::where('pb_id', '=', $pb->id)->get();

        return view('admin.pb.create.create', compact(
            'produk',
            'title',
            'url',
            'pb',
            'pb_detail'
        ));
    }

    public function store(Request $request)
    {
        $produk_id = $request->produk_id;
        $produk = Produk::findOrFail($request->produk_id);
        $harga = $produk->harga;
        $pb_id = $request->pb_id;

        $pb_detail = new PBDetail();
        $pb_detail->pb_id = $pb_id;
        $pb_detail->produk_id = $produk_id;
        $pb_detail->qty = 1;
        $pb_detail->harga = $harga;
        $pb_detail->subtotal = $harga;
        $pb_detail->save();

        activity()->log('Menambahkan item produk permintaan barang PB');

        return response()->json([
            'text' => 'Data berhasil ditambahkan'
        ]);
    }


    public function show($id)
    {
        if (request()->ajax()) {
            $data = PBDetail::with('product')->where('pb_id', $id)->get();
            $total_item = $data->sum('qty');
            $total_harga = $data->sum('subtotal');
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    return view('admin.pb.create.aksi', [
                        'destroy' => route('pb-detail.destroy', $data->id),
                    ]);
                })
                ->addColumn('qty', function ($data) use ($total_item, $total_harga) {
                    return view('admin.pb.create.qty', [
                        'data' => $data,
                        'total_item' => formatAngka($total_item),
                        'total_harga' => formatAngka($total_harga),
                    ]);
                })
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('harga', function ($data) {
                    return $data->product->harga;
                })
                ->addColumn('satuan', function ($data) {
                    return $data->product->satuan;
                })
                ->addColumn('subtotal', function ($data) {
                    return formatAngka($data->subtotal);
                })
                ->rawColumns(['nama_produk', 'satuan', 'aksi', 'qty', 'subtotal', 'harga'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function update(Request $request, $id)
    {
        $pb_detail = PBDetail::findOrFail($id);
        $pb_detail->qty = $request->qty;
        $pb_detail->subtotal = $pb_detail->harga * $request->qty;
        $pb_detail->update();

        $pb_id = PBDetail::where('pb_id', $pb_detail->pb_id)->get();
        $total_item = $pb_id->sum('qty');
        $total_harga = $pb_id->sum('subtotal');

        $pb = PB::findOrFail($pb_detail->pb_id);
        $pb->total_item = $total_item;
        $pb->total_harga = $total_harga;
        $pb->update();

        activity()->log('Mengubah item produk permintaan barang PB');

        return response()->json([
            'text' => 'Data berhasil diubah'
        ], 200);
    }

    public function destroy($id)
    {
        activity()->log('Menghapus item produk permintaan barang PB');

        $pb_detail = PBDetail::findOrFail($id);
        $pb_id = PB::findOrFail($pb_detail->pb_id);

        $total_item = $pb_id->total_item - $pb_detail->qty;
        $total_harga = $pb_id->total_harga - $pb_detail->subtotal;
        $pb_id->total_item = $total_item;
        $pb_id->total_harga = $total_harga;

        $pb_id->update();
        $pb_detail->delete();

        return response()->json([
            'text' => 'Data berhasil dihapus!'
        ], 200);
    }

    public function produk($id)
    {
        if (request()->ajax()) {
            $pb = $id;
            $data = Produk::where([
                ['status', '=', 'aktif'],
                ['stok', '>=', 5]
            ])
                ->get();
            return datatables()->of($data)
                ->addColumn('stok', function ($data) {
                    return $data->stok . ' ' . $data->satuan;
                })
                ->addColumn('aksi', function ($data) use ($pb) {
                    $pb_detail = PBDetail::where([
                        ['pb_id', '=', $pb],
                        ['produk_id', '=', $data->id],
                    ])
                        ->get();
                    return view('admin.pb.create.produk_aksi', [
                        'pb_detail' => $pb_detail,
                        'data' => $data,
                    ]);
                })
                ->rawColumns(['aksi', 'stok'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
