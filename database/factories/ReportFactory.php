<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slide;
use App\Models\User;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
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

            'report_number' => 'RPT-' . fake()->unique()->numerify('#####'),

            'final_notes' => fake()->paragraph(),
        ];
    }
}
