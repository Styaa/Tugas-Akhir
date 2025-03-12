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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_kerja_id')->constrained('program_kerjas')->onDelete('cascade');
            $table->string('original_name');
            $table->string('storage_path');
            $table->string('extension', 20);
            $table->bigInteger('size');
            $table->string('category', 50);
            $table->string('visibility', 20)->default('committee');
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
