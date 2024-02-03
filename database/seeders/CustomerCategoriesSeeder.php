<?php

namespace Database\Seeders;

use App\Enums\CategoryEnum;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        Category::create([
            'name' => 'Trading',
            'type' => CategoryEnum::CUSTOMER_CLASSIFICATION,
        ]);

        Category::create([
            'name' => 'Jobber',
            'type' => CategoryEnum::CUSTOMER_CLASSIFICATION,
        ]);

        Category::create([
            'name' => 'Distributor',
            'type' => CategoryEnum::CUSTOMER_CLASSIFICATION,
        ]);

        Category::create([
            'name' => 'Farm Manager',
            'type' => CategoryEnum::CUSTOMER_CLASSIFICATION,
        ]);
    }
}
