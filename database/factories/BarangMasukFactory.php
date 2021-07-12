<?php

namespace Database\Factories;

use App\Models\BarangMasuk;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangMasukFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BarangMasuk::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'produk_id' => '148fe2f1-471a-47fd-baab-c8917b042ad9',
            'jumlah' => rand(5, 100),
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
