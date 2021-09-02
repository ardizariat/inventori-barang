<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class FEController extends Controller
{
    public function index()
    {
        return view('fe.index');
    }
}
