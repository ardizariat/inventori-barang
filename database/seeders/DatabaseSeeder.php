<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\BarangMasukSeeder;

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
        // $this->call(UserSeeder::class);
        $this->call(ProdukSeeder::class);
        // $this->call(PSeeder::class);
        // $this->call(BarangMasukSeeder::class);
        // $this->call(BarangKeluarSeeder::class);
    }
}
