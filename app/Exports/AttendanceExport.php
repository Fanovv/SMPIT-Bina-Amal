<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Students;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromView, WithStyles, ShouldAutoSize
{
    use Exportable;

    private $id;
    private $tanggal;
    private $nama;

    public function __construct($id, $tanggal, $nama)
    {
        $this->id = $id;
        $this->tanggal = $tanggal;
        $this->nama = $nama;
    }

    public function view(): View
    {
        return view('sholat.excelSholat', [
            'nama' => $this->nama,
            'datas' => Attendance::where('student_id', $this->id)->where('date', $this->tanggal)->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells("A1:G1");

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
