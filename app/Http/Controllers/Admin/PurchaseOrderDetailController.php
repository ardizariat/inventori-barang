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
        $title = 'Detail PO';
        $url = route('purchase-order.index');
        $purchase_order_id = session('purchase_order_id');
        $supplier_id = session('supplier_id');
        $produk = Produk::latest()->get();
        $supplier = Supplier::findOrFail($supplier_id);
        $po = PurchaseOrderDetail::where('purchase_order_id', $purchase_order_id)->get();
        $produk_id = [];
        foreach ($po as $item) {
            $produk_id = $item->produk_id;
        }
        if (!$supplier) {
            abort(404);
        }

        return view('admin.purchase_order.purchase_order_detail.create', compact(
            'purchase_order_id',
            'produk',
            'supplier',
            'title',
            'url',
            'produk_id',
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
        $detail_po->subtotal = $harga;
        $detail_po->save();

        $po = PurchaseOrder::findOrFail($detail_po->purchase_order_id);
        if ($po->total_item != null && $po->total_harga != null) {
            $po->total_item = $po->total_item + $detail_po->qty;
            $po->total_harga = $po->total_harga + $detail_po->subtotal;
            $po->update();
        } else {
            $po->total_item = $detail_po->qty;
            $po->total_harga = $detail_po->subtotal;
            $po->update();
        }

        return response()->json([
            'text' => 'Data berhasil disimpan'
        ], 201);
    }

    public function data($id)
    {
        $data = PurchaseOrderDetail::with('product')
            ->where('purchase_order_id', $id)
            ->get();

        $total_harga = $data->sum('subtotal');
        $total_item = $data->sum('qty');

        return datatables()->of($data)
            ->addColumn('nama_produk', function ($data) {
                return $data->product->nama_produk;
            })
            ->addColumn('harga', function ($data) {
                return formatAngka($data->harga);
            })
            ->addColumn('satuan', function ($data) {
                return $data->product->satuan;
            })
            ->addColumn('subtotal', function ($data) {
                return formatAngka($data->subtotal);
            })
            ->addColumn('qty', function ($data) use ($total_item, $total_harga) {
                return view('admin.purchase_order.purchase_order_detail._qty', [
                    'data' => $data,
                    'total_item' => formatAngka($total_item),
                    'total_harga' => formatAngka($total_harga),
                ]);
            })
            ->addColumn('aksi', function ($data) {
                return view('admin.purchase_order.purchase_order_detail._aksi', [
                    'delete' => route('purchase-order-detail.destroy', $data->id),
                ]);
            })
            ->rawColumns(['nama_produk', 'harga', 'subtotal', 'aksi', 'qty', 'satuan'])
            ->addIndexColumn()
            ->make(true);
    }


    public function update(Request $request, $id)
    {
        $detail_po = PurchaseOrderDetail::findOrFail($id);
        $subtotal = $request->qty * $detail_po->harga;
        $detail_po->qty = $request->qty;
        $detail_po->subtotal = $subtotal;
        $detail_po->update();

        $purchase_order_id = PurchaseOrderDetail::where('purchase_order_id', '=', $detail_po->purchase_order_id)->get();
        $total_harga = $purchase_order_id->sum('subtotal');
        $total_item = $purchase_order_id->sum('qty');

        $po = PurchaseOrder::findOrFail($detail_po->purchase_order_id);
        $po->total_harga = $total_harga;
        $po->total_item = $total_item;
        $po->update();

        return response()->json([
            'text' => 'Data berhasil diubah!'
        ], 200);
    }

    public function destroy($id)
    {
        $data = PurchaseOrderDetail::findOrFail($id);
        $subtotal = $data->subtotal;
        $qty = $data->qty;

        $po = PurchaseOrder::findOrFail($data->purchase_order_id);
        $po->total_harga = $po->total_harga - $subtotal;
        $po->total_item = $po->total_item - $qty;

        $po->update();
        $delete = $data->delete();

        if ($delete) {
            return response()->json([
                'text' => 'Data berhasil dihapus!'
            ], 200);
        }
    }
}
