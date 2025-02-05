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
            ->subject('Peringatan Tenggat Waktu')
            ->line("Aktivitas '{$this->aktivitas->nama}' akan mencapai tenggat dalam 5 hari.")
            ->action('Lihat Detail', url('/aktivitas/' . $this->aktivitas->id))
            ->line('Pastikan untuk menyelesaikan tepat waktu!');
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
