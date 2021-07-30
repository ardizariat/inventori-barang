<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileUserController extends Controller
{
    public function index()
    {
        $title = 'Detail Profile';
        $user = Auth::user();
        return view('admin.profile_user.index', compact('user', 'title'));
    }

    public function edit()
    {
        $title = 'Ubah Profile';

        if (request()->ajax()) {
            $user = Auth::user();
            return $user;
        }

        return view('admin.profile_user.edit', compact(
            'title',
        ));
    }

    public function update(Request $request)
    {
        $data = auth()->user();

        $id = $data->id;
        $request->validate([
            'username' => 'unique:users,username,' . $id,
            'email' => 'unique:users,email,' . $id,
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $request->validate([
                'foto' => 'image|max:2048|mimes:png,jpg,jpeg,svg'
            ]);

            if ($data->foto) {
                Storage::delete('/user/' . $data->foto);
            }

            $extension = $file->getClientOriginalExtension();
            $filename = $request->username . '_' . time() . uniqid() . '.' . $extension;
            $path = $file->storeAs('/user/', $filename);
            $data->update([
                'foto' => $filename
            ]);
        }

        $save = $data->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Profile user berhasil diupdate!'
            ], 200);
        }
    }

    public function edit_password()
    {
        $title = 'Ganti Password';

        return view('admin.profile_user.update_password', compact(
            'title',
        ));
    }

    public function update_password(Request $request)
    {
        $data = auth()->user();
        $cek_password = Hash::check($request->old_password, $data->password);
        $request->validate([
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Password lama salah!');
                    }
                },
            ],
            'password' => 'confirmed|min:4',
        ]);
        if ($cek_password) {
            if ($request->password == $request->password_confirmation) {
                $save = $data->update([
                    'password' => Hash::make($request->password),
                ]);
            }
        }

        activity()->log('mengubah password');

        if ($save) {
            return response()->json([
                'data' => $data,
                'text' => 'Password user berhasil diubah!'
            ], 200);
        }
    }
}
