<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    //
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas', 'nama_fakultas');
    }

    public function strukturOrmawa()
    {
        return $this->hasMany(StrukturOrmawa::class, 'ormawa_kode', 'kode');
        // atau gunakan 'ormawa_kode' jika primary key berbentuk kode string
    }
}
