<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineReminder extends Notification
{
    use Queueable;

    private $aktivitas;

    /**
     * Create a new notification instance.
     */
    public function __construct($aktivitas)
    {
        //
        $this->aktivitas = $aktivitas;
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
            ->subject("Pengingat: Tenggat Waktu Aktivitas {$this->aktivitas->nama}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Kami ingin mengingatkan bahwa aktivitas **{$this->aktivitas->nama}** memiliki tenggat waktu yang akan datang dalam *{$this->aktivitas->sisa_hari}* hari.")
            ->line("Silakan tinjau detail aktivitas ini dan pastikan semuanya sudah sesuai rencana.")
            ->action('Lihat Detail Aktivitas', url('/aktivitas/' . $this->aktivitas->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Aktivitas '{$this->aktivitas->nama}' akan mencapai tenggat dalam 5 hari.",
            'url' => url('/aktivitas/' . $this->aktivitas->id),
        ];
    }
}
