<?php

namespace App\Http\Controllers\Admin;

use App\Models\PR;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\PRDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class PRController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Permintaan Barang PR';
        $user = auth()->user();
        // Kalo permintaan barang kga diisi user
        $pr_null = PR::where([
            ['total_item', '<=', 0],
            ['total_harga', '<=', 0],
        ])
            ->get();
        if (isset($pr_null)) {
            foreach ($pr_null as $pr) {
                $pr_detail = PRDetail::where('pr_id', '=', $pr->id)->get();
                foreach ($pr_detail as $detail) {
                    $detail->delete();
                }
                $pr->delete();
            }
        }

        if (request()->ajax()) {
            if ($user->hasRole('super-admin|admin|sect_head|dept_head|direktur')) {
                $data = PR::with('user')->orderBy('created_at', 'desc')->get();
            } elseif ($user->hasRole('user')) {
                $data = PR::where('pemohon', '=', $user->id)->get();
            }
            return datatables()->of($data)
                ->addColumn('sect_head', function ($data) {
                    return view('admin.pr.index.sect_head', [
                        'sect_head' => $data->sect_head,
                        'data' => $data
                    ]);
                })
                ->addColumn('dept_head', function ($data) {
                    return view('admin.pr.index.dept_head', [
                        'dept_head' => $data->dept_head,
                        'data' => $data
                    ]);
                })
                ->addColumn('direktur', function ($data) {
                    return view('admin.pr.index.direktur', [
                        'direktur' => $data->direktur,
                        'data' => $data
                    ]);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.pr.index.aksi', [
                        'show' => route('pr.show', $data->id),
                        'destroy' => route('pr.destroy', $data->id),
                        'data' => $data,
                    ]);
                })
                ->addColumn('download', function ($data) {
                    return view('admin.pr.index.download', [
                        'data' => $data
                    ]);
                })
                ->addColumn('pemohon', function ($data) {
                    return $data->user->name;
                })
                ->rawColumns(['pemohon', 'dept_head', 'aksi', 'sect_head', 'download', 'direktur'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pr.index.index', compact(
            'title',
        ));
    }

    public function create()
    {
        $count = PR::count();
        $count++;
        $date = date('dmy');
        $kode = 'PR-' . $date . kode($count, 3);

        $pr = new PR();
        $pr->no_dokumen = $kode;
        $pr->pemohon = auth()->user()->id;
        $pr->total_item = 0;
        $pr->total_harga = 0;
        $pr->save();

        activity()->log('Membuat permintaan barang PR');

        session(['pr_id' => $pr->id]);

        return redirect()->route('pr-detail.create');
    }

    public function cancel($id)
    {
        $pr_id = PR::findOrFail($id);
        $pr_detail = PRDetail::where('pr_id', '=', $id)->get();

        if (isset($pr_detail)) {
            foreach ($pr_detail as $detail) {
                $detail->delete();
            }
        }
        $pr_id->delete();

        return response()->json([
            'text' => 'Data berhasil dihapus'
        ], 204);
    }

    public function show($id)
    {
        $title = 'Detail Permintaan Pembelian Barang PR';
        $url = route('pr.index');
        $pr = PR::findOrFail($id);
        $tanggal = Carbon::parse($pr->created_at)->format('d-m-Y');
        if (request()->ajax()) {
            $data = PRDetail::with('product')->where('pr_id', $id)->get();
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->addColumn('harga_satuan', function ($data) {
                    return formatAngka($data->harga);
                })
                ->addColumn('subtotal', function ($data) {
                    return formatAngka($data->subtotal);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.pr.show.aksi', [
                        'url' => route('pr.delete-item', $data->id),
                    ]);
                })
                ->rawColumns(['qty', 'nama_produk', 'harga_satuan', 'subtotal', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pr.show.show', compact(
            'title',
            'url',
            'pr',
            'tanggal',
            'id',
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $pr = PR::findOrFail($id);
        $status = $request->value;
        $user = $request->data;

        if ($status == 'rejected' && $user == 'sect_head') {
            $pr->sect_head = 'rejected';
            $pr->tgl_approve_sect = date('Y-m-d');
            $pr->update();
        }
        if ($status == 'approved' && $user == 'sect_head') {
            $pr->sect_head = 'approved';
            $pr->tgl_approve_sect = date('Y-m-d');
            $pr->update();
        }
        if ($status == 'rejected' && $user == 'dept_head') {
            $pr->dept_head = 'rejected';
            $pr->tgl_approve_dept = date('Y-m-d');
            $pr->update();
        }
        if ($status == 'approved' && $user == 'dept_head') {
            $pr->dept_head = 'approved';
            $pr->tgl_approve_dept = date('Y-m-d');
            $pr->update();
        }
        if ($status == 'rejected' && $user == 'direktur') {
            $pr->direktur = 'rejected';
            $pr->tgl_approve_dept = date('Y-m-d');
            $pr->update();
        }
        if ($status == 'approved' && $user == 'direktur') {
            $pr->direktur = 'approved';
            $pr->tgl_approve_dept = date('Y-m-d');
            $pr->update();
        }
        activity()->log('Mengubah status permintaan barang');
        return response()->json([
            'text' => 'Data berhasil diperbarui',
            'data' => $pr
        ], 200);
    }

    public function deleteItem($id)
    {
        $pr_detail = PRDetail::findOrFail($id);
        $pr_id = PR::findOrFail($pr_detail->pr_id);
        $produk = Produk::findOrFail($pr_detail->produk_id);

        $total_item = $pr_id->total_item - $pr_detail->qty;
        $total_harga = $pr_id->total_harga - $pr_detail->subtotal;
        $pr = PR::findOrFail($pr_detail->pr_id);
        $pr->total_item = $total_item;
        $pr->total_harga = $total_harga;
        $pr->update();

        $produk->delete();
        $pr_detail->delete();

        return response()->json(
            null,
            204
        );
    }

    public function destroy($id)
    {
        $pr_id = PR::findOrFail($id);
        $pr_details = PRDetail::where('pr_id', '=', $id)->get();

        foreach ($pr_details as $detail) {
            $produk = Produk::findOrFail($detail->produk_id);
            $produk->delete();
            $detail->delete();
        }

        $pr_id->delete();

        return response()->json([
            'text' => 'Data berhasil dihapus'
        ], 204);
    }

    public function downloadPdf($id)
    {
        $title = 'Permintaan Pembelian Barang PR';
        $pr = PR::findOrFail($id);
        $pr_detail = PRDetail::where('pr_id', '=', $id)->get();
        $pdf = \PDF::loadView('admin.pr.pdf.pr', compact(
            'pr',
            'pr_detail',
            'title'
        ));

        $pdf->setOptions([
            'page-size' => 'a4',
        ]);
        activity()->log('download file pdf permintaan pembelian barang PR');
        return $pdf->stream('permintaan pembelian barang PR.pdf');
    }
}
