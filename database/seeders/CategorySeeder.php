<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Otros',
                'description' => 'Otros artículos',
            ],
            [
                'name' => 'Electrónicos',
                'description' => 'Artículos electrónicos y gadgets',
            ],
            [
                'name' => 'Ropa',
                'description' => 'Ropa y accesorios',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar',
            ],
            [
                'name' => 'Deportes',
                'description' => 'Artículos deportivos y aire libre',
            ],
            [
                'name' => 'Juguetes',
                'description' => 'Juguetes y juegos',
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
