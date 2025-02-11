<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama',
        'topik',
        'tanggal',
        'waktu',
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
            return 'Divisi Ormawa';
        } elseif ($this->program_kerjas_id) {
            return 'Program Kerja';
        } elseif ($this->divisi_program_kerjas_id) {
            return 'Divisi Program Kerja';
        } else {
            return $this->ormawa_id;
        }
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
}
