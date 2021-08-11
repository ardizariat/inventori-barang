<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\SupplierSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(SettingSeeder::class);
        // $this->call(RolePermissionSeeder::class);
        // $this->call(KategoriSeeder::class);
        // $this->call(GudangSeeder::class);
        // $this->call(SupplierSeeder::class);
        // $this->call(ProdukSeeder::class);
        $this->call(BarangMasukSeeder::class);
        $this->call(BarangKeluarSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
