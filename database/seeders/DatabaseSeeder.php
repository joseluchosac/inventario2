<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Identity;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IdentitySeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class,
            ReasonSeeder::class,
        ]);

        Customer::factory(80)->create();
        Supplier::factory(10)->create();
        Product::factory(100)->create();


        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
