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
                    '150ed824-581d-48dc-b544-c15ba1fca4ba',
                    '229415ee-c155-4051-99a3-7e4438506bfc',
                    '234c1676-3ddf-4df6-8cc1-f6b15800c261',
                    '332c0972-659e-40e6-b312-31cc5494e003',
                    '422e2164-9da0-4ae5-91a3-dec34c83ddae',
                    '5b816ba0-80c6-4c5d-89d8-2ff570cd5cfa'
                ]),
                'pb_id' =>  '39a77c8f-25b0-4337-a62c-79877e099f69',
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
