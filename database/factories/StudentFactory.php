<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = ['male', 'female'];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'gender' => $gender[rand(0,1)],
            'phone' => fake()->phoneNumber(),
            // 'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'remember_token' => Str::random(10),
            'nisn' => fake()->unique()->randomNumber(6, true),
            'classroom_id' => mt_rand(1,3)
        ];
    }

    // public function active(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'status' => 1,
    //         ])
    //         ->afterCreating(function (Student $user) {
    //             $user->assignRole('member');
    //         });
    // }
}
