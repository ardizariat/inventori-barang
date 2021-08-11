<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Gudang;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangKeluarSeeder extends Seeder
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
            DB::table('barang_keluar')->insert([
                'id' => Str::uuid(),
                'produk_id' => $faker->randomElement([
                    '0000653c-4494-4fdc-bef2-a55579605a5d',
                    '001b3c0a-1f9d-4593-8d2b-a93984f535a5',
                    '004417b4-7305-4356-90ba-79b62131e7f8',
                    '0045acf7-66f5-49cc-a341-fcdcd062ed38',
                    '006472c0-790d-4e7c-937b-c71becd9826a',
                    '0067bbe4-3a36-4006-bb57-a1a3359dbcb7',
                    '0068d776-f12a-4832-a243-bf4a5c3e82ca',
                    '006e9167-a084-4ebc-ac46-08b10e623013',
                    '00a23edb-748c-4448-a052-6a2df949300b'
                ]),
                'jumlah' => rand(5, 100),
                'penerima' => $faker->randomElement(['Ardi', 'Zaid', 'Lia', 'Azmi', 'Hamzah']),
                'pemberi' => $faker->randomElement(['Ardi', 'Zaid', 'Lia', 'Azmi', 'Hamzah']),
                'keterangan' => $faker->sentence(),
                'tanggal' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
