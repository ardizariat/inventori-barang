<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produk::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_produk' => $this->faker->lastName(),
            'kategori_id' => '95b93e0d-f30c-41ed-9ee1-467fb53d229b',
            'gudang_id' => '398dc6b0-8563-4567-8f04-d0637628a6bb',
            'kode' => $this->faker->ean13,
            'merek' => $this->faker->company,
            'satuan' => $this->faker->randomElement(['Pcs', 'Box', 'Karton', 'Kg', 'Meter']),
            'minimal_stok' => $this->faker->randomElement([5, 6, 7, 8, 9, 10]),
            'stok' => $this->faker->randomElement([10, 20, 30, 40, 50]),
            'gambar' => null,
            'keterangan' => $this->faker->sentence(20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
