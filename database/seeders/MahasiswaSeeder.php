<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mahasiswa TIF (Teknik Informatika)
        Mahasiswa::create([
            'nim' => '2021101001',
            'nama' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'semester' => '6',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Mahasiswa TIF No. 1, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021101002',
            'nama' => 'Siti Aisyah',
            'email' => 'siti.aisyah@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'semester' => '6',
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Mahasiswa TIF No. 2, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021101003',
            'nama' => 'Muhammad Rizki',
            'email' => 'muhammad.rizki@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'semester' => '6',
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Mahasiswa TIF No. 3, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021101004',
            'nama' => 'Nurul Hidayah',
            'email' => 'nurul.hidayah@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TIF',
            'semester' => '6',
            'no_hp' => '081234567893',
            'alamat' => 'Jl. Mahasiswa TIF No. 4, Surabaya'
        ]);

        // Mahasiswa TKK (Teknik Komputer)
        Mahasiswa::create([
            'nim' => '2021102001',
            'nama' => 'Budi Prasetyo',
            'email' => 'budi.prasetyo@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'semester' => '6',
            'no_hp' => '081234567894',
            'alamat' => 'Jl. Mahasiswa TKK No. 1, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021102002',
            'nama' => 'Dewi Sartika',
            'email' => 'dewi.sartika@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'semester' => '6',
            'no_hp' => '081234567895',
            'alamat' => 'Jl. Mahasiswa TKK No. 2, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021102003',
            'nama' => 'Eko Prasetyo',
            'email' => 'eko.prasetyo@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'TKK',
            'semester' => '6',
            'no_hp' => '081234567896',
            'alamat' => 'Jl. Mahasiswa TKK No. 3, Surabaya'
        ]);

        // Mahasiswa MIF (Manajemen Informatika)
        Mahasiswa::create([
            'nim' => '2021103001',
            'nama' => 'Fitri Handayani',
            'email' => 'fitri.handayani@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'semester' => '6',
            'no_hp' => '081234567897',
            'alamat' => 'Jl. Mahasiswa MIF No. 1, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021103002',
            'nama' => 'Gunawan Setiawan',
            'email' => 'gunawan.setiawan@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'semester' => '6',
            'no_hp' => '081234567898',
            'alamat' => 'Jl. Mahasiswa MIF No. 2, Surabaya'
        ]);

        Mahasiswa::create([
            'nim' => '2021103003',
            'nama' => 'Hesti Wulandari',
            'email' => 'hesti.wulandari@teknologi.test',
            'password' => Hash::make('password123'),
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'MIF',
            'semester' => '6',
            'no_hp' => '081234567899',
            'alamat' => 'Jl. Mahasiswa MIF No. 3, Surabaya'
        ]);
    }
}
