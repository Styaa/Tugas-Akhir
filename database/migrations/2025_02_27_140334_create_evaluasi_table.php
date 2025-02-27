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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // Nilai kinerja per kriteria (tipe datanya tergantung kebutuhan)
            $table->integer('kehadiran')->default(0);       // 0-100, atau jumlah rapat
            $table->integer('kontribusi')->default(0);      // 0-100, dll.
            $table->integer('tanggung_jawab')->default(0);  // 0-100
            $table->integer('kualitas')->default(0);        // 0-100
            $table->integer('penilaian_atasan')->default(0); // 0-100
            $table->integer('score')->default(0); // 0-100

            $table->timestamps();
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
