<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\cases;

/**
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'case_id' => cases::factory(),

            'file_name' => 'slide_H&E_' . fake()->numberBetween(0, 3) . '.tiff',

            'storage_path' => 'slides/demo/slide_' . fake()->unique()->numerify('#####') . '.tiff',
            
            'case_mapping' => 'demo/case_' . fake()->numberBetween(1, 200),

            'dataset_group' => 'HISTAI-gastrointestinal',
        ];
    }
}
