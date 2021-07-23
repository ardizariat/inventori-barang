<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $data = User::query();
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

  public function destroy(Request $request, $id)
  {
    $user = User::findOrFail($id);
    if ($user->foto) {
      Storage::delete('user/' . $user->foto);
    }
    $delete = $user->destroy();
    if ($delete) {
      return response()->json([
        'text' => 'Produk berhasil dihapus!'
      ], 200);
    }
  }
}
