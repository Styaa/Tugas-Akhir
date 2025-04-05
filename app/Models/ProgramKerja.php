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
        'konfirmasi_penyelesaian',
        'pengkonfirmasi',
        'ormawas_kode',
        'periode',
        'updated_at'
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

    public function rapat()
    {
        return $this->hasMany(Rapat::class, 'program_kerjas_id');
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'program_kerjas_id');
    }

    public function laporanDokumens()
    {
        return $this->hasMany(LaporanDokumen::class, 'program_kerja_id');
    }

    public function proposal()
    {
        return $this->hasOne(LaporanDokumen::class, 'program_kerja_id')
            ->where('tipe', 'proposal')
            ->latest('created_at');
    }

    public function lpj()
    {
        return $this->hasOne(LaporanDokumen::class, 'program_kerja_id')
            ->where('tipe', 'laporan_pertanggungjawaban')
            ->latest('created_at');
    }
}
