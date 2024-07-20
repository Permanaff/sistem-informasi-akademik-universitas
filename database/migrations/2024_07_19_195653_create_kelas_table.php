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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('id_dosen')->constrained(
                table: 'dosens',
                indexName: 'kelas_id_dosen'
            );
            $table->foreignId('id_prodi')->constrained(
                table: 'prodis',
                indexName: 'kelas_id_prodis'
            );
            $table->string('angkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
