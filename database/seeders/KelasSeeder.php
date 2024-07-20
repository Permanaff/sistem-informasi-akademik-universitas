<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'nama' => 'A',
                'id_dosen' => 1,
                'id_prodi' => 1,
                'angkatan' => '2023'
            ],
        ]);
    }
}
