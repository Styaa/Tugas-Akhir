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
        Schema::create('aktivitas_divisi_program_kerjas', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama', 100); // Nama aktivitas
            $table->string('keterangan', 255); // Deskripsi aktivitas
            $table->enum('status', ['belum_mulai', 'sedang_berjalan', 'selesai', 'ditunda'])->default('belum_mulai'); // Status aktivitas
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'kritikal'])->default('sedang');
            $table->dateTime('tanggal_mulai')->nullable(); // Tanggal mulai aktivitas
            $table->dateTime('tanggal_selesai')->nullable(); // Tanggal selesai aktivitas
            $table->unsignedBigInteger('person_in_charge')->nullable(); // ID person in charge
            $table->dateTime('tenggat_waktu')->nullable(); // Tenggat waktu
            $table->unsignedBigInteger('dependency_id')->nullable(); // ID aktivitas yang bergantung
            $table->unsignedBigInteger('divisi_pelaksana_id'); // ID divisi pelaksana
            $table->unsignedBigInteger('program_kerjas_id'); // ID program kerja

            // Relasi foreign key
            $table->foreign('person_in_charge')->references('id')->on('users')->onDelete('set null');
            $table->foreign('dependency_id')->references('id')->on('aktivitas_divisi_program_kerjas')->onDelete('set null');
            $table->foreign('divisi_pelaksana_id')->references('id')->on('divisi_program_kerjas')->onDelete('cascade');
            $table->foreign('program_kerjas_id')->references('id')->on('program_kerjas')->onDelete('cascade');

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas_divisi_program_kerjas');
    }
};
