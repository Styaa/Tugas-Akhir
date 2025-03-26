<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_dokumens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('program_kerja_id')->unsigned();
            $table->string('ormawas_kode', 9);
            $table->enum('tipe', ['proposal', 'laporan_pertanggungjawaban']);
            $table->longText('isi_dokumen');
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'perlu_revisi', 'ditolak'])->default('draft');
            $table->text('catatan_revisi')->nullable();
            $table->bigInteger('peninjau_id')->unsigned()->nullable();
            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_peninjauan')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('program_kerja_id')->references('id')->on('program_kerjas')->onDelete('cascade');
            $table->foreign('ormawas_kode')->references('kode')->on('ormawas')->onDelete('cascade');
            $table->foreign('peninjau_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_dokumens');
    }
};
