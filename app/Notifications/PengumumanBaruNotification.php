<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengumumanBaruNotification extends Notification
{
    use Queueable;

    public $judul;
    public $isi;
    public $pengumuman_id;

    public function __construct($judul, $isi, $pengumuman_id)
    {
        $this->judul = $judul;
        $this->isi = $isi;
        $this->pengumuman_id = $pengumuman_id;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toArray($notifiable)
    {
        return [
            'judul' => $this->judul,
            'isi' => $this->isi,
            'pengumuman_id' => $this->pengumuman_id,
        ];
    }
}