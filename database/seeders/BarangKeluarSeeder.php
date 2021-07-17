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
        for ($i = 1; $i <= 20; $i++) {
            DB::table('barang_keluar')->insert([
                'id' => Str::uuid(),
                'produk_id' => '0ace6672-01ee-4a74-820d-97b418682c7e',
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
