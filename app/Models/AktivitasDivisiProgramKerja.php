<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AktivitasDivisiProgramKerja extends Model
{
    //
    use HasFactory;

    protected $table = 'aktivitas_divisi_program_kerjas';

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
    ];

    public function personInCharge()
    {
        return $this->belongsTo(User::class, 'person_in_charge');
    }
}
