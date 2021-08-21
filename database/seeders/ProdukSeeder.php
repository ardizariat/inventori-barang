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
                'kategori_id' => $faker->randomElement([
                    '09fb16b4-b969-483b-9a39-1a24bbdeaae4',
                    '0f080796-f663-4c65-80bb-b2e6ada8ef4c',
                    '29ee0d99-c0ab-44fd-bbcb-339c339e3979',
                    '3c2150ec-8195-4523-a793-76bfa2dc2ba0',
                    '47a46b1c-af1c-47b4-896b-6e0dc9a74245'
                ]),
                'supplier_id' => $faker->randomElement([
                    '00091423-eeae-45c8-a4b5-258fc438a747',
                    '141f5e53-5bc8-469f-a3c8-f78f99693227',
                    '154b50fe-304b-4e8e-a6ff-f9df9ba22ed4',
                    '5d5dff32-e0ae-46da-a894-ed57d41d7c03',
                    '64916cd1-9db5-4cdb-82c5-3cc0b9365bde',
                ]),
                'gudang_id' => $faker->randomElement([
                    '3375c679-b061-4881-a5eb-e0adbb6a573b',
                    '3c1db84a-9ea3-4ac1-9879-3d36a387e7b6',
                    '80d194d6-78f1-4828-b6e2-456c312c4027',
                    '9ed47163-d858-490b-b9b4-ff6859ccfe47',
                    'fc713605-2bfa-4e22-9e75-32c7fdf5c584'
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
