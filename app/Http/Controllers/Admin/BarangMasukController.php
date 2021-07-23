<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Masuk';
        $products = Produk::latest()->get();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangMasuk::whereBetween('tanggal', [$from_date, $to_date])->get();
            } else {
                $data = BarangMasuk::query();
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
                    return view('admin.barang_masuk._aksi', [
                        'delete' => route('barang-masuk.destroy', $data->id),
                        'show' => route('barang-masuk.show', $data->id),
                    ]);
                })
                ->rawColumns(['produk', 'kategori', 'tanggal', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_masuk.index', compact(
            'title',
            'products',
        ));
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = BarangMasuk::findOrFail($id);
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
            'pemberi' => 'required',
        ]);

        $data = new BarangMasuk();
        $data->produk_id = $request->produk_id;
        $data->jumlah = $request->jumlah;
        $data->keterangan = $request->keterangan;
        $data->tanggal = $request->tanggal;
        $data->penerima = auth()->user()->name;
        $data->pemberi = $request->pemberi;
        $data->save();

        $produk = Produk::findOrFail($request->produk_id);
        $produk->stok = $produk->stok + $request->jumlah;
        $save = $produk->update();

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Barang masuk berhasil ditambahkan!'
            ], 201);
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
