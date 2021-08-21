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
        // $faker = Faker::create('id_ID');
        // for ($i = 1; $i <= 5; $i++) {
        //     $user = User::create([
        //         'name' => $faker->name,
        //         'username' => $faker->unique()->userName,
        //         'password' => bcrypt('admin'),
        //         'email' => $faker->unique()->safeEmail,
        //         'email_verified_at' => null,
        //         'foto' => null,
        //         'remember_token' => Str::random(10),
        //         'status' =>  $faker->randomElement(['aktif', 'ditangguhkan', 'tidak aktif']),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);

        //     // $roles = $faker->randomElement(['admin', 'user']);
        //     // $permissions = $faker->randomElement(['read', 'create', 'update', 'delete']);
        //     // $user->assignRole([$roles]);
        //     // $user->givePermissionTo([$permissions]);
        //     // $role = Role::find(rand(2, 3));
        //     // $role->givePermissionTo([$permissions]);
        //     // }
        // }

        // admin
        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@gmail.com',
            'email_verified_at' => null,
            'foto' => null,
            'remember_token' => null,
            'status' =>  'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $roles = 'admin';
        $permissions = ['create', 'read', 'update', 'delete'];
        $user->assignRole([$roles]);
        $user->givePermissionTo([$permissions]);
        $role = Role::find(2);
        $role->givePermissionTo([$permissions]);

        // direktur
        $user = User::create([
            'name' => 'Direktur',
            'username' => 'direktur',
            'password' => bcrypt('admin'),
            'email' => 'direktur@gmail.com',
            'email_verified_at' => null,
            'foto' => null,
            'remember_token' => null,
            'status' =>  'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $roles = 'direktur';
        $permissions = ['read', 'update'];
        $user->assignRole([$roles]);
        $user->givePermissionTo([$permissions]);
        $role = Role::find(3);
        $role->givePermissionTo([$permissions]);

        // Dept head
        $user = User::create([
            'name' => 'Departemen Head',
            'username' => 'dept_head',
            'password' => bcrypt('admin'),
            'email' => 'dept_head@gmail.com',
            'email_verified_at' => null,
            'foto' => null,
            'remember_token' => null,
            'status' =>  'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $roles = 'dept_head';
        $permissions = ['read', 'update'];
        $user->assignRole([$roles]);
        $user->givePermissionTo([$permissions]);
        $role = Role::find(4);
        $role->givePermissionTo([$permissions]);

        // Sect head
        $user = User::create([
            'name' => 'Section Head',
            'username' => 'sect_head',
            'password' => bcrypt('admin'),
            'email' => 'sect_head@gmail.com',
            'email_verified_at' => null,
            'foto' => null,
            'remember_token' => null,
            'status' =>  'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $roles = 'sect_head';
        $permissions = ['read', 'update'];
        $user->assignRole([$roles]);
        $user->givePermissionTo([$permissions]);
        $role = Role::find(5);
        $role->givePermissionTo([$permissions]);

        // User
        $user = User::create([
            'name' => 'User',
            'username' => 'user',
            'password' => bcrypt('admin'),
            'email' => 'user@gmail.com',
            'email_verified_at' => null,
            'foto' => null,
            'remember_token' => null,
            'status' =>  'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $roles = 'user';
        $permissions = ['create', 'read'];
        $user->assignRole([$roles]);
        $user->givePermissionTo([$permissions]);
        $role = Role::find(6);
        $role->givePermissionTo([$permissions]);
    }
}
