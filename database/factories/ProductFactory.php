<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brandName = 'VITAMINS - ' . $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I']);
        $description = 'Vitamin ' . $this->faker->lexify('??????');
        $abbreviation = 'VIT-' . strtoupper(substr($brandName, -1));
        $unit = $this->faker->randomElement(['grams', 'kilo', 'liter', 'gallon', 'box']);
        $type = $this->faker->randomElement(['OTC', 'WSP', 'OS', 'PMX']);
        $retail_price = $this->faker->numberBetween(100, 999);

        return [
            'brand_name' => $brandName,
            'abbreviation' => $abbreviation,
            'description' => $description. ' ('. $type.')',
            'unit' => $unit,
            'type' => $type,
            'retail_price' => $retail_price
        ];
    }
}
