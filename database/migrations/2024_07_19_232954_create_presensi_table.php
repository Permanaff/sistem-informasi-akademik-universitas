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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal')->constrained(
                table: 'jadwals',
                indexName: 'riwayat_absen_id_absen'
            );
            $table->string('nim', 10);
            $table->foreign('nim')->references('nim')->on('mahasiswas');
            $table->tinyInteger('pertemuan');
            $table->enum('ket', ['A', 'H', 'S', "I"])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
