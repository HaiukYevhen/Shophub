<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

         // Users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@shophub.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@shophub.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@shophub.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and accessories.',
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Clothes and fashion accessories.',
        ]);

        $books = Category::create([
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Books and educational materials.',
        ]);

        $games = Category::create([
            'name' => 'Games',
            'slug' => 'games',
            'description' => 'Video games and gaming accessories.',
        ]);

        // Products
        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Wireless Headphones',
            'slug' => 'wireless-headphones',
            'description' => 'Comfortable wireless headphones with noise cancellation.',
            'price' => 89.99,
            'stock' => 25,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Mechanical Keyboard',
            'slug' => 'mechanical-keyboard',
            'description' => 'Mechanical keyboard with RGB backlight.',
            'price' => 119.99,
            'stock' => 15,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Gaming Mouse',
            'slug' => 'gaming-mouse',
            'description' => 'High precision gaming mouse.',
            'price' => 49.99,
            'stock' => 30,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'Classic T-Shirt',
            'slug' => 'classic-t-shirt',
            'description' => 'Comfortable cotton t-shirt.',
            'price' => 24.99,
            'stock' => 50,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'Hoodie',
            'slug' => 'hoodie',
            'description' => 'Warm casual hoodie.',
            'price' => 59.99,
            'stock' => 20,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $books->id,
            'name' => 'Clean Code',
            'slug' => 'clean-code',
            'description' => 'A book about writing clean and maintainable code.',
            'price' => 34.99,
            'stock' => 12,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $books->id,
            'name' => 'Design Patterns',
            'slug' => 'design-patterns',
            'description' => 'A practical guide to software design patterns.',
            'price' => 39.99,
            'stock' => 8,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $games->id,
            'name' => 'Game Controller',
            'slug' => 'game-controller',
            'description' => 'Wireless controller for gaming.',
            'price' => 69.99,
            'stock' => 18,
            'image' => null,
            'is_active' => true,
        ]);
    }
}
