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
            $table->integer('nilai')->nullable();
            $table->integer('cpmk1')->nullable();
            $table->integer('cpmk2')->nullable();
            $table->integer('cpmk3')->nullable();
            $table->integer('cpmk4')->nullable();
            $table->integer('uts')->nullable();
            $table->integer('uas')->nullable();
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
