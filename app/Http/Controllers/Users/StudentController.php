<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function showAddStudent()
    {
        return view('student.addStudent', ['title' => 'Management Murid']);
    }

    public function checkKelas(Request $request)
    {
        $kelas = $request->input('kelas');
        $exists = Kelas::where('class_name', 'LIKE', '%' . $kelas . '%')->exists();
        return response()->json([
            'exists' => $exists
        ]);
    }

    private function getUserID($name)
    {
        return User::where('name', 'LIKE', '%' . $name . '%')->firstOrFail()->id;
    }

    public function store(Request $request)
    {
        $kelasName = $request->input('kelas');
        $kelas = Kelas::where('class_name', 'LIKE', '%' . $kelasName . '%')->first();

        $waliRule = $kelas ? 'nullable' : 'required';

        $validateData = $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'wali_1' => $waliRule,
            'wali_2' => 'nullable'
        ]);

        if (!$kelas && isset($request->wali_2)) {
            $kelas = Kelas::create([
                'class_name' => $validateData['kelas'],
                'wali_1' => $this->getUserID($request->input('wali_1')),
                'wali_2' => $this->getUserID($request->input('wali_2'))
            ]);
        } else if (!$kelas) {
            $kelas = Kelas::create([
                'class_name' => $validateData['kelas'],
                'wali_1' => $this->getUserID($request->input('wali_1')),
                'wali_2' => null
            ]);
        }

        $validateData['kelas'] = $kelas->id;

        $createStudent = Students::create($validateData);

        return redirect('/admin/student/addStudent')->with($createStudent ? ['success' => 'Data Berhasil Ditambah'] : ['fail' => 'Data Gagal Ditambah']);
    }
}
