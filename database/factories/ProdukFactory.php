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
            'nama_produk' => $this->faker->name(),
            'kategori_id' => '03495cd3-4b90-4e6e-8839-9f682d38d6d8',
            'gudang_id' => '46244f77-345c-4947-8687-26e5984e40c9',
            'kode' => $this->faker->ean13,
            'merek' => $this->faker->company,
            'satuan' => $this->faker->randomElement(['Pcs', 'Box', 'Karton', 'Kg', 'Meter']),
            'minimal_stok' => $this->faker->randomElement([5, 6, 7, 8, 9, 10]),
            'stok' => $this->faker->randomElement([10, 20, 30, 40, 50]),
            'gambar1' => null,
            'gambar2' => null,
            'gambar3' => null,
            'keterangan' => $this->faker->sentence(20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
