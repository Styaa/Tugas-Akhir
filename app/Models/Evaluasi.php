<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    //
    use HasFactory;

    protected $table = 'evaluasis';

    protected $fillable = [
        'user_id',
        'proker_id',
        'kehadiran',
        'kontribusi',
        'tanggung_jawab',
        'kualitas',
        'penilaian_atasan',
        'kehadiran_normalized',
        'kontribusi_normalized',
        'tanggung_jawab_normalized',
        'kualitas_normalized',
        'penilaian_atasan_normalized',
        'score',
        'periode',
        'tahun',
    ];

    /**
     * Mendapatkan user terkait
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan proker terkait
     */
    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerjas_id');
    }
}
