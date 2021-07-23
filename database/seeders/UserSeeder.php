<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
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
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->unique()->userName,
                'password' => bcrypt('admin'),
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => null,
                'foto' => null,
                'remember_token' => Str::random(10),
                'status' =>  $faker->randomElement(['aktif', 'ditangguhkan', 'tidak aktif']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $roles = $faker->randomElement(['admin', 'user']);
            $permissions = $faker->randomElement(['read', 'create', 'update', 'delete']);
            $user->assignRole([$roles]);
            $user->givePermissionTo([$permissions]);
            $role = Role::find(2);
            $role->givePermissionTo([$permissions]);
        }
    }
}
