<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TataUsahaController extends Controller
{
    public function index()
    {
        return view('tu.dashboard', [
            "title" => "Dashboard",
            "kelas" => Kelas::count(),
            "murid" => Students::count(),
            "nama" => Auth::user(),
        ]);
    }
}
