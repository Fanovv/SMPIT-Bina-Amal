<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // $sholat = Attendance::where('student_id', $murid->first()->id)->where('date', Carbon::now())->first();

        // dd($murid);
        return view('sholat.absenSholat', [
            "title" => 'Absen Sholat',
            "data" => $murid,
            "kelas" => $kelas,
            "nama" => $nama
            // "sholat" => $sholat
        ]);
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
}
