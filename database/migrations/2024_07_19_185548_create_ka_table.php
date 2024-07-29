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
        Schema::create('ka', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ta')->constrained(
                table: 'tahun_akademiks',
                indexName: 'ka_id_ta'
            );
            $table->enum('minggu', [1,2,3,4,5,6,7,8,9,10,11,12,13,14, 'uts', 'uas']);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ka');
    }
};
