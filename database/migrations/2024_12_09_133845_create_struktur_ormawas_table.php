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
        Schema::create('struktur_ormawas', function (Blueprint $table) {
            $table->unsignedInteger('divisi_ormawas_id');
            $table->unsignedBigInteger('users_id');
            $table->year('periodes_periode');
            $table->unsignedInteger('jabatan_id');

            // Define foreign key constraints
            $table->foreign('divisi_ormawas_id')
                ->references('id')
                ->on('divisi_ormawas')
                ->onDelete('cascade');

            $table->foreign('users_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('periodes_periode')
                ->references('periode')
                ->on('periodes')
                ->onDelete('cascade');

            $table->foreign('jabatan_id')
                ->references('id')
                ->on('jabatans')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_ormawas');
    }
};
