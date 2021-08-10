<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Riwayat Aktifitas User';
        $super_admin = auth()->user()->hasRole("super-admin");
        $admin = auth()->user()->hasRole("admin");
        $user = auth()->user()->hasRole("user");
        $id = auth()->user()->id;

        if (request()->ajax()) {
            if ($super_admin == true) {
                $data = ActivityLog::query()->latest();
            }
            if ($admin == true || $user == true) {
                $data = ActivityLog::where('causer_id', '=', $id)
                    ->latest()
                    ->get();
            }
            return datatables()
                ->of($data)
                ->addColumn('name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->user->email;
                })
                ->addColumn('waktu', function ($data) {
                    return $data->created_at->format('d-m-Y, H:i');
                })
                ->addColumn('aktifitas', function ($data) {
                    return view('admin.activity_log._descriptions', [
                        'data' => $data
                    ]);
                })
                ->rawColumns(['name', 'waktu', 'email', 'aktifitas'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.activity_log.index', compact('title'));
    }
}
