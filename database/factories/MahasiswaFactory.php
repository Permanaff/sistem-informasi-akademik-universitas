<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    private static $number = 2;
    

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID'); // Menggunakan locale Indonesia

        $id_kelas = $this->determineKelas();

        return [
            'nim' => $this->generateNIM(),
            'nama' => $faker->name,
            'tempat_lahir' => $faker->city,
            'tanggal_lahir' => $faker->dateTimeBetween('2000-01-01', '2006-12-31')->format('Y-m-d'),
            'alamat' => $faker->address,
            'id_prodi' => 1,
            'id_kelas' => $id_kelas,
            'agama' => $faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Budha']),
            'notelp' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'jk' => $faker->randomElement(['laki-laki', 'perempuan']),
            // 'status' => $faker->randomElement(['aktif', 'cuti', 'non-aktif']),
            'angkatan' => '2023',
            'status' => 'aktif',
            'photo' => $faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function generateNIM()
    {
        $prefix = '5230411';
        $number = str_pad(self::$number++, 3, '0', STR_PAD_LEFT);
        return $prefix . $number;
    }

    private function determineKelas()
    {
        $latestStudent = Mahasiswa::orderBy('id', 'desc')->first();
        if ($latestStudent) {
            $currentKelas = $latestStudent->id_kelas;
            $countCurrentKelas = Mahasiswa::where('id_kelas', $currentKelas)->count();
            if ($countCurrentKelas >= 60) {
                return $currentKelas + 1;
            }
            return $currentKelas;
        }
        return 1; // Default kelas pertama
    }

}

