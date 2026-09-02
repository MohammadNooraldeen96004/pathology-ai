<?php

namespace Database\Factories;

use App\Models\cases;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\User;

/**
 * @extends Factory<cases>
 */
class CasesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = cases::class;
    public function definition(): array
    {
        
        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => User::factory(),

            'case_number' => 'CASE-' . fake()->unique()->numerify('#####'),

            'specialization' => fake()->randomElement([
                'Gastrointestinal',
                'Breast',
                'Lung',
                'Skin',
            ]),

            'icd10' => fake()->randomElement([
                'C18.7',
                'D12.5',
                'K29.4',
            ]),

            'diagnosis' => fake()->sentence(),

            'conclusion' => fake()->paragraph(),

            'diff_diagnostic' => null,

            'grossing' => fake()->paragraph(),

            'micro_protocol' => fake()->paragraph(),

            'additional_info' => null,

            'status' => fake()->randomElement([
                'pending',
                'processing',
                'completed',
            ]),
        ];
    }
}
