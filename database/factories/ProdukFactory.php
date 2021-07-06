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
            'kategori_id' => '194d39ed-a19b-4cb0-992c-cf5f668f22a2',
            'gudang_id' => '04e39ea3-b619-4b8b-a57a-2421527db022',
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
