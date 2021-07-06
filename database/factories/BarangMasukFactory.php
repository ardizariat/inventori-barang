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
            'produk_id' => 'efeb7730-c9af-4b97-8e29-108c46eaaa07',
            'jumlah' => rand(5, 100),
            'satuan' => $this->faker->randomElement(['Pcs', 'Karton', 'Box', 'Jerigen']),
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
