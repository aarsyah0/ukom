<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'display_name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'dosen', 'display_name' => 'Dosen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mahasiswa', 'display_name' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
