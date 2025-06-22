<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carbon::setLocale('id');

        // Jadwal Mata Kuliah Umum - Dosen 1
        Jadwal::create([
            'matakuliah_id' => 1, // Pemrograman Dasar
            'dosen_id' => 1,
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab 1',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 1, // Pemrograman Dasar
            'dosen_id' => 1,
            'hari' => 'Senin',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:30:00',
            'ruangan' => 'Lab 2',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 1, // Pemrograman Dasar
            'dosen_id' => 1,
            'hari' => 'Senin',
            'jam_mulai' => '16:00:00',
            'jam_selesai' => '18:30:00',
            'ruangan' => 'Lab 3',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'aktif' => true,
        ]);

        // Jadwal Algoritma dan Struktur Data - Dosen 2
        Jadwal::create([
            'matakuliah_id' => 2, // Algoritma dan Struktur Data
            'dosen_id' => 2,
            'hari' => 'Selasa',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab 1',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 2, // Algoritma dan Struktur Data
            'dosen_id' => 2,
            'hari' => 'Selasa',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:30:00',
            'ruangan' => 'Lab 2',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'aktif' => true,
        ]);

        // Jadwal Basis Data - Dosen 3
        Jadwal::create([
            'matakuliah_id' => 3, // Basis Data
            'dosen_id' => 3,
            'hari' => 'Rabu',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab 1',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 3, // Basis Data
            'dosen_id' => 3,
            'hari' => 'Rabu',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:30:00',
            'ruangan' => 'Lab 2',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'aktif' => true,
        ]);

        // Jadwal Khusus TIF - Dosen 1
        Jadwal::create([
            'matakuliah_id' => 4, // Pemrograman Web
            'dosen_id' => 1,
            'hari' => 'Kamis',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab 1',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 5, // Pemrograman Mobile
            'dosen_id' => 1,
            'hari' => 'Kamis',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:30:00',
            'ruangan' => 'Lab 1',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'aktif' => true,
        ]);

        // Jadwal Khusus TKK - Dosen 2
        Jadwal::create([
            'matakuliah_id' => 7, // Arsitektur Komputer
            'dosen_id' => 2,
            'hari' => 'Jumat',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab 2',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 8, // Sistem Operasi
            'dosen_id' => 2,
            'hari' => 'Jumat',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:30:00',
            'ruangan' => 'Lab 2',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'aktif' => true,
        ]);

        // Jadwal Khusus MIF - Dosen 3
        Jadwal::create([
            'matakuliah_id' => 10, // Sistem Informasi Manajemen
            'dosen_id' => 3,
            'hari' => 'Sabtu',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab 3',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'aktif' => true,
        ]);

        Jadwal::create([
            'matakuliah_id' => 11, // Analisis dan Perancangan Sistem
            'dosen_id' => 3,
            'hari' => 'Sabtu',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:30:00',
            'ruangan' => 'Lab 3',
            'semester' => '6',
            'tahun_akademik' => '2023/2024',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'aktif' => true,
        ]);

        $this->command->info('Jadwal berhasil di-seed dengan prodi yang konsisten (TIF, TKK, MIF).');
    }
}
