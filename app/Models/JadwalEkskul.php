<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalEkskul extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ekskul';

    protected $fillable = [
        'ekstrakurikuler_id',
        'hari',
    ];

    protected $casts = [
        'hari' => 'array',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }

    public function getHariListAttribute()
    {
        return is_array($this->hari) ? implode(', ', $this->hari) : $this->hari;
    }
}