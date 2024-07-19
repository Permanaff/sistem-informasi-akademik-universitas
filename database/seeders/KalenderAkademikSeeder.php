<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KalenderAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ka')->insert([
            [
                'id_ta' => 2,
                'minggu' => '1',
                'tgl_mulai' => '2024-02-05',
                'tgl_selesai' => '2024-02-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ta' => 2,
                'minggu' => '3',
                'tgl_mulai' => '2024-02-12',
                'tgl_selesai' => '2024-02-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ta' => 2,
                'minggu' => '4',
                'tgl_mulai' => '2024-02-20',
                'tgl_selesai' => '2024-02-26',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
