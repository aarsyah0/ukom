<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel kelas terlebih dahulu
        DB::table('kelas')->truncate();

        $totalCreated = 0;

        // Ambil semua mahasiswa
        $mahasiswa = Mahasiswa::all();

        if ($mahasiswa->isEmpty()) {
            $this->command->info('Tidak ada mahasiswa untuk di-seed ke dalam kelas.');
            return;
        }

        // Ambil semua jadwal
        $jadwal = Jadwal::all();

        if ($jadwal->isEmpty()) {
            $this->command->info('Tidak ada jadwal untuk di-seed ke dalam kelas.');
            return;
        }

        // Daftarkan mahasiswa ke jadwal yang sesuai (jurusan, prodi, semester sama)
        foreach ($mahasiswa as $mhs) {
            $matchingJadwal = $jadwal->filter(function($jdl) use ($mhs) {
                return $jdl->jurusan === $mhs->jurusan &&
                       $jdl->prodi === $mhs->prodi &&
                       $jdl->semester === $mhs->semester;
            });

            if ($matchingJadwal->isNotEmpty()) {
                foreach ($matchingJadwal as $jdl) {
                    Kelas::create([
                        'mahasiswa_id' => $mhs->id,
                        'jadwal_id' => $jdl->id,
                    ]);
                    $totalCreated++;
                }

                $this->command->info("Mahasiswa {$mhs->nama} ({$mhs->prodi} S{$mhs->semester}) didaftarkan ke {$matchingJadwal->count()} jadwal");
            } else {
                $this->command->info("Tidak ada jadwal yang sesuai untuk mahasiswa {$mhs->nama} ({$mhs->prodi} S{$mhs->semester})");
            }
        }

        if ($totalCreated > 0) {
            $this->command->info("Total {$totalCreated} pendaftaran kelas berhasil dibuat.");
        } else {
            $this->command->info('Tidak ada data yang dapat di-seed. Pastikan ada kecocokan jurusan, prodi, dan semester antara mahasiswa dan jadwal.');
        }
    }
}
