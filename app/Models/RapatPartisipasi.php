<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapatPartisipasi extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'rapat_id',
        'user_id',
        'status_kehadiran',
        'alasan',
        'waktu_check_in',
    ];

    // Relasi ke Rapat
    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
