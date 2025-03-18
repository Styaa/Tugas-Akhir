<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'users_id',
        'rapats_id',
        'program_kerjas_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'rapats_id');
    }

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerjas_id');
    }

    public function divisiOrmawa()
    {
        return $this->belongsTo(DivisiOrmawa::class, 'divisi_ormawas_id', 'id');
    }

    public function divisiProgramKerja()
    {
        return $this->belongsTo(DivisiProgramKerja::class, 'divisi_program_kerjas_id', 'id');
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawas_id', 'kode');
    }
}
