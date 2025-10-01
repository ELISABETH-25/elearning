<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'student',
            ]),
            'kelas_id' => mt_rand(1, 3),
            'domisili' => fake()->city(),
            'nis' => fake()->unique()->numerify('##########'),
            'phone' => fake()->unique()->numerify('08##########'),
            'date_of_birth' => fake()->date('Y-m-d'),
            'gender' => fake()->randomElement(['L', 'P']),
            'wali' => fake()->name(),
            'alamat' => fake()->address(),
            'angkatan' => fake()->date('Y-m-d'),
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Hindu', 'Budha']),
            'foto' => null,
        ];
    }
}
