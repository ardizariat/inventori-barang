<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Http\Controllers\Controller;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Barang Masuk';
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = BarangMasuk::whereBetween('created_at', [$from_date, $to_date])->get();
            } else {
                $data = BarangMasuk::query()->orderBy('created_at', 'desc');
            }
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    return view('admin.barang_masuk._aksi', [
                        'show' => route('barang-masuk.show', $data->purchase_order_id),
                    ]);
                })
                ->addColumn('status', function ($data) {
                    return view('admin.barang_masuk._status', [
                        'data' => $data
                    ]);
                })
                ->addColumn('total_item', function ($data) {
                    $total_item = $data->purchaseOrder->total_item;
                    return formatAngka($total_item);
                })
                ->addColumn('total_harga', function ($data) {
                    $total_harga = $data->purchaseOrder->total_harga;
                    return formatAngka($total_harga);
                })
                ->addColumn('tanggal', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->rawColumns(['total_item', 'total_harga', 'status', 'aksi', 'tanggal'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang_masuk.index', compact(
            'title',
        ));
    }

    public function show($id)
    {
        $title = 'Detail PO';
        $url = route('barang-masuk.index');
        $barang_masuk = BarangMasuk::where('purchase_order_id', '=', $id)->first();
        $barang_masuk_id = $barang_masuk->id;
        $tanggal = Carbon::parse($barang_masuk->created_at)->format('d-m-Y');
        if (request()->ajax()) {
            $data = PurchaseOrderDetail::with('product')->where('purchase_order_id', '=', $id)->get();
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->addColumn('subtotal', function ($data) {
                    return formatAngka($data->subtotal);
                })
                ->addColumn('harga', function ($data) {
                    return formatAngka($data->harga);
                })
                ->rawColumns(['harga', 'subtotal', 'qty', 'nama_produk'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.barang_masuk.show', compact(
            'title',
            'barang_masuk_id',
            'id',
            'url',
            'barang_masuk',
            'tanggal',
        ));
    }

    public function update($id)
    {
        $barang_masuk = BarangMasuk::findOrFail($id);
        $po_id = $barang_masuk->purchaseOrder->id;
        $po_detail = PurchaseOrderDetail::where('purchase_order_id', '=', $po_id)->get();
        $barang_masuk->status = 'diterima';
        $barang_masuk->update();

        foreach ($po_detail as $item) {
            $produk = Produk::findOrFail($item->produk_id);
            $produk->stok = $produk->stok + $item->qty;
            $produk->supplier_id = $item->supplier_id;
            $produk->update();
        }
        return response()->json([
            'text' => 'Barang berhasil masuk ke dalam stok!'
        ], 200);
    }
}
