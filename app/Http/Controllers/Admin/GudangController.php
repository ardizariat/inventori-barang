<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DataTables\GudangDataTable;
use App\Http\Controllers\Controller;
use App\Models\Gudang;

class GudangController extends Controller
{
    public function index(GudangDataTable $tableGudang)
    {
        $title = 'Gudang';
        $count = Gudang::count();
        $count++;
        $kode = 'GD' . kode($count, 4);
        return $tableGudang->render('admin.gudang.index', compact(
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
        ], 200);
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
        $delete = $data->delete();
        return response()->json([
            'text' => 'Gudang berhasil dihapus!'
        ], 200);
    }
}
