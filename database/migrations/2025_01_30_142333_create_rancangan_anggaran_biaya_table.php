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
        Schema::create('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['pemasukan', 'pengeluaran']);
            $table->string('komponen_biaya');
            $table->integer('biaya');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->integer('total');
            $table->foreignId('program_kerjas_id')->constrained('program_kerjas')->onDelete('cascade');
            $table->foreignId('divisi_program_kerjas_id')->nullable()->constrained('divisi_program_kerjas')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rancangan_anggaran_biaya');
    }
};
