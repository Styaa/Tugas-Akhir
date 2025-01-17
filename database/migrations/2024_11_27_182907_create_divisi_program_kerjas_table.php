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
        Schema::create('divisi_program_kerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('divisi_pelaksanas_id');
            $table->unsignedBigInteger('program_kerjas_id');

            $table->foreign('divisi_pelaksanas_id')->references('id')
                ->on('divisi_pelaksanas')->onDelete('cascade');
            $table->foreign('program_kerjas_id')->references('id')
                ->on('program_kerjas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi_program_kerjas');
    }
};
