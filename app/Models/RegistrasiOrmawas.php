<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistrasiOrmawas extends Model
{
    //
    use HasFactory;

    protected $fillable = ['users_id', 'ormawas_kode', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawas_kode');
    }
}
