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
        for ($i = 1; $i <= 50; $i++) {
            DB::table('produk')->insert([
                'id' => Str::uuid(),
                'nama_produk' => $faker->lastName(),
                'kategori_id' => '4c23294d-6787-4569-83de-a2237c29e32a',
                'gudang_id' => '703e611d-78ec-42ca-9250-e7f9a929c27e',
                'kode' => $faker->ean13,
                'merek' => $faker->company,
                'satuan' => $faker->randomElement(['Pcs', 'Box', 'Karton', 'Kg', 'Meter']),
                'minimal_stok' => $faker->randomElement([5, 6, 7, 8, 9, 10]),
                'stok' => $faker->randomElement([10, 20, 30, 40, 50]),
                'gambar' => null,
                'keterangan' => $faker->sentence(20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
