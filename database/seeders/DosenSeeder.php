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
            [
                'id_fakultas' => 1,
                'nidn' => 2345678,
                'nama' => 'Budi Santoso, M.Sc., Ph.D.',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1985-11-21',
                'alamat' => 'Surabaya',
                'agama' => 'Kristen',
                'notelp' => '081234567890',
                'email' => 'budi@dosen.com',
                'jk' => 'laki-laki',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_fakultas' => 1,
                'nidn' => 3456789,
                'nama' => 'Citra Dewi, S.Kom., M.Kom.',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1992-06-15',
                'alamat' => 'Bandung',
                'agama' => 'Hindu',
                'notelp' => '089876543210',
                'email' => 'citra@dosen.com',
                'jk' => 'perempuan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
