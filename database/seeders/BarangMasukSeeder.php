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
        for ($i = 1; $i <= 20; $i++) {
            DB::table('barang_masuk')->insert([
                'id' => Str::uuid(),
                'produk_id' => '07dd615b-6fa9-47f3-8ffe-ad8d72a32ed1',
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
