<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Gudang;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            DB::table('barang_masuk')->insert([
                'id' => Str::uuid(),
                'produk_id' => '03ceb070-b975-4f7e-81df-20d341997e1a',
                'jumlah' => rand(5, 100),
                'penerima' => $faker->randomElement(['Ardi', 'Zaid', 'Lia', 'Azmi', 'Hamzah']),
                'pemberi' => $faker->randomElement(['Ardi', 'Zaid', 'Lia', 'Azmi', 'Hamzah']),
                'keterangan' => $faker->sentence(),
                'tanggal' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
