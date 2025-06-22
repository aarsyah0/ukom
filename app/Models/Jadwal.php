<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $fillable = [
        'dosen_id', 'matakuliah_id', 'hari', 'jam_mulai', 'jam_selesai',
        'ruangan', 'semester', 'tahun_akademik', 'jurusan', 'prodi', 'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'kelas');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
}
