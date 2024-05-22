<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Dynamic generate dummy data
        User::factory(10)->create();

        //Static generate dummy data
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'useraccount@test.com',
            'password' => Hash::make('Password123!'),
        ]);

        //Dynamic generate category dummy data
        Category::factory(2)->create();

        //Dynamic generate product dummy data
        Product::factory(100)->create();
    }
}
