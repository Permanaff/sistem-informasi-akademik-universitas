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
                'nidn' => 1234567,
                'id_prodi' => 1,
                'angkatan' => '2023'
            ],
            [
                'nama' => 'B',
                'nidn' => 2345678,
                'id_prodi' => 1,
                'angkatan' => '2023'
            ],
        ]);
    }
}
