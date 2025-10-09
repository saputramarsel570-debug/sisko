<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BalasanKeluhanNotification extends Notification
{
    use Queueable;

    protected $keluhan;

    public function __construct($keluhan)
    {
        $this->keluhan = $keluhan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Balasan Keluhan Anda',
            'message' => 'Guru telah memperbarui keluhan Anda: "' . $this->keluhan->isi . '"',
            'keluhan_id' => $this->keluhan->id,
        ];
    }
}