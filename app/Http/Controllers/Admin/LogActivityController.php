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
        $user = auth()->user();
        $id = auth()->user()->id;

        if (request()->ajax()) {
            if ($user->hasRole('super-admin')) {
                $data = ActivityLog::query()->latest();
            } elseif ($user->hasRole('admin')) {
                $data = ActivityLog::whereNotIn('causer_id', [1])->get();
            } else {
                $data = ActivityLog::where('causer_id', '=', $user->id)->get();
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
                    return $data->created_at->format('d M Y, H:i:s');
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
