<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class PengumumanBaruNotification extends Notification
{
    use Queueable;

    protected $judul;
    protected $isi;
    protected $pengumumanId;

    public function __construct($judul, $isi, $pengumumanId)
    {
        $this->judul = $judul;
        $this->isi = $isi;
        $this->pengumumanId = $pengumumanId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        if ($notifiable->role === 'siswa_perwakilan') {
            $route = route('siswa_perwakilan.pengumuman.show', $this->pengumumanId);
        } elseif ($notifiable->role === 'siswa') {
            $route = route('siswa.pengumuman.show', $this->pengumumanId);
        } elseif ($notifiable->role === 'orangtua') {
            $route = route('orangtua.pengumuman.show', $this->pengumumanId);
        } else {
            $route = '#';
        }

        return [
            'title' => 'Pengumuman Baru',
            'message' => $this->judul,
            'isi' => Str::limit(strip_tags($this->isi), 80),
            'pengumuman_id' => $this->pengumumanId,
            'url' => $route,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}