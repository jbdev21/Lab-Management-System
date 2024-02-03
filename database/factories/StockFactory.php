<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $manufactureDate = $this->faker->dateTimeBetween('2020-11-01', '2022-12-31');
        $expirationDate = $this->faker->dateTimeBetween($manufactureDate, '2024-12-31');
        $quantity = $this->faker->numberBetween(10, 99);
        
        return [
            'product_id' => $product->id,
            'manufacture_date' => $manufactureDate,
            'expiration_date' => $expirationDate,
            'batch_code' => $this->faker->randomNumber(8),
            'quantity' => $quantity,
        ];
    }
}
