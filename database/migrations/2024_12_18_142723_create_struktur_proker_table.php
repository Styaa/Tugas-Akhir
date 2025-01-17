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
        Schema::create('struktur_prokers', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('divisi_program_kerjas_id');
            $table->unsignedInteger('jabatans_id'); // Sesuaikan dengan INT

            // Definisi foreign key secara manual
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('divisi_program_kerjas_id')->references('id')->on('divisi_program_kerjas')->onDelete('cascade');
            $table->foreign('jabatans_id')->references('id')->on('jabatans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_prokers');
    }
};
