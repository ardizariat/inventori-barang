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
        for ($i = 1; $i <= 500; $i++) {
            DB::table('barang_masuk')->insert([
                'id' => Str::uuid(),
                'produk_id' => $faker->randomElement([
                    '007789fc-38fd-484e-b991-1f2803859972',
                    '00818e1e-dc7c-414f-805a-47620922fa30',
                    '00c33734-bc8a-487c-9235-39b41a70476a',
                    '013a29b7-7ca8-4238-84eb-c9d775d71d67',
                    '015a4b4f-4e8e-4c33-97fe-72caa56e25e5',
                    '015d8bcf-2260-463f-9492-9f3bd10a3360',
                    '01d914b5-5adb-41f2-88c1-33b1bb41ab06',
                    '01f2006c-a7f2-4a96-93d0-fe47f9ae6c34',
                    '022c4807-fa65-4225-827d-3059a15f3689'
                ]),
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
