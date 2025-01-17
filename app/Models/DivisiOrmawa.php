<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisiOrmawa extends Model
{
    //
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawas_kode', 'kode');
    }
}
