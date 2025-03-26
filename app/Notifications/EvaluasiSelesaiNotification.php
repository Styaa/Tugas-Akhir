<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProgramKerja;
use App\Models\Evaluasi;

class EvaluasiSelesaiNotification extends Notification
{
    use Queueable;

    protected $programKerja;
    protected $evaluasi;

    /**
     * Create a new notification instance.
     */
    public function __construct(ProgramKerja $programKerja, Evaluasi $evaluasi)
    {
        $this->programKerja = $programKerja;
        $this->evaluasi = $evaluasi;
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
            ->subject("Hasil Evaluasi Program Kerja: {$this->programKerja->nama}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Program kerja **{$this->programKerja->nama}** telah selesai dan evaluasi kinerja telah dihitung.")
            ->line("Berikut hasil evaluasi kinerja Anda:")
            ->line("**Skor Kehadiran:** " . number_format($this->evaluasi->kehadiran, 2) . "%")
            ->line("**Skor Kontribusi:** " . number_format($this->evaluasi->kontribusi, 2) . "%")
            ->line("**Skor Tanggung Jawab:** " . number_format($this->evaluasi->tanggung_jawab, 2) . "%")
            ->line("**Skor Kualitas:** " . number_format($this->evaluasi->kualitas, 2) . "%")
            ->line("**Skor Penilaian Atasan:** " . number_format($this->evaluasi->penilaian_atasan, 2) . "%")
            ->line("**Skor Akhir:** " . number_format($this->evaluasi->score, 2) . " dari 100")
            ->action('Lihat Detail Evaluasi', url("/program-kerja/{$this->programKerja->id}/evaluasi"))
            ->line("Terima kasih atas kerja keras dan kontribusi Anda dalam program kerja ini.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Hasil Evaluasi Program Kerja",
            'message' => "Evaluasi untuk '{$this->programKerja->nama}' telah selesai.",
            'program_kerja_id' => $this->programKerja->id,
            'program_kerja_nama' => $this->programKerja->nama,
            'evaluasi_score' => $this->evaluasi->score,
            'url' => url("/program-kerja/{$this->programKerja->id}/evaluasi"),
        ];
    }
}
