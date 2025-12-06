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
            'title'   => 'Keluhan Baru',
            'message' => 'Keluhan dari ' . $this->keluhan->user->name,
            'url'     => route('admin.keluhan_saran.show', $this->keluhan->id)
        ];
    }
}