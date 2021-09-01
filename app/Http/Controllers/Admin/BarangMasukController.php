<?php

namespace App\Http\Controllers\Admin;

use App\Models\PO;
use App\Models\PR;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\PRDetail;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Masuk';
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');
        $po = PO::pluck('no_dokumen', 'id');

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangMasuk::with(['po'])
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();
            } else {
                $data = BarangMasuk::with(['po'])
                    ->where('status', '=', 'sudah diterima')
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
                ->addColumn('supplier', function ($data) {
                    return $data->po->supplier->nama;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = Carbon::parse($data->created_at)->format('d-m-Y');
                    return $tanggal;
                })
                ->addColumn('qty', function ($data) {
                    $qty = formatAngka($data->qty) . ' ' . $data->product->satuan;
                    return $qty;
                })
                ->rawColumns(['nama_produk', 'supplier', 'kategori', 'qty', 'tanggal'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_masuk.index.index', compact(
            'title',
            'po',
        ));
    }

    public function pilihBarangMasuk(Request $request)
    {
        if (request()->json()) {
            $id = $request->id;
            $po = PO::find($id);
            $pemohon = $po->pr->user->name;
            $supplier = $po->supplier->nama;
            $tanggal = $po->created_at->format('d-m-Y');
            $url = route('barang-masuk.po', $po->id);
            return response()->json([
                'data' => $po,
                'url' => $url,
                'supplier' => $supplier,
                'pemohon' => $pemohon,
                'tanggal' => $tanggal,
            ], 200);
        }
    }

    public function po(Request $request)
    {
        $query = $request->value;
        $po = DB::table('po')
            ->where('no_dokumen', 'LIKE', "%{$query}%")
            ->get();

        $output = '<div class="dropdown-menu d-block position-relative">';
        foreach ($po as $item) {
            $output .= '
                <a href="#" onclick="pilihData(`' . $item->id . '`,`' . $item->no_dokumen . '`,`' . route('barang-masuk.show-po') . '`)" class="item dropdown-item" data-id="' . $item->id . '">' . $item->no_dokumen . '</a>
            ';
        }
        $output .= '</div>';

        echo $output;
    }

    public function dataPO(Request $request)
    {
        $data = PO::findOrFail($request->id);
        $tanggal = $data->created_at->format('d-m-Y');
        $supplier = $data->supplier->nama;
        $url = route('barang-masuk.po-show', $data->id);
        return response()->json([
            'data' => $data,
            'tanggal' => $tanggal,
            'supplier' => $supplier,
            'url' => $url,
        ], 200);
    }

    public function showPo($id)
    {
        $title = 'Purchase Order Detail';
        $po = PO::findOrFail($id);
        if (request()->ajax()) {
            $pr = PR::findOrFail($po->pr_id);
            $data = PRDetail::with('product')->where('pr_id', '=', $po->pr_id)->get();
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->product->category->kategori;
                })
                ->addColumn('qty', function ($data) {
                    $qty = formatAngka($data->qty) . ' ' . $data->product->satuan;
                    return $qty;
                })
                ->addColumn('harga', function ($data) {
                    $harga = formatAngka($data->harga);
                    return $harga;
                })
                ->addColumn('subtotal', function ($data) {
                    $subtotal = formatAngka($data->subtotal);
                    return $subtotal;
                })
                ->rawColumns(['nama_produk', 'subtotal', 'qty', 'harga'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.barang_masuk.show.po', compact(
            'title',
            'po',
            'id',
        ));
    }

    public function terimaBarang($id)
    {
        $po = PO::findOrFail($id);
        $po->status = 'complete';
        $po->update();

        $pr = PR::find($po->pr_id);
        $pr->status_po = 'complete';
        $pr->update();

        $pr_details = PRDetail::where('pr_id', '=', $po->pr_id)->get();
        foreach ($pr_details as $pr_detail) {
            $barang_masuk = new BarangMasuk();
            $barang_masuk->po_id = $po->id;
            $barang_masuk->produk_id = $pr_detail->produk_id;
            $barang_masuk->penerima = Auth::id();
            $barang_masuk->qty = $pr_detail->qty;
            $barang_masuk->subtotal = $pr_detail->subtotal;
            $barang_masuk->status = 'sudah diterima';
            $barang_masuk->save();

            $produk = Produk::find($barang_masuk->produk_id);
            $produk->stok = $produk->stok + $barang_masuk->qty;
            $produk->status = 'aktif';
            $produk->update();
        }
        return response()->json([
            'text' => 'Data berhasil diperbarui dan sudah masuk ke dalam data barang masuk!',
            'data' => $po
        ], 201);
    }
}
