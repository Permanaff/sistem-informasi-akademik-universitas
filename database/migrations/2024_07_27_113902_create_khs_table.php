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
        Schema::create('khs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_krs')->constrained(
                table : 'krs',
                indexName: 'khs_id_krs'
            );
            $table->integer('uts');
            $table->integer('nilai');
            $table->integer('cpmk1');
            $table->integer('cpmk2');
            $table->integer('cpmk3');
            $table->integer('cpmk4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
