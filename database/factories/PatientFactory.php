<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_code' => 'PAT-' . fake()->unique()->numerify('#####'),
            'age' => fake()->numberBetween(18, 90),
            'gender' => fake()->randomElement(['m', 'f']),
        ];
    }
}
