<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Supplier;
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
                ->addColumn('total_item', function ($data) {
                    $detail = PurchaseOrderDetail::where('purchase_order_id', '=', $data->id)->get();
                    $item = $detail->sum('qty');
                    return formatAngka($item);
                })
                ->addColumn('grand_total', function ($data) {
                    $detail = PurchaseOrderDetail::where('purchase_order_id', '=', $data->id)->get();
                    $grand_total = $detail->sum('grand_total');
                    return formatAngka($grand_total);
                })
                ->addColumn('supplier', function ($data) {
                    $supplier = $data->supplier->nama;
                    return $supplier;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = $data->created_at->format('d-m-Y H:i');
                    return $tanggal;
                })
                ->rawColumns(['total_item', 'supplier', 'tanggal', 'grand_total', 'status'])
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
        $po->save();

        $purchase_order_id = $po->id;
        $supplier_id = $po->supplier_id;

        session(['purchase_order_id' => $purchase_order_id]);
        session(['supplier_id' => $supplier_id]);

        return redirect()->route('purchase-order-detail.index');
    }
}
