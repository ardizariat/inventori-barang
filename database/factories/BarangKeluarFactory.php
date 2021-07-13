<?php

namespace Database\Factories;

use App\Models\BarangKeluar;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangKeluarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BarangKeluar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'produk_id' => '191296af-8b1a-4b8c-83ed-0ea2a55353b6',
            'jumlah' => rand(5, 100),
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
