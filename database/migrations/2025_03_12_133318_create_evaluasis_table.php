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
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_kerjas_id')->constrained()->onDelete('cascade');
            $table->decimal('kehadiran', 5, 2)->default(0);
            $table->decimal('kontribusi', 5, 2)->default(0);
            $table->decimal('tanggung_jawab', 5, 2)->default(0);
            $table->decimal('kualitas', 5, 2)->default(0);
            $table->decimal('penilaian_atasan', 5, 2)->default(0);

            // Kolom untuk nilai normalisasi
            $table->decimal('kehadiran_normalized', 5, 2)->nullable();
            $table->decimal('kontribusi_normalized', 5, 2)->nullable();
            $table->decimal('tanggung_jawab_normalized', 5, 2)->nullable();
            $table->decimal('kualitas_normalized', 5, 2)->nullable();
            $table->decimal('penilaian_atasan_normalized', 5, 2)->nullable();

            // Hasil akhir perhitungan SAW
            $table->decimal('score', 5, 2)->default(0);

            // Periode penilaian
            $table->string('periode')->nullable();
            $table->year('tahun')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'program_kerjas_id']);
            $table->index(['periode', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
