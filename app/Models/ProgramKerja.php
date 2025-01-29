<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    //
    protected $fillable = [
        'nama',
        'tujuan',
        'deskripsi',
        'manfaat',
        'tipe',
        'anggaran_dana',
        'konsep',
        'tempat',
        'sasaran_kegiatan',
        'indikator_keberhasilan',
        'tanggal_mulai',
        'tanggal_selesai',
        'ormawas_kode',
        'periode',
    ];

    public function divisi_pelaksanas()
    {
        return $this->belongsToMany(DivisiPelaksana::class, 'divisi_program_kerjas', 'divisi_pelaksanas_id', 'program_kerjas_id');
    }

    // Relasi dengan tabel DivisiProgramKerja
    public function divisiProgramKerjas()
    {
        return $this->hasMany(DivisiProgramKerja::class, 'program_kerjas_id');
    }

    public function strukturProkers()
    {
        return $this->hasManyThrough(
            StrukturProker::class, // Model yang ingin dihubungkan
            DivisiProgramKerja::class, // Model perantara
            'program_kerjas_id', // Foreign key di tabel perantara (divisi_program_kerjas)
            'divisi_program_kerjas_id', // Foreign key di tabel tujuan (struktur_prokers)
            'id', // Primary key di tabel ProgramKerja
            'id' // Primary key di tabel DivisiProgramKerja
        );
    }
}
