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
        $dataSholat = Attendance::select('attendances.*', 'students.nama', 'classes.class_name')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('classes', 'attendances.class_id', '=', 'classes.id')
            ->where('date', 'LIKE', '%' . $this->tahun . '%')
            ->orderBy('class_id', 'ASC')->orderBy('date', 'ASC')
            ->get();

        return view('sholat.excelSholat', [
            'nama' => 'Tahun : ' . $this->tahun,
            'siswa' => Students::where('id', $dataSholat->first()->student_id)->value('nama'),
            'kelas' => Kelas::where('id', $dataSholat->first()->class_id)->value('class_name'),
            'datas' => $dataSholat
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells("A1:I1");

        return [
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
    }
}
