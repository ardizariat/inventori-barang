<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            DB::table('suppliers')->insert([
                'id' => Str::uuid(),
                'nama' => $faker->company(),
                'email' => $faker->unique()->safeEmail,
                'telpon' => $faker->phoneNumber(),
                'alamat' => $faker->address(),
                'status' => $faker->randomElement(['aktif', 'tidak aktif']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
