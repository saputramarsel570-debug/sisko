<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';

    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'materi',
        'catatan',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function getJamTextAttribute()
    {
        return "Jam {$this->jam_mulai}" . ($this->jam_mulai != $this->jam_selesai ? "-{$this->jam_selesai}" : "");
    }
}