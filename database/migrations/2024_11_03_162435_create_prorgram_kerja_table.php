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
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            // $table->string('ormawas_kode', 9);
            // $table->year('periodes_periode');
            $table->enum('disetujui', ['Ya', 'Tidak']);
            $table->string('tujuan', 255);
            $table->string('deskripsi', 255);
            $table->string('manfaat', 255);
            $table->enum('tipe', ['Internal', 'Eksternal']);
            $table->string('anggaran_dana', 255);
            $table->string('konsep', 45);
            $table->string('tempat', 45);
            $table->string('sasaran_kegiatan', 255);
            $table->string('indikator_keberhasilan', 255);
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prorgram_kerjas');
    }
};
