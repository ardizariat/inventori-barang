<?php

namespace Database\Seeders;

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
        for ($i = 1; $i <= 500; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->name,
                'kategori_id' => $faker->randomElement([
                    '0d9c0162-dfb7-4f49-a288-39321c5eef6f',
                    '14613bc4-a39a-4073-96a4-a0907d68df02',
                    '1c5464b7-2082-471c-85e9-51f7afbfa30f',
                ]),
                'supplier_id' => $faker->randomElement([
                    '13c34a4b-8d39-4045-8132-e6ca9da615d5',
                    '3432926e-81fa-4504-bc3f-72b4101012d5',
                    '3a32622d-905b-4bd5-8635-a94597764553',
                ]),
                'gudang_id' => $faker->randomElement([
                    '379ab0f1-aa27-4699-b907-4f4cf56ef80a',
                    '44d4c4fa-b605-40d0-9a19-e7c157b194cf',
                    '4b836281-2e20-4145-bbe8-c5e41b035062',
                ]),
                'kode' => $faker->ean13,
                'merek' => $faker->company,
                'satuan' => $faker->randomElement(['Pcs', 'Box', 'Karton', 'Kg', 'Meter']),
                'minimal_stok' => $faker->randomElement([5, 6, 7, 8, 9, 10]),
                'harga' => $faker->randomElement([1500, 6000, 7000, 8000, 9000, 10000]),
                'stok' => $faker->randomElement([1500, 6000, 7000, 8000, 9000, 10000]),
                'gambar' => null,
                'keterangan' => $faker->sentence(20),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => $faker->randomElement(['aktif', 'tidak aktif']),
            ]);
        }
    }
}
