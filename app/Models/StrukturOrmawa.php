<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrmawa extends Model
{
    //
    protected $table = 'struktur_ormawas';

    protected $fillable = [
        'divisi_ormawas_id',
        'users_id',
        'periodes_periode',
        'jabatan_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function divisiOrmawas()
    {
        return $this->belongsTo(DivisiOrmawa::class, 'divisi_ormawas_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
