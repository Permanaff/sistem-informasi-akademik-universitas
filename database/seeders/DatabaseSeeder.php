<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        

        $this->call([
            UserSeeder::class,
            FakultasSeeder::class,
            ProdiSeeder::class,
            GedungSeeder::class,
            MatkulSeeder::class,
            DosenSeeder::class,
            TahunAjarSeeder::class,
            KalenderAkademikSeeder::class,
            JadwalSeeder::class,
            KelasSeeder::class,
            MahasiswaSeeder::class,
            JadwalKrsSeeder::class,
        ]);

        // Generate Mahasiswa data first
        // Mahasiswa::factory(10)->create()->each(function ($mahasiswa) {
        //     // Create User with no_induk same as nim
        //     User::factory()->create([
        //         'no_induk' => $mahasiswa->nim,
        //     ]);
        // });
        $count = 59;

        DB::transaction(function () use ($count) {
            // Generate Mahasiswa data first
            Mahasiswa::factory($count)->create()->each(function ($mahasiswa) {
                // Create User with no_induk same as nim
                User::factory()->create([
                    'no_induk' => $mahasiswa->nim,
                ]);
            });
        });
    }
}
