<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $detail = ['borrow', 'return'];

        return [
            'due_date' => fake()->date(),
            'detail' => $detail[0],
            'extended_count' => 0,
            // 'note' => fake()->sentence(mt_rand(2,6))
        ];
    }
}
