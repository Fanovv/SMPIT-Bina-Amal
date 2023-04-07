<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data 2 tahun lalu berhasil di hapus';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Hitung tanggal 2 tahun yang lalu
        $dateLimit = date('Y', strtotime('-2 year'));

        // Hapus data dengan tanggal kurang dari $dateLimit
        $check = Attendance::where('date', 'LIKE', '%' . $dateLimit . '%')->delete();

        // Tampilkan pesan hasil penghapusan data
        $this->info('Berhasil menghapus ' . $check . ' data.');

        Log::info('Data 2 tahun lalu berhasil di hapus');
    }
}
