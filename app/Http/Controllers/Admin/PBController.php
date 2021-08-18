<?php

namespace App\Http\Controllers\Admin;

use App\Models\PB;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\PBDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class PBController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Permintaan Barang PB';
        if (request()->ajax()) {
            $data = PB::with('user')->orderBy('created_at', 'desc')->get();
            return datatables()->of($data)
                ->addColumn('sect_head', function ($data) {
                    return view('admin.pb.index.sect_head', [
                        'sect_head' => $data->sect_head,
                    ]);
                })
                ->addColumn('dept_head', function ($data) {
                    return view('admin.pb.index.dept_head', [
                        'dept_head' => $data->dept_head,
                    ]);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.pb.index.aksi', [
                        'show' => route('pb.show', $data->id),
                        'destroy' => route('pb.destroy', $data->id),
                    ]);
                })
                ->addColumn('download', function ($data) {
                    return view('admin.pb.index.download', [
                        'data' => $data
                    ]);
                })
                ->addColumn('pemohon', function ($data) {
                    return $data->user->name;
                })
                ->rawColumns(['pemohon', 'dept_head', 'aksi', 'sect_head', 'download'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pb.index.index', compact(
            'title',
        ));
    }

    public function create()
    {
        $count = PB::count();
        $count++;
        $date = date('dmy');
        $kode = 'PB-' . $date . kode($count, 3);

        $pb = new PB();
        $pb->no_dokumen = $kode;
        $pb->pemohon = auth()->user()->id;
        $pb->total_item = 0;
        $pb->sect_head = 'on process';
        $pb->dept_head = 'on process';
        $pb->save();

        activity()->log('Membuat permintaan barang PB');

        session(['pb_id' => $pb->id]);

        return redirect()->route('pb-detail.create');
    }

    public function show($id)
    {
        $title = 'Detail Permintaan Barang PB';
        $url = route('pb.index');
        $pb = PB::where('id', $id)->first();
        $tanggal = Carbon::parse($pb->created_at)->format('d-m-Y');
        if (request()->ajax()) {
            $data = PBDetail::with('product')->where('pb_id', $id)->get();
            return datatables()->of($data)
                ->addColumn('nama_produk', function ($data) {
                    return $data->product->nama_produk;
                })
                ->addColumn('qty', function ($data) {
                    return formatAngka($data->qty) . ' ' . $data->product->satuan;
                })
                ->rawColumns(['qty', 'nama_produk'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pb.show', compact(
            'title',
            'url',
            'pb',
            'tanggal',
            'id',
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $pb = PB::findOrFail($id);
        $status = $request->value;
        $user = $request->data;

        if ($status == 'rejected' && $user == 'sect_head') {
            $pb->sect_head = 'rejected';
            $pb->tgl_approve_sect = date('Y-m-d');
            $pb->update();
        }
        if ($status == 'approved' && $user == 'sect_head') {
            $pb->sect_head = 'approved';
            $pb->tgl_approve_sect = date('Y-m-d');
            $pb->update();
        }
        if ($status == 'rejected' && $user == 'dept_head') {
            $pb->dept_head = 'rejected';
            $pb->tgl_approve_dept = date('Y-m-d');
            $pb->update();
        }
        if ($status == 'approved' && $user == 'dept_head') {
            $pb->dept_head = 'approved';
            $pb->tgl_approve_dept = date('Y-m-d');
            $pb->update();
        }
        activity()->log('Mengubah status permintaan barang');
        return response()->json([
            'text' => 'Data berhasil diperbarui',
            'data' => $pb
        ], 200);
    }

    public function destroy($id)
    {
    }

    public function downloadPdf($id)
    {
        $title = 'Permintaan Barang PB';
        $pb = PB::findOrFail($id);
        $pb_detail = PBDetail::where('pb_id', '=', $id)->get();
        $pdf = PDF::loadView('admin.pb.pdf.pb', compact(
            'pb',
            'pb_detail',
            'title'
        ));

        $pdf->setOptions([
            'page-size' => 'a4',
        ]);
        activity()->log('download file pdf permintaan barang PB');
        return $pdf->stream('permintaan-barang-pb.pdf');
    }
}
