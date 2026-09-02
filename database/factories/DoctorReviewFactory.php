<?php

namespace Database\Factories;

use App\Models\DoctorReview;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slide;
use App\Models\User;

/**
 * @extends Factory<DoctorReview>
 */
class DoctorReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slide_id' => Slide::factory(),

            'doctor_id' => User::factory(),

            'decision' => fake()->randomElement([
                'suspicious',
                'benign',
                'malignant',
            ]),

            'notes' => fake()->paragraph(),

            'reviewed_at' => now(),
        ];
    }
}
