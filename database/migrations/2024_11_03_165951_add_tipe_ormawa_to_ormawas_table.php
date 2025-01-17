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
        Schema::table('ormawas', function (Blueprint $table) {
            //
            $table->string('tipe_ormawa');

            $table->foreign('tipe_ormawa')->references('tipe_ormawa')->on('tipe_ormawas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ormawas', function (Blueprint $table) {
            //
        });
    }
};
