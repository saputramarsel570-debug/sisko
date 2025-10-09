<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KeluhanBaruNotification extends Notification
{
    use Queueable;

    protected $keluhan;

    /**
     * Create a new notification instance.
     */
    public function __construct($keluhan)
    {
        $this->keluhan = $keluhan;
    }

    /**
     * Kirim lewat database (bukan email).
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Data yang disimpan ke tabel notifications.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Keluhan Baru Diterima',
            'message' => 'Ada keluhan atau saran baru dari ' . $this->keluhan->user->name,
            'keluhan_id' => $this->keluhan->id,
            'kategori' => $this->keluhan->kategori,
            'isi' => $this->keluhan->isi,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}