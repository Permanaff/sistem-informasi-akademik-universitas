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
        Schema::create('jadwal_krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ta')->constrained(
                table : 'tahun_akademiks',
                indexName: 'jadwal_krs_id_tahun_akademik'
            );
            $table->foreignId('id_fakultas')->constrained(
                table: 'fakultas',
                indexName: 'jadwal_krs_id_fakultas'
            );
            $table->dateTime('tgl_mulai')->nullable();
            $table->dateTime('tgl_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_krs');
    }
};
