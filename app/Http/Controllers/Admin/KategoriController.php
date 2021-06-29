<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\KategoriDataTable;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        $title = 'Kategori';
        return $dataTable->render('admin.kategori.index', compact(
            'title'
        ));
    }

    public function store(Request $request)
    {
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
}
