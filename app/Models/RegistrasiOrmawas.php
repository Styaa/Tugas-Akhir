<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistrasiOrmawas extends Model
{
    //
    use HasFactory;

    protected $fillable = ['users_id', 'ormawas_kode', 'pilihan_divisi_1', 'pilihan_divisi_2', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawas_kode');
    }

    public function divisi1()
    {
        return $this->belongsTo(DivisiOrmawa::class, 'pilihan_divisi_1', 'id');
    }

    public function divisi2()
    {
        return $this->belongsTo(DivisiOrmawa::class, 'pilihan_divisi_2', 'id');
    }
}
