<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignPICReminder extends Notification
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
            ->subject("Penugasan PIC: Anda Telah Ditugaskan pada Aktivitas {$this->aktivitas->nama}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Anda telah ditetapkan sebagai PIC untuk aktivitas **{$this->aktivitas->nama}**.")
            ->line("Berikut adalah detail aktivitasnya:")
            ->line("Deskripsi: {$this->aktivitas->deskripsi}")
            ->line("Tanggal Mulai: " . \Carbon\Carbon::parse($this->aktivitas->tanggal_mulai)->format('d M Y'))
            ->line("Tanggal Tenggat: " . \Carbon\Carbon::parse($this->aktivitas->tanggal_tenggat)->format('d M Y'))
            ->line("Silakan tinjau detail aktivitas ini dan mulai persiapkan hal-hal yang diperlukan.")
            ->action('Lihat Detail Aktivitas', url($this->aktivitas->programKerja->ormawas_kode . '/program-kerja/' . $this->aktivitas->programKerja->nama . '/divisi/' . $this->aktivitas->divisiProgramKerja->id))
            ->line("Terima kasih atas kontribusi dan kerjasama Anda.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Penugasan PIC Baru",
            'message' => "Anda telah ditetapkan sebagai PIC untuk aktivitas '{$this->aktivitas->nama}'.",
            'deskripsi' => $this->aktivitas->deskripsi,
            'tanggal_mulai' => \Carbon\Carbon::parse($this->aktivitas->tanggal_mulai)->format('d M Y'),
            'tanggal_tenggat' => \Carbon\Carbon::parse($this->aktivitas->tanggal_tenggat)->format('d M Y'),
            'url' => url('/aktivitas/' . $this->aktivitas->id),
        ];
    }
}
