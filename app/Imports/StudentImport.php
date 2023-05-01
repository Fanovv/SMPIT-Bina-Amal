<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $kelasName = $row['nama_kelas'];
        $kelas = Kelas::where('class_name', 'LIKE', '%' . $kelasName . '%')->first();

        if (!$kelas) {
            $kelas = Kelas::create([
                'class_name' => $row['nama_kelas'],
                'wali_1' => $row['nama_wali_1'] ? $this->getUserID($row['nama_wali_1']) : User::where('level', 'wali')->firstOrFail()->id,
                'wali_2' => $row['nama_wali_2'] ? $this->getUserID($row['nama_wali_2']) : null,
            ]);
        }

        $student = new Students([
            'nama' => $row['nama_siswa'],
            'nis' => $row['nomor_induk_siswa'],
            'kelas' => $kelas->id
        ]);
    
        $student->save();
    
        $attendance = new Attendance([
            'student_id' => $student->id,
            'class_id' => $kelas->id,
            'date' => Carbon::now()->format('Y-m-d'),
        ]);
    
        $attendance->save();
    
        return $student;
    }

    private function getUserID($name)
    {
        $user = User::where('name', 'LIKE', '%' . $name . '%')->first();
        if (!$user) {
            return User::where('level', 'wali')->firstOrFail()->id;
        }

        return $user->id;
    }
}
