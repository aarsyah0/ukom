<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $fillable = [
        'jadwal_id', 'mahasiswa_id', 'tanggal', 'waktu_presensi',
        'status', 'keterangan', 'latitude', 'longitude', 'file_bukti'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_presensi' => 'datetime:H:i:s',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
