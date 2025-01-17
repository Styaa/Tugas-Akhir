<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrmawa extends Model
{
    //
    protected $fillable = [
        'divisi_ormawas_id',
        'users_id',
        'periodes_periode',
        'jabatan_id'
    ];
    public function divisiOrmawas()
    {
        return $this->belongsTo(DivisiOrmawa::class, 'divisi_ormawas_id');
    }
}
