<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinRapat extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'rapat_id', 'alasan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }
}
