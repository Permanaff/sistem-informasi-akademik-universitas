<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('matkuls')->insert([
            [
                'kode_matkul' => 'IF2032', 
                'id_prodi' => 1, 
                'nama_matkul' => 'Pemrogram Web', 
                'sks' => 3,
                'smt' => 'genap',
                'semester' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_matkul' => '203421-20', 
                'id_prodi' => 1, 
                'nama_matkul' => 'Bahasa & Otomata', 
                'sks' => 3,
                'smt' => 'genap',
                'semester' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_matkul' => '203415-20', 
                'id_prodi' => 1, 
                'nama_matkul' => 'Machine Learning', 
                'sks' => 3,
                'smt' => 'genap',
                'semester' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_matkul' => '203315-20', 
                'id_prodi' => 1, 
                'nama_matkul' => 'Pengantar Analisis Data', 
                'sks' => 3,
                'smt' => 'ganjil',
                'semester' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
