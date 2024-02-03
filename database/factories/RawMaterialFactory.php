<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawMaterial>
 */
class RawMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = strtoupper($this->faker->bothify('???'));
        $name = ucfirst($this->faker->words(2, true));
        $quantity = number_format($this->faker->randomFloat(2, 1, 100), 2);
        $unit = $this->faker->randomElement(['ml', 'mg', 'kg', 'grams', 'liter']);

        return [
            'code' => $code,
            'name' => $name,
            'quantity' => $quantity,
            'unit' => $unit,
        ];
    }
}
