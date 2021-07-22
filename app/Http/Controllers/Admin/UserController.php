<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Detail Profile';
        $user = Auth::user();
        return view('admin.user.index', compact('user', 'title'));
    }
}
