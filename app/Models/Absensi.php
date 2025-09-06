<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'kelas_id',
        'siswa_id',
        'status',
        'keterangan',
    ];

    public function siswa()
    {
        return
        $this->belongsTo(Siswa::class);
    }
    public function kelas()
    {
        return
        $this->belongsTo(Kelas::class);
    }
}
