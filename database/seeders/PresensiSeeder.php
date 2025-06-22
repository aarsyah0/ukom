<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $today = now()->toDateString();
        $mahasiswas = Mahasiswa::all();
        $jadwals = Jadwal::all();

        foreach ($mahasiswas as $mahasiswa) {
            // Ambil jadwal yang berelasi dengan mahasiswa (melalui kelas)
            $jadwalIds = DB::table('kelas')
                ->where('mahasiswa_id', $mahasiswa->id)
                ->pluck('jadwal_id');

            foreach ($jadwalIds as $jadwalId) {
                // Cek apakah sudah ada presensi hari ini
                $sudahPresensi = Presensi::where('jadwal_id', $jadwalId)
                    ->where('mahasiswa_id', $mahasiswa->id)
                    ->where('tanggal', $today)
                    ->exists();
                if (!$sudahPresensi) {
                    Presensi::create([
                        'jadwal_id' => $jadwalId,
                        'mahasiswa_id' => $mahasiswa->id,
                        'tanggal' => $today,
                        'waktu_presensi' => now(),
                        'status' => 'hadir',
                        'keterangan' => 'Seeder',
                    ]);
                }
            }
        }
    }
}
