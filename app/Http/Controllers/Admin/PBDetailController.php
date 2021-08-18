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
        $title = 'Buat Permintaan Barang PB';
        $url = route('pb.index');
        $produk = Produk::latest()->get();
        $pb_id = session('pb_id');
        if (!$pb_id) {
            return abort(404);
        }
        $pb = PB::findOrFail($pb_id);

        return view('admin.pb.create.create', compact(
            'produk',
            'title',
            'url',
            'pb',
        ));
    }

    public function store(Request $request)
    {
        $produk_id = $request->produk_id;
        $pb_id = $request->pb_id;

        $pb_detail = new PBDetail();
        $pb_detail->pb_id = $pb_id;
        $pb_detail->produk_id = $produk_id;
        $pb_detail->qty = 1;
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
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    return view('admin.pb.create.aksi', [
                        'delete' => route('pb-detail.destroy', $data->id),
                    ]);
                })
                ->addColumn('qty', function ($data) use ($total_item) {
                    return view('admin.pb.create.qty', [
                        'data' => $data,
                        'total_item' => formatAngka($total_item),
                    ]);
                })
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('satuan', function ($data) {
                    return $data->product->satuan;
                })
                ->rawColumns(['nama_produk', 'satuan', 'aksi', 'qty'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function update(Request $request, $id)
    {
        $pb_detail = PBDetail::findOrFail($id);
        $pb_detail->qty = $request->qty;
        $pb_detail->update();

        $pb_id = $pb_detail->pb_id;

        $pb_subtotal = PBDetail::where('pb_id', $pb_id)->get();
        $total_item = $pb_subtotal->sum('qty');

        $pb = PB::findOrFail($pb_id);
        $pb->total_item = $total_item;
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
        $pb_detail->delete();
        return response()->json([
            'text' => 'Data berhasil dihapus!'
        ], 200);
    }
}
