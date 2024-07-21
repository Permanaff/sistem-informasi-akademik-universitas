<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'no_induk' => '5230411001',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa', 
            ],
            [
                'no_induk' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin', 
            ],
            [
                'no_induk' => '1234567',
                'password' => Hash::make('12345'),
                'role' => 'dosen', 
            ],
        ]);
    }
}
