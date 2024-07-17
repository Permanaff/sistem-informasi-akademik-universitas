<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fakultas')->insert([
            [
                'nama_fakultas' => 'Sains dan Teknologi'
            ],
            [
                'nama_fakultas' => 'Bisnis dan Humaniora'
            ]
        ]);
    }
}
