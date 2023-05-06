<?php

namespace App\Http\Controllers\Users;

use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public static function attendanceEvent()
    {
        $users = DB::table('students')
            ->join('classes', 'students.kelas', '=', 'classes.id')
            ->select('students.id', 'classes.id as class_id')
            ->get();

        foreach ($users as $user) {

            $attendance = new Attendance([
                'student_id' => $user->id,
                'class_id' => $user->class_id,
                'date' => Carbon::now()->format('Y-m-d'),
            ]);

            $attendance->save();

            Log::info('Attendance record created for user ' . $user->id);
        }
    }

    public function showKelas()
    {
        if (Auth::user()->level == 'wali') {
            return view('sholat.showKelas', [
                "title" => "Absen Sholat",
                "data" => Kelas::where('wali_1', Auth::user()->id)->orWhere('wali_2', Auth::user()->id)->orderBy('class_name', 'ASC')->get()
            ]);
        }

        return view('sholat.showKelas', [
            "title" => "Absen Sholat",
            "data" => Kelas::orderBy('class_name', 'ASC')->get()
        ]);
    }

    public function absenSholat($id_kelas)
    {
        $murid = Attendance::where('class_id', $id_kelas)->where('date', Carbon::now()->format('Y-m-d'))->orderBy('student_id', 'ASC')->get();
        $kelas = Kelas::where('id', $id_kelas)->value('class_name');

        $nama = [];
        foreach ($murid as $m) {
            $student = Students::where('id', $m->student_id)->first();
            $nama[] = $student ? $student->nama : null;
        }

        if (Auth::user()->level == 'admin') {
            return view('sholat.absenSholat', [
                "title" => 'Absen Sholat',
                "data" => $murid,
                "id" => $id_kelas,
                "kelas" => $kelas,
                "nama" => $nama,
                "tgl" => Carbon::now()->format('Y-m-d')
                // "sholat" => $sholat
            ]);
        } else if (Auth::user()->level == 'tu') {
            return view('tu.absenSholat', [
                "title" => 'Absen Sholat',
                "data" => $murid,
                "id" => $id_kelas,
                "kelas" => $kelas,
                "nama" => $nama,
                "tgl" => Carbon::now()->format('Y-m-d')
                // "sholat" => $sholat
            ]);
        } else if (Auth::user()->level == 'wali') {
            return view('Wali.absenSholat', [
                "title" => 'Absen Sholat',
                "data" => $murid,
                "id" => $id_kelas,
                "kelas" => $kelas,
                "nama" => $nama,
                "tgl" => Carbon::now()->format('Y-m-d')
                // "sholat" => $sholat
            ]);
        }
    }

    public function ajaxAbsenSholat(Request $request)
    {
        $id_kelas = $request->input('id');
        $tgl = $request->input('tgl');
        $murid = Attendance::where('class_id', $id_kelas)->where('date', $tgl)->orderBy('student_id', 'ASC')->get();
        $kelas = Kelas::where('id', $id_kelas)->value('class_name');

        $nama = [];
        foreach ($murid as $m) {
            $student = Students::where('id', $m->student_id)->first();
            $nama[] = $student ? $student->nama : null;
        }
        // $sholat = Attendance::where('student_id', $murid->first()->id)->where('date', Carbon::now())->first();

        // dd($murid);
        $response = [];
        for ($i = 0; $i < count($murid); $i++) {
            $response[] = [
                '<td>' . $nama[$i] . '</td>',
                '<td>' . $kelas . '</td>',
                '<td>
                    <a id="subuh" href="#" class="btn ' . ($murid[$i]['subuh'] == 1 ? 'btn-success' : 'btn-danger') . ' prayer-button" data-id="' . $murid[$i]['id'] . '" data-value="' . $murid[$i]['subuh'] . '">
                        ' . ($murid[$i]['subuh'] == 1 ? 'Tepat Waktu' : 'Masbuk/Telat') . '
                    </a>
                </td>',
                '<td>
                    <a id="zuhur" href="#" class="btn ' . ($murid[$i]['zuhur'] == 1 ? 'btn-success' : 'btn-danger') . ' prayer-button" data-id="' . $murid[$i]['id'] . '" data-value="' . $murid[$i]['zuhur'] . '">
                        ' . ($murid[$i]['zuhur'] == 1 ? 'Tepat Waktu' : 'Masbuk/Telat') . '
                    </a>
                </td>',
                '<td>
                    <a id="ashar" href="#" class="btn ' . ($murid[$i]['ashar'] == 1 ? 'btn-success' : 'btn-danger') . ' prayer-button" data-id="' . $murid[$i]['id'] . '" data-value="' . $murid[$i]['ashar'] . '">
                        ' . ($murid[$i]['ashar'] == 1 ? 'Tepat Waktu' : 'Masbuk/Telat') . '
                    </a>
                </td>',
                '<td>
                    <a id="maghrib" href="#" class="btn ' . ($murid[$i]['maghrib'] == 1 ? 'btn-success' : 'btn-danger') . ' prayer-button" data-id="' . $murid[$i]['id'] . '" data-value="' . $murid[$i]['maghrib'] . '">
                        ' . ($murid[$i]['maghrib'] == 1 ? 'Tepat Waktu' : 'Masbuk/Telat') . '
                    </a>
                </td>',
                '<td>
                    <a id="isya" href="#" class="btn ' . ($murid[$i]['isya'] == 1 ? 'btn-success' : 'btn-danger') . ' prayer-button" data-id="' . $murid[$i]['id'] . '" data-value="' . $murid[$i]['isya'] . '">
                        ' . ($murid[$i]['isya'] == 1 ? 'Tepat Waktu' : 'Masbuk/Telat') . '
                    </a>
                </td>',
            ];
        };
        return response()->json($response);
    }

    public function updateSholat(Request $request)
    {
        $id = $request->input('id');
        $value = $request->input('value');
        $button = $request->input('button');

        $prayer = Attendance::findOrFail($id);
        if ($prayer) {
            // Update the prayer value in the database
            if ($value == 0) {
                if ($button == 'subuh') {
                    Attendance::where('id', $id)->update([
                        'subuh' => true
                    ]);
                } else if ($button == 'zuhur') {
                    Attendance::where('id', $id)->update([
                        'zuhur' => true
                    ]);
                } else if ($button == 'ashar') {
                    Attendance::where('id', $id)->update([
                        'ashar' => true
                    ]);
                } else if ($button == 'maghrib') {
                    Attendance::where('id', $id)->update([
                        'maghrib' => true
                    ]);
                } else if ($button == 'isya') {
                    Attendance::where('id', $id)->update([
                        'isya' => true
                    ]);
                }
            } else if ($value == 1) {
                if ($button == 'subuh') {
                    Attendance::where('id', $id)->update([
                        'subuh' => false
                    ]);
                } else if ($button == 'zuhur') {
                    Attendance::where('id', $id)->update([
                        'zuhur' => false
                    ]);
                } else if ($button == 'ashar') {
                    Attendance::where('id', $id)->update([
                        'ashar' => false
                    ]);
                } else if ($button == 'maghrib') {
                    Attendance::where('id', $id)->update([
                        'maghrib' => false
                    ]);
                } else if ($button == 'isya') {
                    Attendance::where('id', $id)->update([
                        'isya' => false
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Prayer not found']);
        }
    }

    public function exportData()
    {
        return view('sholat.exportData', [
            "title" => "Export Data",
            "data" => Attendance::select(DB::raw("DATE_FORMAT(date, '%Y') as month_year"))->groupBy('month_year')->get()
        ]);
    }

    public function exportAllData($tahun)
    {
        return Excel::download(new DataExport($tahun), $tahun . '-' . $tahun + 1 . '.xlsx');
    }

    public function descSholat()
    {
        if (Auth::user()->level == 'admin') {
            return view('desc.descSholat', [
                "title" => "Keterangan Sholat",
                "data" => Kelas::all(),
                "tgl" => Carbon::now()->format('Y-m-d')
            ]);
        } else if (Auth::user()->level == 'tu') {
            return view('tu.descSholat', [
                "title" => "Keterangan Sholat",
                "data" => Kelas::all(),
                "tgl" => Carbon::now()->format('Y-m-d')
            ]);
        } else if (Auth::user()->level == 'wali') {
            return view('wali.descSholat', [
                "title" => "Keterangan Sholat",
                "data" => Kelas::where('wali_1', Auth::user()->id)->orWhere('wali_2', Auth::user()->id)->orderBy('class_name', 'ASC')->get(),
                "tgl" => Carbon::now()->format('Y-m-d')
            ]);
        }
    }

    public function getMurid(Request $request)
    {
        $id_kelas = $request->kelas;

        $murid = Students::where('id', $id_kelas)->get();

        $output = '';
        foreach ($murid as $m) {
            $output .= '<option value="' . $m->id . '">' . $m->nama . '</option>';
        }
        return $output;
    }

    public function updateDesc(Request $request)
    {
        $id_kelas = $request->kelas;
        $id_siswa = $request->murid;
        $tgl = $request->tgl;

        $check = DB::table('attendances')->where('student_id', $id_siswa)->where('class_id', $id_kelas)->where('date', $tgl)->get();

        $update = DB::table('attendances')->where('student_id', $id_siswa)->where('class_id', $id_kelas)->where('date', $tgl)->update([
            'description' => $request->ket
        ]);

        // dd($check);
        if($check->isEmpty()){
            return back()->with($update ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data Tidak Tersedia']);
        }
        return back()->with($update ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
    }
}
