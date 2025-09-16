<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluhanSaran extends Model
{
    Use HasFactory;

    protected $table = 'keluhan_saran';

    protected $fillable = [
        'user_id',
        'kategori',
        'isi',
        'tipe_pengirim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
