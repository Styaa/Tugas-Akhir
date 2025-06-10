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
        'fakultas',
        'id_line',
        'no_hp',
        'google_id'
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

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas', 'nama_fakultas');
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

    public function evaluasiTerbaru($programKerjaId = null)
    {
        $query = $this->hasOne(Evaluasi::class, 'user_id');

        if ($programKerjaId) {
            $query->where('program_kerjas_id', $programKerjaId);
        }

        return $query->latest('created_at');
    }

    /**
     * Relasi ke semua evaluasi user
     */
    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class, 'user_id');
    }

    public function getJabatanInProker($programKerjaId)
    {
        return $this->strukturProkers()
            ->whereHas('divisiProgramKerja', function ($query) use ($programKerjaId) {
                $query->where('program_kerjas_id', $programKerjaId);
            })
            ->with('jabatan')
            ->first()->jabatan ?? null;
    }

    /**
     * Get divisi user dalam program kerja tertentu
     */
    public function getDivisiInProker($programKerjaId)
    {
        return $this->strukturProkers()
            ->whereHas('divisiProgramKerja', function ($query) use ($programKerjaId) {
                $query->where('program_kerjas_id', $programKerjaId);
            })
            ->with('divisiProgramKerja.divisiPelaksana')
            ->first()->divisiProgramKerja->divisiPelaksana ?? null;
    }

    /**
     * Cek apakah user memiliki evaluasi dalam program kerja
     */
    public function hasEvaluasiInProker($programKerjaId)
    {
        return $this->evaluasis()
            ->where('program_kerjas_id', $programKerjaId)
            ->exists();
    }

    /**
     * Get performance score dalam program kerja
     */
    public function getPerformanceScore($programKerjaId)
    {
        $evaluasi = $this->evaluasiTerbaru($programKerjaId)->first();
        return $evaluasi ? $evaluasi->score * 100 : 0;
    }

    /**
     * Get performance grade dalam program kerja
     */
    public function getPerformanceGrade($programKerjaId)
    {
        $score = $this->getPerformanceScore($programKerjaId);

        if ($score >= 90) return 'Excellent';
        if ($score >= 80) return 'Good';
        if ($score >= 70) return 'Average';
        if ($score >= 60) return 'Below Average';
        return 'Needs Improvement';
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
