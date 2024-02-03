<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Fund;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ledger>
 */
class LedgerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'fund_id' => Fund::inRandomOrder()->first()->id,
            'particulars' => $this->faker->paragraph(),
            'amount' => $this->faker->randomDigit(),
            'type' => $this->faker->randomElements(['debit','credit'])[0],
        ];
    }
}
