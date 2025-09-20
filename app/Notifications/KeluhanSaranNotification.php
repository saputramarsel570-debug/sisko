<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KeluhanSaranNotification extends Notification
{
    use Queueable;

    protected $kategori;
    protected $username;
    protected $isi;

    /**
     * Create a new notification instance.
     */
    public function __construct($kategori, $username, $isi)
    {
        $this->kategori = $kategori;
        $this->username = $username;
        $this->isi = $isi;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // disimpan ke database
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title'   => 'Keluhan/Saran Baru',
            'message' => $this->kategori . ' dari ' . $this->username . ': ' . $this->isi,
        ];
    }
}
