<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'alamat',
        'kelas_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
    public function orangTua()
    {
        return $this->hasMany(OrangTua::class, 'siswa_id');
    }
}
