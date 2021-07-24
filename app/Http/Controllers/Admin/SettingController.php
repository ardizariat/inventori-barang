<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $title = 'Pengaturan';
        $setting = Setting::first();

        if (request()->ajax()) {
            return $setting;
        }

        return view('admin.setting.index', compact(
            'title',
        ));
    }

    public function update(Request $request)
    {
        $data = Setting::first();

        $request->validate([
            'nama_aplikasi' => 'required',
            'telepon' => 'numeric'
        ]);

        $data->nama_aplikasi = $request->nama_aplikasi;
        $data->telepon = $request->telepon;
        $data->alamat = $request->alamat;
        $data->deskripsi = $request->deskripsi;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            $request->validate([
                'logo' => 'image|max:2048|mimes:png,jpg,jpeg,svg'
            ]);

            if ($data->logo) {
                Storage::delete('/setting/' . $data->logo);
            }

            $extension = $file->getClientOriginalExtension();
            $filename = $request->nama_aplikasi . '_' . time() . uniqid() . '.' . $extension;
            $path = $file->storeAs('/setting/', $filename);
            $data->logo = $filename;
        }
        $save = $data->update();
        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Pengaturan berhasil diupdate!'
            ], 200);
        }
    }
}
