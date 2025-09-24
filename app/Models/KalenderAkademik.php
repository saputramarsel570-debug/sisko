<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    use HasFactory;

    protected $table = 'kalender_akademik';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
    ];

    // ✅ Tambahkan ini supaya tanggal menjadi Carbon
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function getTanggalMulaiFormattedAttribute()
    {
        return $this->tanggal_mulai ? $this->tanggal_mulai->translatedFormat('d F Y') : null;
    }

    public function getTanggalSelesaiFormattedAttribute()
    {
        return $this->tanggal_selesai ? $this->tanggal_selesai->translatedFormat('d F Y') : null;
    }

    public function isSingleDay()
    {
        return $this->tanggal_selesai === null || $this->tanggal_mulai->eq($this->tanggal_selesai);
    }
}
