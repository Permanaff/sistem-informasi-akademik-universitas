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
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fakultas')->constrained(
                table: 'fakultas',
                indexName: 'prodi_id_fakultas'
            );
            $table->string('kode_prodi');
            $table->string('nama_prodi');
            $table->string('ka_prodi');
            $table->enum('jenjang', ['sarjana', 'magister', 'diploma']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};
