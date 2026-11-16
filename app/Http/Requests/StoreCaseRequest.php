<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => [
                'required',
                'string',
                'max:255',
            ],

            'age' => [
                'required',
                'integer',
                'min:1',
                'max:120',
            ],

            'gender' => [
                'required',
                'in:Male,Female',
            ],

            'specialization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'icd10' => [
                'nullable',
                'string',
                'max:100',
            ],

            'clinical_information' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'expected_slides' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }
}
