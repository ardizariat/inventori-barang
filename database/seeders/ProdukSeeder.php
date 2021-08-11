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
        for ($i = 1; $i <= 4000; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->lastName(),
                'kategori_id' => $faker->randomElement([
                    '01f77fcb-f95b-4204-a484-490c34adb9e1',
                    '1cf37eaf-8537-40d1-9d73-5e9f8fdc4975',
                    '48aa3caa-7816-4a04-bc50-9f2789d4083b',
                    '4b67ca24-de1c-494d-afb6-a1d6951153e9',
                    '8a933bdd-9e4e-43a5-8e06-e88257b68d96',
                ]),
                'supplier_id' => $faker->randomElement([
                    '0d2308de-d160-42b4-9e16-c65146806683',
                    '17ab03b4-3f96-4fff-8f2d-6d54c7c6f583',
                    '39e78740-d6f8-49b4-90b2-d753c0e019fe',
                    '49a4df2a-7eab-4bd2-bdc1-7b805936b25c',
                    '54f422e1-afc3-47c3-9992-1721e832162d',
                ]),
                'gudang_id' => $faker->randomElement([
                    '0c1e8e4e-ba3b-4264-8a2f-f77747eab92a',
                    '1a03be93-18f7-4ad2-a853-43d472949b04',
                    '3757377c-028d-4569-a411-9082b3a19b24',
                    '88d0aecd-92c2-4bf1-94c0-f2dafd5cd4fc',
                    'a6b239cc-6f22-43f1-9b4f-e799c78f9dcc'
                ]),
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
