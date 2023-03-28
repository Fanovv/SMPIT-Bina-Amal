<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public static function attendanceEvent()
    {
        $users = DB::table('students')->select('id')->get();

        foreach ($users as $user) {
            $attendance = new Attendance([
                'student_id' => $user->id,
                'date' => Carbon::now()->format('Y-m-d'),
            ]);

            $attendance->save();

            Log::info('Attendance record created for user ' . $user->id);
        }
    }
}
