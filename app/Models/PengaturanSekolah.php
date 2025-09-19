<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSekolah extends Model
{
    protected $table = 'pengaturan_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'jenjang',
        'alamat',
        'telepon',
        'email',
        'logo',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'tahun_ajaran',
        'semester',
        'kop_surat',
        'ttd_kepsek',
    ];
}
