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
        for ($i = 1; $i <= 100000; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->lastName(),
                'kategori_id' => $faker->randomElement(['3b28a586-b30a-4915-b3c6-4529204355cf', '47df887e-ce9e-461b-8dd4-148d242d5d43', '6482154f-86df-4939-96c1-23e0992d9c04', '65610a3f-586b-4e9f-b374-62ebf80994bd', '946311bc-9e2d-47b0-b980-c9f44e8574e9', 'd27bc026-20f3-4a02-a574-6399a8b9765d']),
                'gudang_id' => $faker->randomElement(['0017c705-1dcb-4c1f-bd97-75243a62b1b5', '0dbf2015-a6e6-457e-8945-22db395df15e', '1719782f-93a1-44c6-a497-944c7cf9981d', '1de4cb76-6f16-49eb-8d3c-8881fc593915', '2020a6c4-ceed-4839-bff1-4001be5a1364']),
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
