<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'wali_kelas_id',
    ];
    public function waliKelas()
    {
        return
        $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function siswa()
    {
        return
        $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function absensi()
    {
        return
        $this->hasMany(Absensi::class, 'kelas_id');
    }

    public function jurnal()
    {
        return
        $this->hasMany(Jurnal::class, 'kelas_id');
    }

    public function jadwalPelajaran()
    {
        return
        $this->hasMany(JadwalPelajaran::class, 'kelas_id');
    }
}
