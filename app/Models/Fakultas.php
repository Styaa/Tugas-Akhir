<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    //
    protected $table = 'fakultas';
    protected $fillable = ['nama_fakultas'];
    /**
     * Get the users associated with the fakultas.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'fakultas', 'nama_fakultas');
    }

    /**
     * Get the ormawas associated with the fakultas.
     */
    public function ormawas()
    {
        return $this->hasMany(Ormawa::class, 'fakultas', 'nama_fakultas');
    }
}
