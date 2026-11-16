<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCaseRequest extends FormRequest
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
                'min:0',
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
            'icd10' => [
                'nullable',
                'string',
                'max:100',
            ],

            'grossing' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'micro_protocol' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'diff_diagnostic' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'diagnosis' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'conclusion' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }
}
