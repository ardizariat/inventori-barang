<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Supplier';
        if (request()->ajax()) {
            $data = Supplier::query()->orderBy('created_at', 'desc');
            return datatables()->of($data)
                ->addColumn('dibuat', function ($data) {
                    $data = Carbon::parse($data->created_at)->format('d F Y, H:i');
                    return $data;
                })
                ->addColumn('aksi', function ($data) {
                    return view('admin.supplier._aksi', [
                        'show' => route('supplier.show', $data->id),
                        'update' => route('supplier.update', $data->id),
                        'delete' => route('supplier.destroy', $data->id),
                        'data' => $data
                    ]);
                })
                ->rawColumns(['dibuat', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.supplier.index', compact(
            'title'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:suppliers,nama',
            'email' => 'required|email',
            'telpon' => 'required|numeric',
        ]);

        $data = new Supplier();
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->telpon = $request->telpon;
        $data->alamat = $request->alamat;
        $data->status = $request->status;
        $save = $data->save();

        activity()->log('membuat supplier ' . $data->nama);

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Supplier berhasil ditambahkan!'
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|unique:suppliers,nama,' . $id,
            'email' => 'required|email',
            'telpon' => 'required|numeric',
        ]);

        $data = Supplier::findOrFail($id);
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->telpon = $request->telpon;
        $data->alamat = $request->alamat;
        $data->status = $request->status;
        $update = $data->update();

        activity()->log('mengubah supplier' . $data->nama);

        if ($update) {
            return response()->json([
                'data' => $data,
                'text' => 'Supplier berhasil diubah!'
            ], 200);
        }
    }
    public function show($id)
    {
        $data = Supplier::findOrFail($id);
        return response()->json([
            'data' => $data,
        ], 200);
    }
    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);
        activity()->log('menghapus supplier ' . $data->nama);
        $delete = $data->delete();

        if ($delete) {
            return response()->json([
                'text' => 'Supplier berhasil dihapus!'
            ], 200);
        }
    }
}
