<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Kelas([
            'class_name' => $row['nama_kelas'],
            'wali_1' => $row['nama_wali_1'] ? $this->getUserID($row['nama_wali_1']) : User::where('level', 'wali')->firstOrFail()->id,
            'wali_2' => $row['nama_wali_2'] ? $this->getUserID($row['nama_wali_2']) : null,
        ]);
    }

    private function getUserID($name)
    {
        $user = User::where('name', 'LIKE', '%' . $name . '%')->firstOrFail()->id;
        if (!$user) {
            return User::where('level', 'wali')->firstOrFail()->id;
        }

        return $user;
    }
}
