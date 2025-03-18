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
        Schema::create('notulens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->longText('content');
            $table->foreignId('users_id')->constrained()->onDelete('Cascade');
            $table->foreignId('rapats_id')->constrained()->onDelete('Cascade');
            $table->string('ormawas_id');
            $table->foreign('ormawas_id')->references('kode')->on('ormawas')->onDelete('cascade');

            $table->unsignedInteger('divisi_ormawas_id')->nullable();
            $table->foreign('divisi_ormawas_id')->references('id')->on('divisi_ormawas')->onDelete('cascade');

            $table->foreignId('program_kerjas_id')->nullable()->constrained('program_kerjas')->onDelete('cascade');
            $table->foreignId('divisi_program_kerjas_id')->nullable()->constrained('divisi_program_kerjas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notulens');
    }
};
