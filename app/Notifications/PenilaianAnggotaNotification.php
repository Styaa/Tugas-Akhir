<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenilaianAnggotaNotification extends Notification
{
    use Queueable;

    protected $programKerja;
    protected $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($programKerja, $url)
    {
        //
        $this->programKerja = $programKerja;
        $this->url = $url;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permintaan Penilaian Anggota Program Kerja: ' . $this->programKerja->nama)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Program kerja "' . $this->programKerja->nama . '" telah melewati tanggal selesai.')
            ->line('Sebagai Koordinator/Wakil Koordinator, Anda diminta untuk memberikan penilaian terhadap anggota di divisi Anda.')
            ->action('Buka Halaman Penilaian', $this->url)
            ->line('Harap segera lakukan penilaian agar proses evaluasi dapat dilanjutkan.')
            ->line('Terima kasih atas kerjasama Anda.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'program_kerja_id' => $this->programKerja->id,
            'program_kerja_nama' => $this->programKerja->nama,
            'pesan' => 'Anda diminta untuk memberikan penilaian terhadap anggota di divisi Anda',
            'url' => $this->url
        ];
    }
}
