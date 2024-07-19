<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gedungs')->insert([
            [
                'gedung' => 'K1',
                'no_ruang' => 'E.1.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gedung' => 'K1',
                'no_ruang' => 'E.1.2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gedung' => 'K1',
                'no_ruang' => 'E.1.3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gedung' => 'K1',
                'no_ruang' => 'E.1.4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
