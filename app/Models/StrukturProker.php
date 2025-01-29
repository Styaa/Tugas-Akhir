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
    ];

    public function divisiProgramKerja()
    {
        return $this->belongsTo(DivisiProgramKerja::class, 'divisi_program_kerjas_id');
    }
}
