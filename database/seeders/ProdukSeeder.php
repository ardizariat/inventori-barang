<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 1000; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->lastName(),
                'kategori_id' => $faker->randomElement(['0266112b-942a-4f84-ab75-ac5fd9dc6b23', '097a2e37-d5f9-47b2-82be-eb2ab3337c4d', '3934702c-3433-4c78-a603-3c3ff85283bd', '3bacd549-f9ef-48c8-a2c8-40ba3d49cc0b', '68a54e27-98bb-465b-8760-9c75f62b96b5', '7ebca9f3-1a0e-4773-b4aa-836c66a55413']),
                'gudang_id' => $faker->randomElement(['032ce9ec-45d1-4af1-9386-623aacfeb037', '32cdac92-0e65-4228-8bce-038ea7dbbbe1', '4bf9b54b-cf7e-4897-99f5-cf81232404b5', '65be48b9-d461-4b54-8896-2edfd50d0d3a', '803d1303-b0f4-44e0-9be5-606b95a1fbac']),
                'kode' => $faker->ean13,
                'merek' => $faker->company,
                'satuan' => $faker->randomElement(['Pcs', 'Box', 'Karton', 'Kg', 'Meter']),
                'minimal_stok' => $faker->randomElement([5, 6, 7, 8, 9, 10]),
                'stok' => $faker->randomElement([10, 20, 30, 40, 50]),
                'gambar' => null,
                'keterangan' => $faker->sentence(20),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'aktif',
            ]);
        }
    }
}
