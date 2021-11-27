<?php

namespace App\Repositories;

use App\Http\Requests\Admin\GudangRequest;
use App\Repositories\Interfaces\GudangRepositoryInterface;
use App\Models\Gudang;


class GudangRepository implements GudangRepositoryInterface
{
    public function index()
    {
        $data = Gudang::query()->orderBy('created_at', 'desc')->get();
        return datatables()->of($data)
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
            ->rawColumns(['status', 'aksi'])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(GudangRequest $request)
    {
        $count = Gudang::count();
        $count++;
        $kode = 'GD' . kode($count, 4);

        $data = new Gudang();
        $data->kode = $kode;
        $data->nama = $request->nama;
        $data->lokasi = $request->lokasi;
        $data->status = $request->status;
        $save = $data->save();

        activity()->log('menambahkan gudang ' . $data->nama);

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Gudang berhasil ditambahkan!'
            ], 201);
        }
    }

    public function update(GudangRequest $request, Gudang $gudang)
    {
        $data = $gudang;

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

    public function destory(Gudang $gudang)
    {
        $gudang->delete();
        activity()->log('menghapus gudang ' . $gudang->nama);
        return response()->json([
            'text' => 'Gudang berhasil dihapus!'
        ], 200);
    }
}
