<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim', 'nama', 'email', 'password', 'jurusan', 'prodi', 'semester', 'no_hp', 'alamat'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function jadwal()
    {
        return $this->belongsToMany(Jadwal::class, 'kelas');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
}
