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
        $faker = \Faker\Factory::create('id_ID');
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        for ($i = 1; $i <= 500; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->productName,
                'kategori_id' => $faker->randomElement([
                    '0c297618-c771-4f14-b449-21183f74748b',
                    '0ccaf1f0-e359-4407-996c-8923eb62ec03',
                    '1a613c5b-0513-4ee2-adec-f46a07b0ac07',
                    '388083ad-412a-4934-9961-02df30fa4be2',
                    '5a50a68a-9faa-459c-88bc-e7d912440f3d',
                    '6dfebd97-31fc-43fe-82a9-ac7364566c5d',
                    'b6818101-2783-41a1-970e-c9715430b75a',
                    'c9d9b75a-72d2-47fc-a17b-e61c8edfb09f',
                    'd4806aad-54ca-4860-97dc-a2b147207271',
                    'f4485e85-0c02-40ef-98b9-d86a31f60ae2'
                ]),
                'supplier_id' => $faker->randomElement([
                    '00091423-eeae-45c8-a4b5-258fc438a747',
                    '141f5e53-5bc8-469f-a3c8-f78f99693227',
                    '154b50fe-304b-4e8e-a6ff-f9df9ba22ed4',
                    '5d5dff32-e0ae-46da-a894-ed57d41d7c03',
                    '64916cd1-9db5-4cdb-82c5-3cc0b9365bde',
                ]),
                'gudang_id' => $faker->randomElement([
                    '88accb7f-10b9-4eb1-b0b3-adb2e7a34dc4',
                    'bd6643d5-87f4-46cc-a670-2a80ce85072b',
                    'c3f36a62-8a60-4fbd-87fc-ad00679dd9d5',
                    'f5148f33-5a27-46fd-95c5-2b89f37c7ac0',
                    'f93ebec3-37f4-4411-ae2f-d60ff74b89dd'
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
