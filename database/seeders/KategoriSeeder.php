<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
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
            DB::table('kategori')->insert([
                'id' => Str::uuid(),
                'kategori' => $faker->name(),
                'status' => $faker->randomElement(['aktif', 'tidak aktif']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
