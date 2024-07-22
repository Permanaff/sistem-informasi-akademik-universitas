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
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_mahasiswa')->constrained(
            //     table: 'mahasiswas',
            //     indexName: 'krs_id_mahasiswa'
            // );
            $table->string('nim', 10);
            $table->foreign('nim')->references('nim')->on('mahasiswas');
            $table->foreignId('id_jadwal')->constrained(
                table: 'jadwals',
                indexName: 'krs_id_jadwal'
            );
            $table->enum('status', ['acc', 'belum-acc', 'ditolak'])->default('belum-acc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
