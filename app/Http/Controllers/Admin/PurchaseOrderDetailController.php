<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;

class PurchaseOrderDetailController extends Controller
{
    public function index()
    {
        $purchase_order_id = session('purchase_order_id');
        $supplier_id = session('supplier_id');
        $produk = Produk::latest()->get();
        $supplier = Supplier::find($supplier_id);

        if (!$supplier) {
            abort(404);
        }

        return view('admin.purchase_order.create', compact(
            'purchase_order_id',
            'produk',
            'supplier'
        ));
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id', '=', $request->produk_id)->first();
        $produk_id = $produk->id;
        $harga = $produk->harga;
        $purchase_order_id = $request->purchase_order_id;

        if (!$produk) {
            return response()->json([
                'text' => 'Data gagal disimpan!'
            ], 400);
        }

        $detail_po = new PurchaseOrderDetail();
        $detail_po->purchase_order_id = $purchase_order_id;
        $detail_po->produk_id = $produk_id;
        $detail_po->qty = 1;
        $detail_po->harga = $harga;
        $detail_po->grand_total = $harga;
        $detail_po->save();

        return response()->json([
            'text' => 'Data berhasil disimpan'
        ], 201);
    }

    public function data($id)
    {
        $data = PurchaseOrderDetail::with('product')
            ->where('purchase_order_id', $id)
            ->get();
        return datatables()->of($data)
            ->addColumn('nama_produk', function ($data) {
                return $data->product->nama_produk;
            })
            ->addColumn('harga', function ($data) {
                return $data->product->harga;
            })
            ->addColumn('aksi', function ($data) {
                return view('admin.purchase_order._aksi', [
                    'delete' => route('purchase-order-detail.destroy', $data->id),
                ]);
            })
            ->rawColumns(['nama_produk', 'harga', 'aksi'])
            ->addIndexColumn()
            ->make(true);
    }

    public function destroy($id)
    {
        $data = PurchaseOrderDetail::findOrFail($id);
        $delete = $data->delete();

        if ($delete) {
            return response()->json([
                'text' => 'Data berhasil dihapus!'
            ], 200);
        }
    }
}
