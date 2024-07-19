<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prodis')->insert([
            [
                'id_fakultas' => 1,
                'kode_prodi' => 'IF',
                'nama_prodi' => 'Informatika',
                'ka_prodi' => 'admin',
                'jenjang' => 'sarjana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
