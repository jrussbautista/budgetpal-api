<?php

namespace Database\Seeders;


use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Business Services', 'Car & Auto', 'Coffee', 'Dining', 'Education', 'Entertainment'];

        foreach($categories as $category) {
            Category::create([
                'title' => $category,
                'slug' => Str::slug($category, '-'),
                'type' => 'main',
                'user_id' => 1
            ]);
        }
    }
}
