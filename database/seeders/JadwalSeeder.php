<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwals')->insert([
            [
                'id_matkul' => 1,
                'id_kelas' => 1,
                'id_ta' => 2, 
                'nidn' => 1234567,
                'kls' => 'A',
                'hari' => 'senin',
                'jam_mulai' => '07:00',
                'jam_selesai' => '09:30',
                'kuota' => '60',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_matkul' => 1,
                'id_kelas' => 1,
                'id_ta' => 2, 
                'nidn' => 1234567,
                'kls' => 'B',
                'hari' => 'Senin',
                'jam_mulai' => '09:40',
                'jam_selesai' => '12:10',
                'kuota' => '60',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_matkul' => 2,
                'id_kelas' => 2,
                'id_ta' => 2, 
                'nidn' => 2345678,
                'kls' => 'A',
                'hari' => 'Rabu',
                'jam_mulai' => '09:40',
                'jam_selesai' => '12:10',
                'kuota' => '60',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_matkul' => 3,
                'id_kelas' => 3,
                'id_ta' => 2, 
                'nidn' => 2345678,
                'kls' => 'A',
                'hari' => 'kamis',
                'jam_mulai' => '09:40',
                'jam_selesai' => '12:10',
                'kuota' => '60',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_matkul' => 4,
                'id_kelas' => 4,
                'id_ta' => 2, 
                'nidn' => 1234567,
                'kls' => 'A',
                'hari' => 'kamis',
                'jam_mulai' => '09:40',
                'jam_selesai' => '12:10',
                'kuota' => '60',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
