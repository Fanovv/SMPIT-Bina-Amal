<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Students;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExport implements FromView, WithStyles, ShouldAutoSize
{
    use Exportable;

    private $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
     
        $startDate = date('Y-m-d', strtotime($this->tahun.'-07-01'));
        $endDate = date('Y-m-d', strtotime('+1 year', strtotime($this->tahun.'-06-30')));
        
        $dataSholat = Attendance::select('attendances.*', 'students.nama', 'classes.class_name')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('classes', 'attendances.class_id', '=', 'classes.id')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('class_id', 'ASC')->orderBy('date', 'ASC')
            ->get();
        
         $namaSiswa = null;
         $namaKelas = null;
        
        if (!$dataSholat->isEmpty()) {
            $namaSiswa = Students::where('id', $dataSholat->first()->student_id)->value('nama');
            $namaKelas = Kelas::where('id', $dataSholat->first()->class_id)->value('class_name');
        }
        
        return view('sholat.excelSholat', [
            'nama' => 'Tahun : ' . $this->tahun . '/' . ($this->tahun + 1),
            'siswa' => $namaSiswa,
            'kelas' => $namaKelas,
            'datas' => $dataSholat,
            'nama_kelas' => null
        ]);

    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells("A1:J1");

        $styles = [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
        ];

        $startDate = date('Y-m-d', strtotime($this->tahun.'-07-01'));
        $endDate = date('Y-m-d', strtotime('+1 year', strtotime($this->tahun.'-06-30')));

        $data = Attendance::select('attendances.*', 'students.nama', 'classes.class_name')
        ->join('students', 'attendances.student_id', '=', 'students.id')
        ->join('classes', 'attendances.class_id', '=', 'classes.id')
        ->whereBetween('date', [$startDate, $endDate])
        ->orderBy('class_id', 'ASC')->orderBy('date', 'ASC')
        ->get();

        foreach ($data as $index => $row) {
            $styles[$index + 3] = [
                'font' => [
                    'size' => 10,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ];
        }

        return $styles;
    }
}
