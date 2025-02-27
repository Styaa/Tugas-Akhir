<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengingatRapatNotification extends Notification
{
    use Queueable;

    public $rapat;
    public $sisaHari;

    public function __construct($rapat, $sisaHari)
    {
        $this->rapat = $rapat;
        $this->sisaHari = $sisaHari;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Pengingat Rapat: {$this->rapat->nama}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Rapat **{$this->rapat->nama}** akan dilaksanakan dalam **{$this->sisaHari}** hari.")
            ->line("Tanggal Rapat: " . \Carbon\Carbon::parse($this->rapat->tanggal)->format('d M Y'))
            ->action('Lihat Detail Rapat', url('/rapat/' . $this->rapat->id))
            ->line("Mohon persiapkan diri Anda dengan baik.");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Pengingat Rapat",
            'message' => "Rapat '{$this->rapat->nama}' akan dilaksanakan dalam {$this->sisaHari} hari.",
            'tanggal' => \Carbon\Carbon::parse($this->rapat->tanggal)->format('d M Y'),
            'url' => url('/rapat/' . $this->rapat->id),
        ];
    }
}
