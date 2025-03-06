<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nrp',
        'jurusan',
        'id_line',
        'no_hp',
    ];

    public function registrations()
    {
        return $this->hasMany(RegistrasiOrmawas::class, 'users_id');
    }

    public function jabatanOrmawa()
    {
        // return $this->hasMany(StrukturOrmawa::class, 'users_id');
        return $this->hasOneThrough(
            Jabatan::class,
            StrukturOrmawa::class,
            'users_id',
            'id',
            'id',
            'jabatan_id'
        );
    }

    public function jabatanProker()
    {
        // return $this->hasMany(StrukturOrmawa::class, 'users_id');
        return $this->hasOneThrough(
            Jabatan::class,
            StrukturProker::class,
            'users_id',
            'id',
            'id',
            'jabatans_id'
        );
    }

    public function strukturProkers()
    {
        return $this->hasMany(StrukturProker::class, 'users_id');
    }

    public function strukturOrmawas()
    {
        return $this->hasMany(StrukturOrmawa::class, 'users_id');
    }

    public function izinRapat()
    {
        return $this->hasMany(IzinRapat::class, 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
