<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangMasukSeeder extends Seeder
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
            DB::table('barang_masuk')->insert([
                'id' => Str::uuid(),
                'produk_id' => $faker->randomElement([
                    '00600b97-1c3d-4232-bd70-5f9bf2e1fee7',
                    '008a929b-c359-4b0a-9a9b-5b7caf0c7f05',
                    '0120532c-ee70-4325-8336-54a459a09d82',
                    '01372cfb-e23d-4342-bbba-03361214b0b8'
                ]),
                'po_id' => $faker->randomElement([
                    '2521fc2c-9402-4a75-8f33-68db01d138',
                    'cb61eaec-146c-49fd-b1b9-f4eafb9038',
                    'ff834871-3b55-40fb-9721-32422c6df6',
                ]),
                'penerima' => rand(1, 6),
                'qty' => $faker->randomElement([10, 20, 30, 40, 50, 60, 70, 80, 90, 100]),
                'subtotal' => $faker->randomElement([1000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000]),
                'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = 'Asia/Jakarta'),
                'updated_at' =>
                $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = 'Asia/Jakarta'),
                'status' => 'sudah diterima'
            ]);
        }
    }
}
