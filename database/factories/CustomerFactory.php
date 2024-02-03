<?php

namespace Database\Factories;

use App\Enums\CategoryEnum;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agent_id'          => User::where("is_agent", 1)->inRandomOrder()->first()->id,
            'category_id'       => Category::where("type", CategoryEnum::CUSTOMER_CLASSIFICATION)->inRandomOrder()->first()->id,
            'business_name'     => $this->faker->company,
            'tin_number'        => $this->faker->postcode,
            'contact_number'    => $this->faker->e164PhoneNumber,
            'email'             => $this->faker->safeEmail,
            'owner'             => $this->faker->company,
            'address'           => $this->faker->address,
            'area'              => $this->faker->country,
            'terms'             => $this->faker->randomElement([10, 15, 20, 30,50]),
            'credit_limit'      => $this->faker->randomDigit,
        ];
    }
}
