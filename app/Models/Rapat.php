<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rapat extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama',
        'topik',
        'tanggal',
        'waktu',
        'tipe',
        'tempat',
        'status',
        'ormawa_id',
        'divisi_ormawas_id',
        'program_kerjas_id',
        'divisi_program_kerjas_id',
        'created_by',
    ];

    // Menentukan tipe penyelenggara rapat
    public function getTipePenyelenggaraAttribute()
    {
        if ($this->divisi_ormawas_id) {
            return $this->divisiOrmawa ? $this->divisiOrmawa->nama : 'Divisi Ormawa';
        } elseif ($this->program_kerjas_id) {
            return $this->programKerja ? $this->programKerja->nama : 'Program Kerja';
        } elseif ($this->divisi_program_kerjas_id) {
            return $this->divisiProgramKerja ? $this->divisiProgramKerja->nama : 'Divisi Program Kerja';
        } else {
            return $this->ormawa ? $this->ormawa->nama : 'Ormawa';
        }
    }

    public function getHariAttribute()
    {
        return Carbon::parse($this->tanggal)->translatedFormat('l');
    }

    // Relasi ke Ormawa
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id', 'kode');
    }

    // Relasi ke Divisi Ormawa
    public function divisiOrmawa()
    {
        return $this->belongsTo(DivisiOrmawa::class, 'divisi_ormawas_id', 'id');
    }

    // Relasi ke Program Kerja
    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerjas_id', 'id');
    }

    // Relasi ke Divisi Program Kerja
    public function divisiProgramKerja()
    {
        return $this->belongsTo(DivisiProgramKerja::class, 'divisi_program_kerjas_id', 'id');
    }

    // Relasi ke User (yang membuat rapat)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function izin()
    {
        return $this->hasMany(IzinRapat::class, 'rapat_id');
    }

    public function peserta()
    {
        return $this->hasMany(RapatPartisipasi::class, 'rapat_id');
    }
}
