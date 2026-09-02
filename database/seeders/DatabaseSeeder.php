<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\cases;
use App\Models\Slide;
use App\Models\AiAnalysis;
use App\Models\DoctorReview;
use App\Models\Report;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Doctor
        |--------------------------------------------------------------------------
        */

        $doctor = User::factory()->create([
            'name' => 'Dr. Ahmad Pathologist',
            'email' => 'doctor@pathology.test',
            'role' => 'doctor',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Patients
        |--------------------------------------------------------------------------
        */

        $patients = Patient::factory()
            ->count(10)
            ->create();


         /*
        |--------------------------------------------------------------------------
        | Cases + Slides + AI + Reviews + Reports
        |--------------------------------------------------------------------------
        */

        foreach ($patients as $patient) {

            $case = cases::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
            ]);


            $slides = Slide::factory()
                ->count(fake()->numberBetween(1, 3))
                ->create([
                    'case_id' => $case->id,
                ]);


            foreach ($slides as $slide) {

                AiAnalysis::factory()->create([
                    'slide_id' => $slide->id,
                ]);


                DoctorReview::factory()->create([
                    'slide_id' => $slide->id,
                    'doctor_id' => $doctor->id,
                ]);


                Report::factory()->create([
                    'slide_id' => $slide->id,
                    'doctor_id' => $doctor->id,
                ]);
            }
        }
    }
}
