<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Presensi;
use Carbon\Carbon;

class MarkAbsencesAsAlphaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:mark-alpha';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cari mahasiswa yang tidak presensi dan tandai sebagai alpha setelah jam selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses penandaan Alpha...');

        Carbon::setLocale('id');
        $todayName = Carbon::now()->translatedFormat('l');
        $now = Carbon::now()->format('H:i:s');

        // Ambil semua jadwal aktif untuk hari ini yang jam selesainya sudah lewat
        $jadwalSelesai = Jadwal::where('hari', $todayName)
            ->where('aktif', true)
            ->whereTime('jam_selesai', '<=', $now)
            ->with('mahasiswa') // Eager load mahasiswa yang terdaftar
            ->get();

        if ($jadwalSelesai->isEmpty()) {
            $this->info('Tidak ada jadwal yang telah selesai untuk diproses saat ini.');
            return;
        }

        $alphaCount = 0;

        foreach ($jadwalSelesai as $jadwal) {
            // Dapatkan ID semua mahasiswa yang seharusnya presensi
            $mahasiswaTerdaftarIds = $jadwal->mahasiswa->pluck('id');

            // Dapatkan ID semua mahasiswa yang sudah presensi (hadir, sakit, izin)
            $mahasiswaSudahPresensiIds = Presensi::where('jadwal_id', $jadwal->id)
                ->where('tanggal', today())
                ->pluck('mahasiswa_id');

            // Cari mahasiswa yang belum presensi
            $mahasiswaAlphaIds = $mahasiswaTerdaftarIds->diff($mahasiswaSudahPresensiIds);

            if ($mahasiswaAlphaIds->isNotEmpty()) {
                foreach ($mahasiswaAlphaIds as $mahasiswaId) {
                    // Gunakan updateOrCreate untuk mencegah duplikasi jika command berjalan > 1 kali
                    Presensi::updateOrCreate(
                        [
                            'jadwal_id' => $jadwal->id,
                            'mahasiswa_id' => $mahasiswaId,
                            'tanggal' => today(),
                        ],
                        [
                            'waktu_presensi' => $jadwal->jam_selesai,
                            'status' => 'alpha',
                            'keterangan' => 'Tidak melakukan presensi hingga batas waktu.',
                        ]
                    );
                    $alphaCount++;
                }
                $this->info("Jadwal '{$jadwal->matakuliah->nama}' diproses, {$mahasiswaAlphaIds->count()} mahasiswa ditandai Alpha.");
            }
        }

        $this->info("Proses selesai. Total {$alphaCount} mahasiswa telah ditandai Alpha.");
    }
}
