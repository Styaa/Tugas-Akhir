<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinRapat extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'rapat_id',
        'user_id',
        'alasan',
        'status', // 'pending', 'disetujui', 'ditolak', 'ditolak_hadir'
        'tanggal_pengajuan',
        'tanggal_verifikasi',
        'verifikasi_oleh'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifikasi_oleh');
    }

    public function isApproved()
    {
        return $this->status === 'disetujui';
    }

    public function isRejected()
    {
        return $this->status === 'ditolak' || $this->status === 'ditolak_hadir';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejectedButAttended()
    {
        return $this->status === 'ditolak_hadir';
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'disetujui':
                return 'Disetujui';
            case 'ditolak':
                return 'Ditolak';
            case 'ditolak_hadir':
                return 'Ditolak (Hadir)';
            case 'pending':
            default:
                return 'Menunggu';
        }
    }

    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'disetujui':
                return 'bg-success';
            case 'ditolak':
                return 'bg-danger';
            case 'ditolak_hadir':
                return 'bg-info';
            case 'pending':
            default:
                return 'bg-warning text-dark';
        }
    }
}
