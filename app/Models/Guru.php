<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'mapel',
    ];
    Public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'guru_id');
    }
    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'guru_id');
    }
    public function absensi()
    {
        return $this->hasManyThrough(Absensi::class, Kelas::class, 'wali_kelas_id', 'kelas_id');
    }
}
