<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $title = 'Pengguna';
    $status = $request->status;
    if (request()->ajax()) {
      if (!empty($status)) {
        $data = User::where('status', '=', $status)
          ->get();
      } else {
        $data = User::query()->orderBy('created_at', 'desc');
      }
      return datatables()->of($data)
        ->addColumn('dibuat', function ($data) {
          $data = Carbon::parse($data->created_at)->format('d F Y, H:i');
          return $data;
        })
        ->addColumn('status', function ($data) {
          return view('admin.user._status', [
            'data' => $data
          ]);
        })
        ->addColumn('role', function ($data) {
          return print_r($data->getRoleNames()[0], 1);
        })
        ->rawColumns(['dibuat', 'status', 'role'])
        ->addIndexColumn()
        ->make(true);
    }
    return view('admin.user.index', compact(
      'title'
    ));
  }

  public function create()
  {
    $title = 'Tambah User';
    $permissions = DB::table('permissions')
      ->select('name')
      ->get();
    $roles = DB::table('roles')
      ->select('name')
      ->get();
    return view('admin.user.create', compact(
      'title',
      'permissions',
      'roles'
    ));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'username' => 'required|unique:users,username',
      'email' => 'required|unique:users,email',
      'role' => 'required',
    ]);

    $role = $request->role;
    $name = $request->name;
    $username = $request->username;
    $email = $request->email;
    $permissions = $request->permissions;

    $user = new User();
    $user->name = $name;
    $user->username = $username;
    $user->email = $email;
    $user->password = bcrypt('admin');
    $user->save();
    if (isset($role)) {
      $user->assignRole($role);
    }
    if (isset($permissions)) {
      $user->givePermissionTo($permissions);
    }
    return response()->json([
      'text' => "user berhasil ditambahkan",
      'data' => $user
    ], 201);
  }
}
