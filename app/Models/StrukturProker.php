<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrukturProker extends Model
{
    //
    use HasFactory;

    protected $table = 'struktur_prokers';

    protected $fillable = [
        'users_id',
        'divisi_program_kerjas_id',
        'jabatans_id',
        'nilai_atasan',
        'keterangan_nilai',
        'penilai_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }

    public function divisiProgramKerja()
    {
        return $this->belongsTo(DivisiProgramKerja::class, 'divisi_program_kerjas_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
