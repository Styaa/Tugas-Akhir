<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AktivitasDivisiProgramKerja extends Model
{
    //
    use HasFactory;

    protected $table = 'tugas_divisi_program_kerjas';

    protected $fillable = [
        'nama',
        'keterangan',
        'status',
        'prioritas',
        'tanggal_mulai',
        'tanggal_selesai',
        'person_in_charge',
        'tenggat_waktu',
        'dependency_id',
        'divisi_pelaksana_id',
        'program_kerjas_id',
        'nilai'
    ];

    public function personInCharge()
    {
        return $this->belongsTo(User::class, 'person_in_charge');
    }

    // Relasi ke DivisiProgramKerja
    public function divisiProgramKerja()
    {
        return $this->belongsTo(DivisiProgramKerja::class, 'divisi_pelaksana_id');
    }

    // Relasi ke ProgramKerja melalui DivisiProgramKerja
    public function programKerja()
    {
        return $this->hasOneThrough(ProgramKerja::class, DivisiProgramKerja::class, 'id', 'id', 'divisi_pelaksana_id', 'program_kerjas_id');
    }
}
