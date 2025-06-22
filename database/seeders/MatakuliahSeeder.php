<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matakuliah;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mata Kuliah Umum
        Matakuliah::create([
            'kode' => 'TI101',
            'nama' => 'Pemrograman Dasar',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah dasar pemrograman menggunakan bahasa C++'
        ]);

        Matakuliah::create([
            'kode' => 'TI102',
            'nama' => 'Algoritma dan Struktur Data',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah algoritma dan struktur data dasar'
        ]);

        Matakuliah::create([
            'kode' => 'TI103',
            'nama' => 'Basis Data',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah sistem basis data dan SQL'
        ]);

        // Mata Kuliah TIF (Teknik Informatika)
        Matakuliah::create([
            'kode' => 'TIF201',
            'nama' => 'Pemrograman Web',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah pemrograman web menggunakan HTML, CSS, JavaScript'
        ]);

        Matakuliah::create([
            'kode' => 'TIF202',
            'nama' => 'Pemrograman Mobile',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah pengembangan aplikasi mobile'
        ]);

        Matakuliah::create([
            'kode' => 'TIF203',
            'nama' => 'Jaringan Komputer',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah dasar jaringan komputer dan protokol'
        ]);

        // Mata Kuliah TKK (Teknik Komputer)
        Matakuliah::create([
            'kode' => 'TKK201',
            'nama' => 'Arsitektur Komputer',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah arsitektur dan organisasi komputer'
        ]);

        Matakuliah::create([
            'kode' => 'TKK202',
            'nama' => 'Sistem Operasi',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah sistem operasi dan manajemen proses'
        ]);

        Matakuliah::create([
            'kode' => 'TKK203',
            'nama' => 'Mikrokontroler',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah pemrograman mikrokontroler'
        ]);

        // Mata Kuliah MIF (Manajemen Informatika)
        Matakuliah::create([
            'kode' => 'MIF201',
            'nama' => 'Sistem Informasi Manajemen',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah sistem informasi untuk manajemen'
        ]);

        Matakuliah::create([
            'kode' => 'MIF202',
            'nama' => 'Analisis dan Perancangan Sistem',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah analisis dan perancangan sistem informasi'
        ]);

        Matakuliah::create([
            'kode' => 'MIF203',
            'nama' => 'Manajemen Proyek TI',
            'sks' => 3,
            'deskripsi' => 'Mata kuliah manajemen proyek teknologi informasi'
        ]);
    }
}
