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
        Schema::create('ormawas', function (Blueprint $table) {
            $table->string('kode', 9)->primary();
            $table->string('naungan', 100);
            $table->string('visi', 255);
            $table->string('misi', 255);
            // $table->string('tipe_ormawa', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ormawas');
    }
};
