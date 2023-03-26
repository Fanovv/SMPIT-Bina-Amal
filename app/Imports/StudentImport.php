<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Students;
use App\Models\User;
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
        $validator = Validator::make($row, [
            'nama_siswa' => 'required',
            'nomor_induk_siswa' => 'required|unique:students,nis',
            'nama_kelas' => 'required',
            'nama_wali_1' => 'nullable',
            'nama_wali_2' => 'nullable',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        $kelasName = $row['nama_kelas'];
        $kelas = Kelas::where('class_name', 'LIKE', '%' . $kelasName . '%')->first();

        if (!$kelas) {
            $kelas = Kelas::create([
                'class_name' => $row['nama_kelas'],
                'wali_1' => $this->getUserID($row['nama_wali_1']),
                'wali_2' => $row['nama_wali_2'] ? $this->getUserID($row['nama_wali_2']) : null,
            ]);
        }

        return new Students([
            'nama' => $row['nama_siswa'],
            'nis' => $row['nomor_induk_siswa'],
            'kelas' => $kelas->id
        ]);
    }

    private function getUserID($name)
    {
        $user = User::where('name', 'LIKE', '%' . $name . '%')->first();
        if (!$user) {
            throw new \InvalidArgumentException('User tidak ada: ' . $name);
        }

        return $user->id;
    }
}
