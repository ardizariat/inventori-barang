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
            'produk_id' => '0136f870-0cef-48fd-8094-e267606001a0',
            'jumlah' => rand(5, 100),
            'penerima' => $this->faker->randomElement(['Ardi', 'Zaid', 'Lia', 'Azmi', 'Hamzah']),
            'pemberi' => $this->faker->randomElement(['Ardi', 'Zaid', 'Lia', 'Azmi', 'Hamzah']),
            'keterangan' => $this->faker->sentence(),
            'tanggal' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
