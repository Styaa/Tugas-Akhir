<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisiProgramKerja extends Model
{
    //
    protected $fillable = [
        'divisi_pelaksanas_id',
        'program_kerjas_id',
    ];

    public function divisiPelaksana()
    {
        return $this->belongsTo(DivisiPelaksana::class, 'divisi_pelaksanas_id', 'id');
    }

    // Relasi ke model ProgramKerja
    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerjas_id');
    }
}
