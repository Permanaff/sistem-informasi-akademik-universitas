<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tahun_ajars')->insert([
            [
                'tahun_ajaran' => '2023/2024',
                'semester' => 'ganjil',
                'status' => 'non-aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2023/2024',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
