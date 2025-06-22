<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'nip' => '19850101001',
            'nama' => 'Dr. Ahmad Rizki, S.Kom., M.Kom.',
            'email' => 'ahmad.rizki@teknologi.test',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Teknologi No. 1, Surabaya'
        ]);

        Dosen::create([
            'nip' => '19860202002',
            'nama' => 'Siti Nurhaliza, S.T., M.T.',
            'email' => 'siti.nurhaliza@teknologi.test',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Teknologi No. 2, Surabaya'
        ]);

        Dosen::create([
            'nip' => '19870303003',
            'nama' => 'Budi Santoso, S.Kom., M.Sc.',
            'email' => 'budi.santoso@teknologi.test',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Teknologi No. 3, Surabaya'
        ]);
    }
}
