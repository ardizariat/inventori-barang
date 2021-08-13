<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Purchase Order';
        $suppliers = Supplier::latest()->get();
        if (request()->ajax()) {
            $status = $request->status;
            if (!empty($status)) {
                $data = PurchaseOrder::where('status', '=', $status)
                    ->get();
            } else {
                $data = PurchaseOrder::query()->orderBy('created_at', 'desc');
            }
            return datatables()->of($data)
                ->addColumn('status', function ($data) {
                    return view('admin.purchase_order._status', [
                        'data' => $data,
                    ]);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.purchase_order._aksi', [
                        'delete' => route('purchase-order.destroy', $data->id),
                        'show' => route('purchase-order.show', $data->id),
                    ]);
                })
                ->addColumn('total_item', function ($data) {
                    return formatAngka($data->total_item);
                })
                ->addColumn('total_harga', function ($data) {
                    return formatAngka($data->total_harga);
                })
                ->addColumn('supplier', function ($data) {
                    $supplier = $data->supplier->nama;
                    return $supplier;
                })
                ->rawColumns(['total_item', 'supplier', 'total_harga', 'status', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.purchase_order.index', compact(
            'title',
            'suppliers'
        ));
    }

    public function create($id)
    {

        $count = PurchaseOrder::count();
        $count++;
        $date = date('dmy');
        $kode = 'PO-' . $date . kode($count, 3);

        $po = new PurchaseOrder();
        $po->no_dokumen = $kode;
        $po->supplier_id = $id;
        $po->total_harga = 0;
        $po->total_item = 0;
        $po->save();

        $purchase_order_id = $po->id;
        $supplier_id = $po->supplier_id;

        session(['purchase_order_id' => $purchase_order_id]);
        session(['supplier_id' => $supplier_id]);

        return redirect()->route('purchase-order-detail.index');
    }

    public function show($id)
    {
        $title = 'Detail PO';
        $url = route('barang-masuk.index');
        $po = PurchaseOrder::with('supplier')
            ->where('id', $id)
            ->first();
        $tanggal = Carbon::parse($po->created_at)->format('d-m-Y');
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
        return view('admin.purchase_order.show', compact(
            'title',
            'id',
            'url',
            'po',
            'tanggal',
        ));
    }

    public function approved($id)
    {
        $count = BarangMasuk::count();
        $count++;
        $date = date('dmy');
        $kode = 'BR-' . $date . kode($count, 3);

        $po = PurchaseOrder::findOrFail($id);
        $po->status = 'complete';
        $po->update();

        $barang_masuk = new BarangMasuk();
        $barang_masuk->purchase_order_id = $po->id;
        $barang_masuk->no_dokumen = $kode;
        $barang_masuk->status = 'belum diterima';
        $barang_masuk->save();

        return response()->json([
            'text' => 'PO berhasil diapprove!'
        ], 200);
    }

    public function destroy($id)
    {
        $purchase_order_id = PurchaseOrderDetail::where('purchase_order_id', '=', $id)->get();
        foreach ($purchase_order_id as $detail) {
            $detail->delete();
        }
        $purchase_order = PurchaseOrder::findOrFail($id);
        $purchase_order->delete();
        return response()->json(null, 204);
    }
}
