<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dosens')->insert([
            [
                'id_fakultas' => 1,
                'nidn' => 1234567,
                'nama' => 'Ahmad Subarjo,S.Kom.,M.Kom.',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1990-02-07',
                'alamat' => 'Sleman',
                'agama' => 'islam',
                'notelp' => '085212345678',
                'email' => 'subarjo@dosen.com',
                'jk' => 'laki-laki',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
