<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    use HasFactory;

    protected $table = "dokumens";

    protected $fillable = [
        'program_kerja_id',
        'original_name',
        'storage_path',
        'extension',
        'size',
        'category',
        'visibility',
        'description',
        'tags',
        'uploaded_by'
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerja_id');
    }

    /**
     * Get the user that uploaded the file.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
