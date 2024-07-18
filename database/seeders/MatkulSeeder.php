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
            'kode_matkul' => 'IF2032', 
            'id_prodi' => 1, 
            'nama_matkul' => 'Pemrogram Web', 
            'sks' => 3,
            'semester' => '3',
        ]);
    }
}
