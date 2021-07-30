<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Gudang;
use Illuminate\Http\Request;
use App\DataTables\GudangDataTable;
use App\Http\Controllers\Controller;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Gudang';
        $count = Gudang::count();
        $count++;
        $kode = 'GD' . kode($count, 4);

        if (request()->ajax()) {
            $data = Gudang::query()->orderBy('created_at', 'desc');
            return datatables()->of($data)
                ->addColumn('dibuat', function ($data) {
                    $data = Carbon::parse($data->created_at)->format('d F Y, H:i');
                    return $data;
                })
                ->addColumn('status', function ($data) {
                    return view('admin.gudang._status', [
                        'data' => $data
                    ]);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.gudang._aksi', [
                        'update' => route('gudang.update', $data->id),
                        'delete' => route('gudang.destroy', $data->id),
                        'data' => $data
                    ]);
                })
                ->rawColumns(['dibuat', 'status', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.gudang.index', compact(
            'title',
            'kode'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:gudang,nama|string',
            'lokasi' => 'required',
            'status' => 'required',
        ]);

        $data = new Gudang();
        $data->kode = $request->kode;
        $data->nama = $request->nama;
        $data->lokasi = $request->lokasi;
        $data->status = $request->status;
        $save = $data->save();

        activity()->log('menambahkan gudang ' . $data->nama);

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Gudang berhasil ditambahkan!'
            ], 200);
        }
    }

    public function show($id)
    {
        $data = Gudang::findOrFail($id);
        return response()->json([
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|unique:gudang,nama,' . $id,
            'lokasi' => 'required',
            'status' => 'required',
        ]);
        $data = Gudang::findOrFail($id);
        $data->kode = $request->kode;
        $data->nama = $request->nama;
        $data->lokasi = $request->lokasi;
        $data->status = $request->status;
        $update = $data->update();

        activity()->log('mengubah gudang ' . $data->nama);

        if ($update) {
            return response()->json([
                'data' => $data,
                'text' => 'Gudang berhasil diubah!'
            ], 200);
        }
    }

    public function destroy($id)
    {
        $data = Gudang::findOrFail($id);
        activity()->log('menghapus gudang ' . $data->nama);
        $delete = $data->delete();
        return response()->json([
            'text' => 'Gudang berhasil dihapus!'
        ], 200);
    }
}
