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
        Schema::create('detail_krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_krs')->constrained(
                table: 'krs',
                indexName: 'detail_krs_id_krs'
            );
            $table->foreignId('id_jadwal')->constrained(
                table: 'jadwals',
                indexName: 'krs_id_jadwal'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_krs');
    }
};
