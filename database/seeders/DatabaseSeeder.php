<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create admin
        $user = User::factory(1)->create(['username' => 'admin']);

        $administrator = Role::create([
            'name'=> 'Administrator',
            'guard_name' => "web"
        ]);

        foreach(config("system.roles_permissions.Users") as $userPermission){
            $administrator->givePermissionTo(Permission::create(['name' => $userPermission])); 
        }

        foreach(config("system.roles_permissions.Categories") as $userPermission){
            $administrator->givePermissionTo(Permission::create(['name' => $userPermission])); 
        }
    
        User::first()->assignRole($administrator);

        //Product List
        Product::factory()->count(50)->create();

        //Raw Material
        RawMaterial::factory()->count(50)->create();

        //Stock Inventory
        Stock::factory()->count(30)->create();

        $this->call([
            CustomerCategoriesSeeder::class,
        ]);

    }
}
