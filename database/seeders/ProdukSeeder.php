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
        for ($i = 1; $i <= 500; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->lastName(),
                'kategori_id' => $faker->randomElement([
                    '2edd124e-3320-4e5d-b90f-e4cda865a8e9',
                    '302d3348-a4f9-4b9f-8fc8-0795bbf77729',
                    '4b812bc1-5b7d-48fc-a6c9-9944c5d254f1',
                    '6db245e5-1600-444b-9d2a-51b249f04443',
                    '7bf06de6-0ddc-4eb6-8bf6-874bf7f0fdbb',
                    '7e15fd75-08c2-4dd9-ac78-5789bbb1719c',
                    '95438769-2cc9-45a2-9344-77f6097aadd7',
                    'a2fc6c6b-329f-4a36-a933-bf669e3cfe04',
                    'bb8367a4-73a5-4909-899a-be7d321394aa',
                    'c51183ad-62da-4476-8636-83a7e93c55dc'
                ]),
                'gudang_id' => $faker->randomElement([
                    '593acd4b-97e4-4ccd-92c8-8f20f3774b49',
                    '9d6ef65d-a831-448f-87ce-4178c93929de',
                    '9e356847-eda7-4b2a-914b-23e0a6d62854',
                    'aa45ca3c-2d4b-46c1-9f04-e125a7887647',
                    'd33bcce0-2f62-4e36-9b76-4a317fc87771'
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
