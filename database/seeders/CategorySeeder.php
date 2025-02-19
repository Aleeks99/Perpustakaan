<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Category::factory(5)->has(Book::factory(3))->create();
        Category::create([
            'name' => 'History'
        ]);
        Category::create([
            'name' => 'Science'
        ]);
        Category::create([
            'name' => 'Technology'
        ]);
    }
}
