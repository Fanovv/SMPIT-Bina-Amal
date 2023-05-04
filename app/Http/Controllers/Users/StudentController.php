<?php

namespace App\Http\Controllers\Users;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentController extends Controller
{
    public function showAddStudent()
    {
        if (Auth::user()->level == 'admin') {
            return view('student.addStudent', ['title' => 'Management Murid']);
        } else if (Auth::user()->level == 'tu') {
            return view('tu.addStudent', ['title' => 'Management Murid']);
        }
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

        if($createStudent){
            $attendance = new Attendance([
                'student_id' => $createStudent->id,
                'class_id' => $createStudent->kelas,
                'date' => Carbon::now()->format('Y-m-d'),
            ]);          
            $attendance->save();
            
            if (Auth::user()->level == 'admin') {
                return redirect('/admin/student')->with(['success' => 'Data Berhasil Ditambah']);
            } else if (Auth::user()->level == 'tu') {
                return redirect('/tatausaha/student')->with(['success' => 'Data Berhasil Ditambah']);
            }
        }else{
            if (Auth::user()->level == 'admin') {
                return redirect('/admin/student')->with($createStudent ? ['success' => 'Data Berhasil Ditambah'] : ['fail' => 'Data Gagal Ditambah']);
            } else if (Auth::user()->level == 'tu') {
                return redirect('/tatausaha/student')->with($createStudent ? ['success' => 'Data Berhasil Ditambah'] : ['fail' => 'Data Gagal Ditambah']);
            }
        }
    }

    public function showImport()
    {
        return view('student.importStudent', ['title' => 'Management Murid']);
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file_murid' => 'required|mimes:csv,xls,xlsx',
        ]);

        $file = $request->file('file_murid');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_murid', $nama_file);
        $check = Excel::import(new StudentImport, public_path('/file_murid/' . $nama_file));
        unlink(public_path('/file_murid/' . $nama_file));

        if (Auth::user()->level == 'admin') {
            return redirect()->route('student.showAddStudent')->with($check ? ['success' => 'Data berhasil diimport'] : ['fail' => 'Data gagal diimport']);
        } else if (Auth::user()->level == 'tu') {
            return redirect()->route('tu.student.showAddStudent')->with($check ? ['success' => 'Data berhasil diimport'] : ['fail' => 'Data gagal diimport']);
        }
    }

    public function showKelas()
    {
        return view('student.showKelas', [
            "title" => "Management Murid",
            "data" => Kelas::orderBy('class_name', 'ASC')->get()
        ]);
    }

    public function manageStudent($id_kelas)
    {
        $murid = Students::where('kelas', $id_kelas)->orderBy('nama', 'ASC')->get();
        $kelas = Kelas::where('id', $id_kelas)->value('class_name');

        return view('student.manageStudent', [
            "title" => "Management Murid",
            "data" => $murid,
            "kelas" => $kelas,
            "tgl" => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function editStudent($id_kelas, $id_murid)
    {
        $murid = Students::where('kelas', $id_kelas)->where('id', $id_murid)->firstOrFail();
        $kelas = Kelas::where('id', $id_kelas)->value('class_name');

        return view('student.editStudent', [
            "title" => "Management Murid",
            "data" => $murid,
            "kelas" => $kelas,
            "id_murid" => $id_murid,
            "id_kelas" => $id_kelas
        ]);
    }

    public function updateStudent(Request $request, $id_murid)
    {
        $id_kelas = Students::where('id', $id_murid)->value('kelas');
        $check = DB::table('students')->where('id', $id_murid)->update([
            'nama' => $request->nama,
        ]);
        if (Auth::user()->level == 'admin') {
            return redirect()->route('student.manageStudent', ['id_kelas' => $id_kelas])->with($check ? ['success' => 'Data berhasil diganti'] : ['fail' => 'Data gagal diganti']);
        } else if (Auth::user()->level == 'tu') {
            return redirect()->route('tu.student.manageStudent', ['id_kelas' => $id_kelas])->with($check ? ['success' => 'Data berhasil diganti'] : ['fail' => 'Data gagal diganti']);
        }
    }

    public function destroyStudent(Students $id_murid)
    {
        $check = Students::where('id', $id_murid->id)->delete();
        return redirect()->back()->with($check ? ['success' => 'Data berhasil dihapus'] : ['fail' => 'Data gagal dihapus']);
    }

    public function checkNIS(Request $request)
    {
        $nis = $request->input('nis');
        $exists = Students::where('nis', 'LIKE', '%' . $nis . '%')->exists();
        return response()->json([
            'exists' => $exists
        ]);
    }

    public function exportStudent($student_id, Request $request)
    {
        $tanggal = $request->input('tanggal');
        $dateTime = new DateTime($tanggal);
        $bulanTahun = $dateTime->format('Y-m');
        $nama = Students::where('id', $student_id)->value('nama');
        $nama_kelas = Students::where('id', $student_id)->value('kelas');

        return Excel::download(new AttendanceExport($student_id, $bulanTahun, $nama, $nama_kelas), $nama . '-' . $bulanTahun . '.xlsx');
    }
}