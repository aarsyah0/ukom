<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';
    protected $fillable = ['kode', 'nama', 'sks', 'semester', 'jurusan', 'prodi', 'deskripsi'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
