<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangKeluarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'produk_id' => '042db398-c944-4777-a13f-ce730406358e',
            'jumlah' => rand(5, 100),
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
