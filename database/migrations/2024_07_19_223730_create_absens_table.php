<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal')->constrained(
                table: 'jadwals',
                indexName: 'absens_id_jadwal'
            );
            $table->string('pertemuan');
            $table->string('ket');
            $table->string('kode_absen');
            $table->datetime('batas_mulai')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('batas_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
