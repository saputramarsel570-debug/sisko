<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'mapel',
    ];
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }
    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
}
