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
        Schema::create('rapats', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama rapat
            $table->text('topik')->nullable(); // Topik rapat
            $table->date('tanggal'); // Tanggal rapat
            $table->time('waktu'); // Jam rapat
            $table->string('tempat'); // Lokasi atau platform online
            $table->enum('status', ['terjadwal', 'selesai', 'dibatalkan'])->default('terjadwal'); // Status rapat

            // Ubah ormawa_id menjadi string agar cocok dengan 'kode' di tabel ormawas
            $table->string('ormawa_id');
            $table->foreign('ormawa_id')->references('kode')->on('ormawas')->onDelete('cascade');

            // Relasi opsional (hanya satu dari mereka yang akan digunakan)
            $table->unsignedInteger('divisi_ormawas_id')->nullable();
            $table->foreign('divisi_ormawas_id')->references('id')->on('divisi_ormawas')->onDelete('cascade');

            $table->foreignId('program_kerjas_id')->nullable()->constrained('program_kerjas')->onDelete('cascade');
            $table->foreignId('divisi_program_kerjas_id')->nullable()->constrained('divisi_program_kerjas')->onDelete('cascade');

            // Opsional: ID pengguna yang membuat rapat
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapat');
    }
};
