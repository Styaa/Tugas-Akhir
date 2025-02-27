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
        Schema::table('aktivitas_divisi_program_kerjas', function (Blueprint $table) {
            //
            $table->enum('nilai', ['1', '2', '3', '4', '5'])->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aktivitas_divisi_program_kerjas', function (Blueprint $table) {
            //
            $table->dropColumn('nilai');
        });
    }
};
