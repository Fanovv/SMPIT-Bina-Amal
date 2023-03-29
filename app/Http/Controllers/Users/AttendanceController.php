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
        $murid = Students::where('kelas', $id_kelas)->orderBy('nama', 'ASC')->get();
        $kelas = Kelas::where('id', $id_kelas)->value('class_name');
        $sholat = Attendance::where('student_id', $murid->first()->id)->where('date', Carbon::now())->first();

        dd($sholat);
        return view('sholat.absenSholat', [
            "title" => 'Absen Sholat',
            "data" => $murid,
            "kelas" => $kelas,
            "student_id" => $murid->first()->id,
            "sholat" => $sholat
        ]);
    }
}
