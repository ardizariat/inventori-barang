<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Gudang;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 5; $i++) {
            $count = Gudang::count();
            $count++;
            DB::table('gudang')->insert([
                'id' => Str::uuid(),
                'nama' => $faker->name(),
                'kode' =>  kode($count++, 4),
                'lokasi' => $faker->address(),
                'status' => $faker->randomElement(['aktif', 'tidak aktif']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
