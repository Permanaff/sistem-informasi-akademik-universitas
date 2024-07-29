<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_krs')->insert([
            [
                'id_ta' => 2,
                'id_fakultas' => 1,
                'tgl_mulai' => now(),
                'tgl_selesai' => '2024-08-30 23:59:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
