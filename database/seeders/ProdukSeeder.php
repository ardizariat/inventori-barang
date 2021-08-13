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
        for ($i = 1; $i <= 100; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->lastName(),
                'kategori_id' => $faker->randomElement([
                    '099f2feb-f7dc-4ba4-9072-fcebb91425d9',
                    '119e28f0-c9b1-43f6-aebd-a01ab5fa5df4',
                    '1c0019fd-6993-4b68-81b9-40926490b732',
                    '343e965a-6f2d-43e0-8916-f53ac086fc2c',
                    '705def74-144c-4356-9f3b-b8d311be80c8',
                    '894ffaea-afd2-4aac-9001-db283ecd3a25'
                ]),
                'supplier_id' => $faker->randomElement([
                    '1a4afbc3-d190-443e-a29c-70e2d866cd53',
                    '1c6b4e8e-5555-481c-b3fe-6a3fca60cd76',
                    '4d8540ff-9265-46e6-8735-c4ef48ab92b4',
                    '53e38402-c351-4f3b-a15c-59dd2a1b2a84',
                    '58079de4-c215-49d3-910b-9829c02280fc',
                    '93ec0464-c5e4-4333-842a-e56b3735387c',
                    'aa518552-9405-4fcb-8302-e34f823a3efd',
                    'cff6e53e-8cfc-4df0-b89d-d815b94b951d',
                    'ed4d8f09-19bc-4ede-96e5-3813e4fbeee1'
                ]),
                'gudang_id' => $faker->randomElement([
                    '2318bd29-6c0a-4a59-a78d-1368f44536ce',
                    '878682cd-3d1b-4316-8c9b-72824098d4da',
                    'ad229a87-9187-4c47-aeb0-fbebc4017cde',
                    'dac0bab1-0ed1-4f82-81ef-98c995d4f8cf',
                    'ff0df42a-5b87-42f6-8511-25d22c6d9b59'
                ]),
                'kode' => $faker->ean13,
                'merek' => $faker->company,
                'satuan' => $faker->randomElement(['Pcs', 'Box', 'Karton', 'Kg', 'Meter']),
                'minimal_stok' => $faker->randomElement([5, 6, 7, 8, 9, 10]),
                'harga' => $faker->randomElement([1500, 6000, 7000, 8000, 9000, 10000]),
                'stok' => 0,
                'gambar' => null,
                'keterangan' => $faker->sentence(20),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'aktif',
            ]);
        }
    }
}
