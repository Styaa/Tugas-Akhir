<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDokumen extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'program_kerja_id',
        'ormawas_kode',
        'tipe',
        'isi_dokumen',
        'status',
        'catatan_revisi',
        'peninjau_id',
        'tanggal_pengajuan',
        'tanggal_peninjauan',
        'created_by',
        'updated_by'
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerja_id');
    }

    /**
     * Get the ormawa that owns the report document.
     */
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawas_kode', 'kode');
    }

    /**
     * Get the user that reviewed the report document.
     */
    public function peninjau()
    {
        return $this->belongsTo(User::class, 'peninjau_id');
    }

    /**
     * Get the user that created the report document.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that last updated the report document.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include proposals.
     */
    public function scopeProposal($query)
    {
        return $query->where('tipe', 'proposal');
    }

    /**
     * Scope a query to only include final reports.
     */
    public function scopeLaporan($query)
    {
        return $query->where('tipe', 'laporan_pertanggungjawaban');
    }

    /**
     * Scope a query to only include approved documents.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope a query to only include pending review documents.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'diajukan');
    }

    /**
     * Scope a query to only include drafts.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include documents needing revision.
     */
    public function scopeNeedsRevision($query)
    {
        return $query->where('status', 'perlu_revisi');
    }

    /**
     * Scope a query to only include rejected documents.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'ditolak');
    }
}
