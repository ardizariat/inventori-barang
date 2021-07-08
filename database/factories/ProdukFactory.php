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
            'kategori_id' => '0638a4ae-1a9c-482f-ba36-4f2742762231',
            'gudang_id' => '0209d828-42ec-416b-9461-c056ea163fcb',
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
