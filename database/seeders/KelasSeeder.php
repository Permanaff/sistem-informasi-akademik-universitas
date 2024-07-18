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
                'gedung' => 'K1',
                'no_kelas' => 'E.1.1'
            ],
            [
                'gedung' => 'K1',
                'no_kelas' => 'E.1.2'
            ],
            [
                'gedung' => 'K1',
                'no_kelas' => 'E.1.3'
            ],
            [
                'gedung' => 'K1',
                'no_kelas' => 'E.1.4'
            ],
        ]);
    }
}
