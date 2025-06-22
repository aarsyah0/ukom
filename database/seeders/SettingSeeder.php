<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'kampus_lat', 'value' => '-6.175392'], // Monas Latitude
            ['key' => 'kampus_lon', 'value' => '106.827153'], // Monas Longitude
            ['key' => 'kampus_radius', 'value' => '100'], // 100 meters
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
