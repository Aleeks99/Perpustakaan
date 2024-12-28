<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'title' => fake()->sentence(mt_rand(2,6)),
            'author' => fake()->name(),
            'publisher' => fake()->firstName(),
            'published_at' => fake()->year(),
            'category_id' => mt_rand(1,3),
            'ISBN' => fake()->isbn10(),
            'description' => fake()->paragraph(mt_rand(10,25)),
            // 'status' => 'available',
        ];
    }
}
