<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\KategoriDataTable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Facade\CauserResolver;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Kategori';
        if (request()->ajax()) {
            $data = Kategori::query()->orderBy('created_at', 'desc');
            return datatables()->of($data)
                ->addColumn('dibuat', function ($data) {
                    $data = Carbon::parse($data->created_at)->format('d F Y, H:i');
                    return $data;
                })
                ->addColumn('status', function ($data) {
                    return view('admin.kategori._status', [
                        'data' => $data
                    ]);
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.kategori._aksi', [
                        'update' => route('kategori.update', $data->id),
                        'delete' => route('kategori.destroy', $data->id),
                        'data' => $data
                    ]);
                })
                ->rawColumns(['dibuat', 'status', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.kategori.index', compact(
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

        activity()->log('membuat kategori ' . $data->kategori);



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

        activity()->log('mengubah kategori ' . $data->kategori);

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
        activity()->log('menghapus kategori ' . $data->kategori);
        $delete = $data->delete();

        if ($delete) {
            return response()->json([
                'text' => 'Kategori berhasil dihapus!'
            ], 200);
        }
    }
}
