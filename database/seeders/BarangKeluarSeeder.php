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
                    '5b816ba0-80c6-4c5d-89d8-2ff570cd5cfa',
                    '465d40aa-e1d3-4832-96f3-ed6b5595b1e6',
                    '9a3e1409-b506-4279-b261-769cfca6f0eb',
                    '96729320-0d61-4751-9e94-8c21f8e42ea9',
                    'c13b4ccc-6f29-4d7e-9579-5b8c46aea42c',
                    '758c5dde-10fc-48cb-b54e-43b5519128d3'
                ]),
                'pb_id' => $faker->randomElement([
                    '54007d5e-704d-4ac9-8bc3-1c130f755eda',
                    '66314d44-9b80-46b2-b344-f039140f4cd8',
                    '8b945671-cdfa-4052-badb-6ed8bcb1cd83',
                    'a31444ba-8846-43bd-a897-c65dce82fbab',
                    'f68d85c9-3d1b-4e35-9ac3-c9154d3052d0',
                ]),
                'penerima' => rand(6, 9),
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
