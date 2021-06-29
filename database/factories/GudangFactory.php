<?php

namespace Database\Factories;

use App\Models\Gudang;
use Illuminate\Database\Eloquent\Factories\Factory;

class GudangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gudang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'kode' => 'G' . $this->faker->postcode(),
            'lokasi' => $this->faker->address(),
            'status' => $this->faker->randomElement(['aktif', 'tidak aktif']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
