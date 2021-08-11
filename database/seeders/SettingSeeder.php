<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id' => Str::uuid(),
            'nama_aplikasi' => 'Inventory',
            'telepon' => '085780258444',
            'logo' => null,
            'alamat' => 'Jl. Dahlia',
            'deskripsi' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
