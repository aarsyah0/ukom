<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Dosen extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'dosen';
    protected $fillable = [
        'nip', 'nama', 'email', 'password', 'no_hp', 'alamat'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function presensi()
    {
        return $this->hasManyThrough(Presensi::class, Jadwal::class);
    }
}
