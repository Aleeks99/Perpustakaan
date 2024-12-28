<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Returning>
 */
class ReturningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $detail = ['due', 'overdue'];
        return [
            //
            'returned_date' => now(),
            'detail' => $detail[rand(0,1)],
            'fine_fee' => 0
        ];
    }
}
