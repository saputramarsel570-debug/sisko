<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal' ;

    protected $fillable = [
        'tanggal',
        'guru_id',
        'kelas_id',
        'mapel',
        'materi',
        'catatan',
    ];

    public function guru()
    {
        return
        $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return
        $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
