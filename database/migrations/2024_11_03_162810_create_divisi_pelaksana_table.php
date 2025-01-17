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
        Schema::create('divisi_pelaksanas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 45);
            $table->string('keterangan', 100);
            $table->string('jobdesc', 255);
            // $table->string('program_kerjas_id', 9);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi_pelaksanas');
    }
};
