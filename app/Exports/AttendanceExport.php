<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Kelas;
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
    private $nama_kelas;

    public function __construct($id, $tanggal, $nama, $nama_kelas)
    {
        $this->id = $id;
        $this->tanggal = $tanggal;
        $this->nama = $nama;
        $this->nama_kelas = $nama_kelas;
    }

    public function view(): View
    {
        return view('sholat.excelSholat', [
            'nama' => $this->nama,
            'siswa' => null,
            'kelas' => null,
            'nama_kelas' => Kelas::where('id', $this->nama_kelas)->value('class_name'),
            'datas' => Attendance::where('student_id', $this->id)->where('date', 'LIKE', '%' . $this->tanggal . '%')->orderBy('date', 'ASC')->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells("A1:H1");

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

        $data = Attendance::where('student_id', $this->id)->where('date', 'LIKE', '%' . $this->tanggal . '%')->orderBy('date', 'ASC')->get();

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
