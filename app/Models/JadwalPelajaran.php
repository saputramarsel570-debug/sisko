<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kelas_id',
        'guru_id',
        'mapel',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru ()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
