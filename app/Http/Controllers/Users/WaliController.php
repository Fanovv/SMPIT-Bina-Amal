<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('wali_1', Auth::user()->id)->orWhere('wali_2', Auth::user()->id)->get();

        $jumlah_kelas = $kelas->count();

        $jumlah_murid = Students::whereIn('kelas', $kelas->pluck('id'))->count();

        return view('Wali.dashboard', [
            "title" => "Dashboard",
            "kelas" => $jumlah_kelas,
            "murid" => $jumlah_murid,
            "nama" => Auth::user(),
        ]);
    }
}
