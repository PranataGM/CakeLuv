<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Best Sellers', 'slug' => 'best-sellers'],
            ['id' => 2, 'name' => 'Trending Now', 'slug' => 'trending-now'],
            ['id' => 3, 'name' => 'Birthday', 'slug' => 'birthday'],
            ['id' => 4, 'name' => 'Anniversary', 'slug' => 'anniversary'],
            ['id' => 5, 'name' => 'Lilin & Aksesoris', 'slug' => 'lilin-aksesoris'],
        ];

        DB::table('categories')->insert($categories);
    }
}
