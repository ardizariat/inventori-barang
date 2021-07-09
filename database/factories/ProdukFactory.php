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
            'kategori_id' => '0cd68844-d327-4194-878d-6bd07a61b107',
            'gudang_id' => '0d628c84-8052-4d75-9543-093da99fe09d',
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
