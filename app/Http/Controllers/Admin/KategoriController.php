<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\KategoriDataTable;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $tableKategori)
    {
        $title = 'Kategori';
        return $tableKategori->render('admin.kategori.index', compact(
            'title'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|unique:kategori,kategori',
            'status' => 'required',
        ]);
        $kategori = $request->kategori;
        $status = $request->status;

        $data = new Kategori();
        $data->kategori = $kategori;
        $data->status = $status;
        $save = $data->save();

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Kategori berhasil ditambahkan!'
            ], 200);
        }
    }

    public function show($id)
    {
        $data = Kategori::findOrFail($id);
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|string|unique:kategori,kategori,' . $id,
            'status' => 'required',
        ]);
        $kategori = $request->kategori;
        $status = $request->status;

        $data = Kategori::findOrFail($id);
        $data->kategori = $kategori;
        $data->status = $status;
        $update = $data->update();

        if ($update) {
            return response()->json([
                'data' => $data,
                'text' => 'Kategori berhasil diubah!'
            ], 200);
        }
    }

    public function destroy($id)
    {
        $data = Kategori::findOrFail($id);
        $delete = $data->delete();

        if ($delete) {
            return response()->json([
                'text' => 'Kategori berhasil dihapus!'
            ], 200);
        }
    }
}
