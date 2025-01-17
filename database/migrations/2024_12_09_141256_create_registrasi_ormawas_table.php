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
        Schema::create('registrasi_ormawas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->string('ormawas_kode', 9);
            $table->enum('status', ['waiting', 'accepted', 'rejected'])->default('waiting');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ormawas_kode')->references('kode')->on('ormawas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_ormawas');
    }
};
