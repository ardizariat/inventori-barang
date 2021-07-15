<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Ardi Nor Dzariat',
            'username' => 'ardi',
            'email' => 'ardizariat@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('admin123'), // password
            'remember_token' => Str::random(10),
            'status' =>  'aktif',
            // 'name' => $this->faker->name(),
            // 'username' => $this->faker->unique()->name(),
            // 'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => bcrypt('admin123'), // password
            // 'remember_token' => Str::random(10),
            // 'status' =>  $this->faker->randomElement(['aktif', 'ditangguhkan', 'tidak aktif']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
