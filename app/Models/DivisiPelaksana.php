<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisiPelaksana extends Model
{
    //
    public function programKerjas()
    {
        return $this->hasMany(DivisiProgramKerja::class, 'divisi_pelaksanas_id');
    }


    // Relasi dengan tabel DivisiProgramKerja
    public function divisiProgramKerjas()
    {
        return $this->hasMany(DivisiProgramKerja::class, 'divisi_pelaksanas_id');
    }
}
