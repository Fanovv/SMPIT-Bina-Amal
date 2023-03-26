<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TataUsahaController extends Controller
{
    public function index()
    {
        return view('tu.dashboard', ["title" => "Dashboard",]);
    }
}
