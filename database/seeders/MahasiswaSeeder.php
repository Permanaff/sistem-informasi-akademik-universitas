<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswas')->insert([
            [
                'id_prodi' => 1,
                'id_kelas' => 1,
                'nim' => 5230411001,
                'nama' => 'Andi Zakariya',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2003-02-07',
                'alamat' => 'Sleman',
                'agama' => 'islam',
                'notelp' => '0852145675678',
                'email' => 'andi@dosen.com',
                'jk' => 'laki-laki',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
