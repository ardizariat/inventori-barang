<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 100; $i++) {
            DB::table('barang_keluar')->insert([
                'id' => Str::uuid(),
                'produk_id' => $faker->randomElement([
                    '51a29ecf-55aa-4a16-97ab-c6ba20e4dfde',
                    'bb5b3ac2-5386-44dd-9cde-03eeba6ee5bc',
                    '16d37676-77fa-4c6a-aa03-4b285f514f3d',
                    'fc47ebf7-49c1-469d-8458-43b91e123ca7',
                    '2b62a76b-2770-4819-8cbe-4ae6f8a16068'
                ]),
                'pb_id' =>  '44df11f9-9858-46ca-a104-43e73f2ad6c9',
                'penerima' => rand(1, 6),
                'qty' => $faker->randomElement([10, 20, 30, 40, 50, 60, 70, 80, 90, 100]),
                'subtotal' => $faker->randomElement([1000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000]),
                'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = 'Asia/Jakarta'),
                'updated_at' =>
                $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = 'Asia/Jakarta'),
                'status' => 'sudah dikeluarkan'
            ]);
        }
    }
}
