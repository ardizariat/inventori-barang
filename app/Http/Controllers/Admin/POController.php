<?php

namespace App\Http\Controllers\Admin;

use App\Models\PO;
use App\Models\PR;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\PODetail;
use App\Models\PRDetail;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class POController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Purchase Order';
        $pr = PR::where([
            ['status', '=', 'belum diterima'],
            ['status_po', '=', 'pending'],
            ['sect_head', '=', 'approved'],
            ['dept_head', '=', 'approved']
        ])
            ->pluck('no_dokumen', 'id');

        $suppliers = Supplier::pluck('nama', 'id');
        if (request()->ajax()) {
            $data = PO::with('pr')->orderBy('created_at', 'desc')->get();
            return datatables()->of($data)
                ->addColumn('download', function ($data) {
                    return view('admin.po.index.download', [
                        'data' => $data
                    ]);
                })
                ->addColumn('status', function ($data) {
                    return view('admin.po.index.status', [
                        'data' => $data,
                        'status' => $data->status,
                    ]);
                })
                ->addColumn('total_item', function ($data) {
                    return formatAngka($data->total_item);
                })
                ->addColumn('total_harga', function ($data) {
                    return formatAngka($data->total_harga);
                })
                ->addColumn('pemohon', function ($data) {
                    return $data->pr->user->name;
                })
                ->rawColumns(['pemohon', 'status', 'total_item', 'total_harga', 'download'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.po.index.index', compact(
            'title',
            'suppliers',
            'pr',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pr' => 'required',
            'supplier' => 'required',
        ]);

        $count = PO::count();
        $count++;
        $date = date('dmy');
        $kode = 'PO-' . $date . kode($count, 3);

        $pr_id = $request->pr;
        $supplier_id = $request->supplier;

        // PR
        $pr = PR::findOrFail($pr_id);
        $total_item = $pr->total_item;
        $total_harga = $pr->total_harga;


        $po = new PO();
        $po->no_dokumen = $kode;
        $po->pr_id = $pr_id;
        $po->supplier_id = $supplier_id;
        $po->total_harga = $total_harga;
        $po->total_item = $total_item;
        $po->status = 'pending';
        $po->save();

        return response()->json([
            'data' => $po,
            'text' => 'PO berhasil dibuat!',
        ], 201);
    }


    public function show($id)
    {
        $title = 'Detail PO';
        $url = route('pr.index');
        $po = PO::findOrFail($id);
        $pr_id = PR::findOrFail($po->pr_id);
        $tanggal = Carbon::parse($po->created_at)->format('d-m-Y');
        if (request()->ajax()) {
            $data = PRDetail::with('product')->where('pr_id', $pr_id->id)->get();
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->addColumn('harga', function ($data) {
                    return formatAngka($data->harga);
                })
                ->addColumn('subtotal', function ($data) {
                    return formatAngka($data->subtotal);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.po.show.aksi', [
                        'url' => route('pr.delete-item', $data->id),
                    ]);
                })
                ->rawColumns(['qty', 'nama_produk', 'harga', 'subtotal', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.po.show.show', compact(
            'title',
            'url',
            'po',
            'tanggal',
            'id',
        ));
    }

    public function update(Request $request, $id)
    {
        $po = PO::findOrFail($id);
        $status = $request->value;
        if ($status == 'complete') {
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
            ], 200);
        }
        if ($status == 'pending') {
            $po->status = 'pending';
            $po->update();
            return response()->json([
                'text' => 'Data berhasil dipending',
            ], 200);
        }
    }

    public function destroy($id)
    {
        $purchase_order_id = PODetail::where('purchase_order_id', '=', $id)->get();
        foreach ($purchase_order_id as $detail) {
            $detail->delete();
        }
        $purchase_order = PO::findOrFail($id);
        $purchase_order->delete();
        return response()->json(null, 204);
    }

    public function downloadPdf($id)
    {
        $title = 'Purchase Order';
        $po = PO::findOrFail($id);
        $pr_id = $po->pr_id;
        $pr = PR::find($pr_id);
        $pr_detail = PRDetail::where('pr_id', '=', $pr_id)->get();
        $pdf = \PDF::loadView('admin.po.pdf.po', compact(
            'pr',
            'po',
            'pr_detail',
            'title'
        ));

        $pdf->setOptions([
            'page-size' => 'a4',
        ]);
        activity()->log('download file pdf pengajuan Purchase Order');
        return $pdf->stream('Purchase Order');
    }
}
