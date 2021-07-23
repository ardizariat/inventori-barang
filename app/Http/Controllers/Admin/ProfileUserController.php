<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    public function index()
    {
        $title = 'Detail Profile';
        $user = Auth::user();
        return view('admin.profile_user.index', compact('user', 'title'));
    }
}
