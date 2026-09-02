<?php

namespace Database\Factories;

use App\Models\AiAnalysis;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slide;

/**
 * @extends Factory<AiAnalysis>
 */
class AiAnalysisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $score = fake()->randomFloat(4, 0, 1);

        return [
            'slide_id' => Slide::factory(),

            'model_version' => 'EfficientNetMIL-v1',

            'score' => $score,

            'prediction' => $score >= 0.5814
                ? 'malignant'
                : 'non-malignant',

            'status' => 'completed',

            'analyzed_at' => now(),
        ];
    }
}
