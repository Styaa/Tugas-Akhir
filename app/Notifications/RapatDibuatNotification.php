<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RapatDibuatNotification extends Notification
{
    use Queueable;

    public $rapat;

    /**
     * Create a new notification instance.
     */
    public function __construct($rapat)
    {
        $this->rapat = $rapat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Rapat Baru: {$this->rapat->nama}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Anda dijadwalkan untuk menghadiri rapat **{$this->rapat->nama}**.")
            ->line("Tanggal Rapat: " . \Carbon\Carbon::parse($this->rapat->tanggal)->format('d M Y'))
            ->line("Deskripsi: {$this->rapat->deskripsi}")
            ->action('Lihat Detail Rapat', url('/rapat/' . $this->rapat->id))
            ->line("Terima kasih atas perhatian Anda.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Rapat Baru Dibuat",
            'message' => "Anda dijadwalkan untuk menghadiri rapat '{$this->rapat->nama}'.",
            'tanggal' => \Carbon\Carbon::parse($this->rapat->tanggal)->format('d M Y'),
            'deskripsi' => $this->rapat->deskripsi,
            'url' => url('/rapat/' . $this->rapat->id),
        ];
    }
}
