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
        Schema::create('izin_rapats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapat_id')->constrained('rapats')->onDelete('cascade'); // ID Rapat
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID User yang mengajukan izin
            $table->text('alasan'); // Alasan izin
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending'); // Status izin
            $table->timestamp('tanggal_pengajuan')->useCurrent(); // Tanggal izin diajukan
            $table->timestamp('tanggal_verifikasi')->nullable(); // Tanggal izin diverifikasi oleh admin
            $table->foreignId('verifikasi_oleh')->nullable()->constrained('users')->onDelete('set null'); // Admin yang memverifikasi izin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_rapats');
    }
};
