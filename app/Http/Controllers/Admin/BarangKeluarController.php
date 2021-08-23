<?php

namespace App\Http\Controllers\Admin;

use App\Models\PB;
use App\Models\PR;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\PBDetail;
use App\Models\PRDetail;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BarangKeluarDataTable;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Keluar';
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');
        $pb = PB::pluck('no_dokumen', 'id');
        $pr = PR::pluck('no_dokumen', 'id');
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangKeluar::with(['pb', 'pr'])
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();
            } else {
                $data = BarangKeluar::with(['pb', 'pr', 'penerimaBarang'])
                    ->where('status', '=', 'sudah dikeluarkan')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->product->category->kategori;
                })
                ->addColumn('pemohon', function ($data) {
                    return $data->penerimaBarang->name;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = Carbon::parse($data->created_at)->format('d-m-Y');
                    return $tanggal;
                })
                ->addColumn('qty', function ($data) {
                    $qty = formatAngka($data->qty) . ' ' . $data->product->satuan;
                    return $qty;
                })
                ->rawColumns(['nama_produk', 'pemohon', 'kategori', 'qty', 'tanggal'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_keluar.index.index', compact(
            'title',
            'pb',
            'pr',
        ));
    }

    public function pilihBarangKeluar(Request $request)
    {
        $id = $request->id;

        $pb = PB::find($id);
        $pr = PR::find($id);

        if (isset($pb)) {
            $pemohon = $pb->user->name;
            $tanggal = Carbon::parse($pb->created_at)->format('d-m-Y');
            $url = route('barang-keluar.pb', $pb->id);
            return response()->json([
                'data' => $pb,
                'jenis_permintaan' => 'pb',
                'pemohon' => $pemohon,
                'tanggal' => $tanggal,
                'url' => $url,
            ], 200);
        }
        if (isset($pr)) {
            $pemohon = $pr->user->name;
            $tanggal = Carbon::parse($pr->created_at)->format('d-m-Y');
            $url = route('barang-keluar.pr', $pr->id);
            return response()->json([
                'data' => $pr,
                'jenis_permintaan' => 'pr',
                'pemohon' => $pemohon,
                'tanggal' => $tanggal,
                'url' => $url,
            ], 200);
        }
    }

    public function pb($id)
    {
        $title = 'Barang Keluar PB';
        $pb = PB::findOrFail($id);
        $data = PBDetail::with('product')->where('pb_id', '=', $id)->get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->product->category->kategori;
                })->addColumn('qty', function ($data) {
                    $qty = formatAngka($data->qty) . ' ' . $data->product->satuan;
                    return $qty;
                })
                ->rawColumns(['nama_produk', 'kategori', 'qty'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.barang_keluar.show.pb', compact(
            'title',
            'pb',
            'id',
        ));
    }

    public function serahTerimaPB($id)
    {
        $pb_id = PB::find($id);

        $pb_details = PBDetail::where('pb_id', '=', $id)->get();
        foreach ($pb_details as $pb) {
            $barang_keluar = new BarangKeluar();
            $barang_keluar->produk_id = $pb->produk_id;
            $barang_keluar->pb_id = $id;
            $barang_keluar->penerima = $pb_id->pemohon;
            $barang_keluar->qty = $pb->qty;
            $barang_keluar->subtotal = $pb->qty * $pb->harga;
            $barang_keluar->jenis_permintaan = 'pb';
            $barang_keluar->status = 'sudah dikeluarkan';
            $barang_keluar->save();

            $produk = Produk::find($barang_keluar->produk_id);
            $produk->stok = $produk->stok - $barang_keluar->qty;
            $produk->update();
        }

        $pb_id->status = 'sudah diterima';
        $pb_id->update();

        return response()->json([
            'text' => 'Serah terima berhasil dilakukan!',
            'data' => $barang_keluar
        ], 201);
    }

    public function pr($id)
    {
        $title = 'Barang Keluar PR';
        $pr = PR::findOrFail($id);
        $data = PRDetail::with('product')->where('pr_id', '=', $id)->get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('harga', function ($data) {
                    return formatAngka($data->harga);
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->addColumn('subtotal', function ($data) {
                    return formatAngka($data->subtotal);
                })
                ->rawColumns(['nama_produk', 'kategori', 'qty', 'harga', 'subtotal'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.barang_keluar.show.pr', compact(
            'title',
            'pr',
            'id',
        ));
    }

    public function serahTerimaPR($id)
    {
        $pr_id = PR::find($id);
        $pr_id->status = 'sudah diterima';
        $pr_id->update();

        $pr_details = PRDetail::where('pr_id', '=', $id)->get();
        foreach ($pr_details as $pr) {
            $barang_keluar = new BarangKeluar();
            $barang_keluar->produk_id = $pr->produk_id;
            $barang_keluar->pr_id = $id;
            $barang_keluar->penerima = $pr_id->pemohon;
            $barang_keluar->qty = $pr->qty;
            $barang_keluar->subtotal = $pr->qty * $pr->harga;
            $barang_keluar->jenis_permintaan = 'pr';
            $barang_keluar->status = 'sudah dikeluarkan';
            $barang_keluar->save();

            $produk = Produk::find($barang_keluar->produk_id);
            $produk->stok = $produk->stok - $barang_keluar->qty;
            $produk->update();
        }

        return response()->json([
            'text' => 'Serah terima berhasil dilakukan!',
            'data' => $barang_keluar
        ], 201);
    }
}
