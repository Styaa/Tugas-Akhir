<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RancanganAnggaranBiaya extends Model
{
    //
    use HasFactory;

    protected $table = 'rancangan_anggaran_biaya';

    protected $fillable = [
        'kategori',
        'komponen_biaya',
        'biaya',
        'jumlah',
        'satuan',
        'total',
        'program_kerjas_id',
        'divisi_program_kerjas_id',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerjas_id');
    }

    public function divisiProgramKerja()
    {
        return $this->belongsTo(DivisiProgramKerja::class, 'divisi_program_kerjas_id');
    }
}
