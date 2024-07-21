<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ]);
    }
}
