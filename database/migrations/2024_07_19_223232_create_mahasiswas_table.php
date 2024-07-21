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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 10)->unique();
            // $table->foreign('nim')->references('no_induk')->on('users');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->foreignId('id_prodi')->constrained(
                table : 'prodis',
                indexName: 'mahasiswa_id_prodi'
            );
            $table->foreignId('id_kelas')->constrained(
                table : 'kelas',
                indexName: 'mahasiswa_id_kelas'
            );
            $table->string('agama')->nullable();
            $table->string('notelp')->nullable();
            $table->string('email')->nullable();
            $table->enum('jk', ['laki-laki', 'perempuan']);
            $table->enum('status', ['aktif', 'cuti', 'non-aktif']);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
