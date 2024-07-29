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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_matkul')->constrained(
                table: 'matkuls',
                indexName: 'jadwal_id_matkul'
            );
            $table->foreignId('id_kelas')->constrained(
                table: 'gedungs',
                indexName: 'jadwal_id_kelas'
            );
            $table->foreignId('id_ta')->constrained(
                table: 'tahun_akademiks',
                indexName: 'jadwals_id_ta'
            );
            // $table->foreignId('id_dosen')->constrained(
            //     table : 'dosens',
            //     indexName: 'jadwal_id_dosen'
            // );
            $table->string('nidn', 10);
            $table->foreign('nidn')->references('nidn')->on('dosens');    
            $table->string("kls");
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
